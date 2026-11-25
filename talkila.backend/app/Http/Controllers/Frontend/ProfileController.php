<?php

namespace App\Http\Controllers\Frontend;

use App\Entity\CallTypes;
use App\Entity\UserTypes;
use App\Http\Controllers\Api\V1\Admin\ProfilCvApiController;
use App\Http\Controllers\Api\V1\Admin\TalksApiController;
use App\Http\Controllers\Api\V1\FrontendApiCalls\UserProfileApiController;
use App\Http\Controllers\Controller;
use App\Models\Talk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getUserAvailability(Request $request)
    {
        $request->headers->set('Time-Zone-Offset-UTC', getLocalTimeZone());
        $userAvailabilityObject = new UserProfileApiController();
        $userAvailability       = $userAvailabilityObject->getUserAvailability($request)->getData(true);

        $start       = strtotime('00:00');
        $end         = strtotime('23:45');
        $lowestTime  = null;
        $highestTime = null;
        $takenTime   = [];

        if (! empty($userAvailability['data'])) {
            foreach ($userAvailability['data'] as $availability) {
                $weekday = [];
                if (! $availability['state']) {
                    continue;
                }
                if (empty($takenTime[$availability['weekday']])) {
                    for ($i = $start; $i <= $end; $i = $i + 15 * 60) {
                        $time = date('H:i:s', $i);
                        array_push($weekday, $time);
                    }
                    $takenTime[$availability['weekday']] = $weekday;
                }
                if (empty($lowestTime)) {
                    $lowestTime = $availability['start_time'];
                } else {
                    if (strtotime($availability['start_time']) < strtotime($lowestTime)) {
                        $lowestTime = $availability['start_time'];
                    }
                }

                if (empty($highestTime)) {
                    $highestTime = $availability['end_time'];
                } else {
                    if (strtotime($availability['end_time']) > strtotime($highestTime)) {
                        $highestTime = $availability['end_time'];
                    }
                }
                foreach ($takenTime[$availability['weekday']] as $key => $day) {
                    if (strtotime($day) >= strtotime($availability['start_time']) && strtotime($day) <= strtotime($availability['end_time'])) {
                        unset($takenTime[$availability['weekday']][$key]);
                    }
                }
            }
        }

        return [
            'availability' => $userAvailability['data'] ?? [],
            'takenTime'    => $takenTime,
            'lowestTime'   => $lowestTime != '00:00:00' ? date('H:i', strtotime("-15 minutes", strtotime($lowestTime))) : date('H:i', strtotime($lowestTime)),
            'highestTime'  => $highestTime != '00:00:00' ? date('H:i', strtotime("+15 minutes", strtotime($highestTime))) : date('H:i', strtotime($highestTime)),
        ];
    }

    public function userProfile(Request $request, User $user)
    {



        $loggedUser = UserController::loggedUserData($request);


        $userObject = new UserProfileApiController();
        $userData   = $userObject->show($request, $user->username)->getData(true);

        if (empty($userData['data'])) {
            return redirect()->route('home');
        } else {
            $requestedUser = $userData['data'];
        }

        if (empty($requestedUser)) {
            Session::flash('alert-success', $userData['message']);
            return redirect()->route('home');
        }

        if (! $requestedUser['account_verified']) {
            return redirect()->route('home');
        }

        if ($requestedUser['type'] && $requestedUser['approved'] != true) {
            Session::flash('alert-info', 'Requested teacher is not approved and cannot be visited.');
            return redirect()->back();
        }

        $request->request->add(['user_id' => $requestedUser['id']]);
        $userFeedbackRatingObject = new UserProfileApiController();
        $userFeedbackRating       = $userFeedbackRatingObject->getTeacherRating($request)->getData(true);

        // $request->request->add(['call_type' => CallTypes::ONE_TO_ONE]);
        $request->request->add(['limit' => 5]);
        $request->request->add(['offset' => 0]);
        $userPublicTalksObject = new TalksApiController();
        $userPublicTalks       = $userPublicTalksObject->teacherTalks($request, $requestedUser['id'])->getData(true);



        $userExperienceObject = new ProfilCvApiController();
        $userExperience       = $userExperienceObject->userCv($request)->getData(true);

        $request->request->add(['user_id' => $requestedUser['id']]);

        $category = $user->load('talks', 'talks.category')
            ->talks
            ->first()
            ->category
            ->loadCount($this->getTalksCount());

        $talk = $user->talks()->where('talk_categories_id', $category->id);

        $subcategory = $talk->first()->subcategory->loadCount($this->getTalksCount());

        $otherTeachers = $subcategory->talks()
            ->with('teacher')
            ->select(\DB::raw('DISTINCT ON (teacher_user_id) *'))
            ->where('teacher_user_id', '!=', $user->id)
            ->whereHas('teacher', function ($query) {
                $query->where('type', UserTypes::PROVIDER);
            })
            ->orderBy('teacher_user_id')
            ->get();

        /**
         * In case the Subcategory has no other teacher, Query the Category for other teachers.
         */
        if ($otherTeachers->isEmpty()) {
            $otherTeachers = Talk::select(\DB::raw('DISTINCT ON (teacher_user_id) *'))
                ->where('teacher_user_id', '!=', $user->id)
                ->where('talk_categories_id', $category->id)
                ->whereHas('teacher_user', function ($query) {
                    $query->join('user_verification_requests', 'users.id', '=', 'user_verification_requests.user_id')
                        ->where('approved', \App\ModelsApi\User::STATE['approved'])
                        ->where('type', User::TYPE['supplier'])
                        ->where('visibility', User::VISIBILITY['open'])
                        ->where('user_verification_requests.status', 1);
                })
                ->orderBy('teacher_user_id')
                ->get();
        }


        return view('frontend.pages.profile', [
            'userData'         => $userData['data'] ?? [],
            'loggedUserData'   => $loggedUser['data'] ?? [],
            /*  'takenTime'               => $takenTime,
             'userAvailability'        => $userAvailability,
             'userLowestAvailability'  => $availabilityData['lowestTime'],
             'userHighestAvailability' => $availabilityData['highestTime'], */
            'userPrivateTalks' => $userPublicTalks['data'] ?? []/* $user->talks()->where('state', '!=', 2)->paginate(5) */,
            'userPublicTalks'  => $userPublicTalks['data'] ?? [],
            'userExperience'   => $userExperience['data'] ?? [],
            'teacherFeedback'  => $userFeedbackRating['data'] ?? [],
            'category'         => $category,
            'talks_count'      => isset($userPublicTalks['talks_count']) ? $userPublicTalks['talks_count'] : 0,
            'subcategory'      => $subcategory,
            'otherTeachers'    => $otherTeachers,
            'message'          => $userPublicTalks['message']
        ]);
    }

    /**
     * @return \Closure[]
     */
    protected function getTalksCount(): array
    {
        return [
            'talks as talks_count' => function ($query) {
                $query->where('teacher_user_id', '!=', auth()->id())
                    ->join('user_verification_requests', 'teacher_user_id', '=', 'user_verification_requests.user_id')
                    ->join('users', 'teacher_user_id', '=', 'users.id')
                    ->where('approved', \App\ModelsApi\User::STATE['approved'])
                    ->where('type', User::TYPE['supplier'])
                    ->where('visibility', User::VISIBILITY['open'])
                    ->where('user_verification_requests.status', 1)
                    ->whereNull('users.deleted_at');
            },
        ];
    }
}
