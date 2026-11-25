<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Api\V1\Admin\FeedbackApiController;
use App\Http\Controllers\Controller;
use App\ModelsApi\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    public $settings = 'Settings';

    public function settingsReviews(Request $request)
    {
        $pointer = $request->pointer;

        $loggedUserData = UserController::loggedUserData($request);

        if ($loggedUserData['data']['type'] != 2) {
            Session::flash('alert-danger', __('PAGE_AVAILABLE_ONLY_FOR_SUPPLIERS'));
            return redirect()->back();
        }

        $userFeedbackRatingObject = new FeedbackApiController();
        $userFeedbackRating = $userFeedbackRatingObject->getRating($request)->getData(true);

        $request->request->add(['user_id' => $loggedUserData['data']['id']]);

        $request->request->add(['feedback_type' => Feedback::TYPE['received']]);
        $teacherFeedbackObject = new FeedbackApiController();
        $teacherFeedback = $teacherFeedbackObject->getTeacherRating($request)->getData(true);

        $request->request->add(['feedback_type' => Feedback::TYPE['given']]);
        $teacherFeedbackGiven = $teacherFeedbackObject->getTeacherRating($request)->getData(true);

        // $notificationsCount = new NotificationsApiController();
        // $notificationsCountData = $notificationsCount->countUnreadNotifications($request)->getData(true);

        $data = $request->all();

        if (!empty($data['offset'])) {
            $request->request->add(['offset' => $data['offset']]);
        }
        if (!empty($data['limit'])) {
            $request->request->add(['limit' => $data['limit']]);
        }
        if (!empty($data['star'])) {
            $request->request->add(['stars_rating' => $data['star']]);
        }
        if (!empty($loggedUserData['data']['id'])) {
            $request->request->add(['user_id' => $loggedUserData['data']['id']]);
        }



        if($pointer == "1") {
            if(isset($teacherFeedback['data']) && !empty($teacherFeedback['data'])){
                return [
                    'totalRatings'          => $teacherFeedback['data']['stars_feedback']['totalRatings'],
                    'totalReviews'          => $teacherFeedback['data']['stars_feedback']['totalReviews'],
                    'teacherAverageRating'  => $teacherFeedback['data']['stars_feedback']['totalRatings'] / ($teacherFeedback['data']['stars_feedback']['totalReviews'] === 0 ? 1 : $teacherFeedback['data']['stars_feedback']['totalReviews']),
                    'teacherFeedback'       => $teacherFeedback['data'] ?? [],
                    'feedbackComments'      => view('frontend.partials.pages.profile.render-feedback-comments', [
                        'page_name'         => $this->settings,
                        'teacherFeedback'   => $teacherFeedback['data'] ?? []
                    ])->render(),
                    'numberOfComments'      => isset($teacherFeedback['data']) ? count($teacherFeedback['data']['feedback_comments']) : 0,
                    'reviewBars'            => view('frontend.partials.components.review-bars', [
                        'teacherFeedback' => $teacherFeedback['data'] ?? [],
                        'pointer'           => 1
                    ])->render()

                ];
            }else{
                return [
                    'noData'        => true,
                    'message'       => $teacherFeedback['message']
                ];
            }


        }else if($pointer == "2") {
            if(isset($teacherFeedbackGiven['data']) && !empty($teacherFeedbackGiven['data'])){
                return [
                    'totalRatings'          => $teacherFeedbackGiven['data']['stars_feedback']['totalRatings'],
                    'totalReviews'          => $teacherFeedbackGiven['data']['stars_feedback']['totalReviews'],
                    'teacherAverageRating'  => $teacherFeedbackGiven['data']['stars_feedback']['totalRatings'] / ($teacherFeedbackGiven['data']['stars_feedback']['totalReviews'] === 0 ? 1 : $teacherFeedbackGiven['data']['stars_feedback']['totalReviews']),
                    'teacherFeedback'       => $teacherFeedbackGiven['data'] ?? [],
                    'feedbackComments'      => view('frontend.partials.pages.profile.render-feedback-comments', [
                        'page_name'         => $this->settings,
                        'teacherFeedback'   => $teacherFeedbackGiven['data'] ?? []
                    ])->render(),
                    'numberOfComments'      => isset($teacherFeedbackGiven['data']) ? count($teacherFeedbackGiven['data']['feedback_comments']) : 0,
                    'reviewBars'            => view('frontend.partials.components.review-bars', [
                        'teacherFeedback' => $teacherFeedbackGiven['data'] ?? [],
                        'pointer'           => 2
                    ])->render()

                ];
            }else{
                return [
                    'noData'    => true,
                    'message'   => $teacherFeedbackGiven['message']
                ];
            }

        }else{


            return view('frontend.pages.settings_reviews', [
                'page_name'          => $this->settings,
                'userFeedbackRating' => $userFeedbackRating['data'] ?? [],
                'userData'           => $loggedUserData['data'],
                'teacherFeedback'    => $teacherFeedback['data'] ?? [],
                'teacherFeedbackGiven'    => $teacherFeedbackGiven['data'] ?? [],
                'feedbackComments'   =>  view('frontend.partials.pages.profile.render-feedback-comments', [
                    'page_name'       => $this->settings,
                    'teacherFeedback' => $teacherFeedback['data'] ?? []
                ])->render(),
                'feedbackGivenComments' =>  view('frontend.partials.pages.profile.render-feedback-comments', [
                    'page_name'       => $this->settings,
                    'teacherFeedback' => $teacherFeedbackGiven['data'] ?? []
                ])->render(),
                'numberOfComments'   => isset($teacherFeedback['data']) ? count($teacherFeedback['data']['feedback_comments']) : 0,
                'numberOfGivenComments'   => isset($teacherFeedbackGiven['data']) ? count($teacherFeedbackGiven['data']['feedback_comments']) : 0,
                'loggedUserData'     => $loggedUserData['data'],
                // 'notificationsCount' => $notificationsCountData['data'] ?? 0,
            ]);
        }
    }

    public function settingsReviewsPartial(Request $request)
    {

        $pointer = $request->pointer;

        $request->request->add(['user_id' => auth()->user()->id]);

        if($pointer == 1) {

            $request->request->add(['feedback_type' => Feedback::TYPE['received']]);
            $teacherFeedbackObject = new FeedbackApiController();
            $teacherFeedback = $teacherFeedbackObject->getTeacherRating($request)->getData(true);

            return [
                'html' => view('frontend.partials.pages.profile.render-feedback-comments', [
                    'page_name'       => $this->settings,
                    'teacherFeedback' => $teacherFeedback['data'] ?? []
                ])->render(),
                'totalReviews'  => $teacherFeedback['data']['stars_feedback']['totalReviews']
            ];
        }else if($pointer == 2) {

            $request->request->add(['feedback_type' => Feedback::TYPE['given']]);
            $teacherFeedbackObject = new FeedbackApiController();
            $teacherFeedbackGiven = $teacherFeedbackObject->getTeacherRating($request)->getData(true);

            return [
                'html' => view('frontend.partials.pages.profile.render-feedback-comments', [
                    'page_name'       => $this->settings,
                    'teacherFeedback' => $teacherFeedbackGiven['data'] ?? []
                ])->render(),
                'totalReviews'  => $teacherFeedbackGiven['data']['stars_feedback']['totalReviews']
            ];

        }
    }

    public function getFeedbackComments(Request $request)
    {
        $loggedUserData = UserController::loggedUserData($request);
        $data = $request->all();

        if (!empty($data['offset'])) {
            $request->request->add(['offset' => $data['offset']]);
        }
        if (!empty($data['limit'])) {
            $request->request->add(['limit' => $data['limit']]);
        }
        if (!empty($data['star'])) {
            $request->request->add(['stars_rating' => $data['star']]);
        }
        if (!empty($loggedUserData['data']['id'])) {
            $request->request->add(['user_id' => $loggedUserData['data']['id']]);
        }
        if (!empty($data['pointer'])) {
            if($data['pointer'] == 1){
                $request->request->add(['feedback_type' => Feedback::TYPE['received']]);
            }else if($data['pointer'] == 2){
                $request->request->add(['feedback_type' => Feedback::TYPE['given']]);
            }

        }

        $teacherFeedbackObject = new FeedbackApiController();
        $teacherFeedback = $teacherFeedbackObject->getTeacherRating($request)->getData(true);
        if(isset($teacherFeedback['data']) && !empty($teacherFeedback['data'])){
            switch ($data['star']) {
                case '1':
                    $stars_total = $teacherFeedback['data']['stars_feedback']['one_stars'];
                    break;
                case '2':
                    $stars_total = $teacherFeedback['data']['stars_feedback']['two_stars'];
                    break;
                case '3':
                    $stars_total = $teacherFeedback['data']['stars_feedback']['three_stars'];
                    break;
                case '4':
                    $stars_total = $teacherFeedback['data']['stars_feedback']['four_stars'];
                    break;
                case '5':
                    $stars_total = $teacherFeedback['data']['stars_feedback']['five_stars'];
                    break;

            }
            return [
                'html' => view('frontend.partials.pages.profile.render-feedback-comments', [
                    'teacherFeedback' => $teacherFeedback['data'] ?? []
                ])->render(),
                'total_items'     => count($teacherFeedback['data']['feedback_comments']),
                'stars_total'     => $stars_total
            ];
        }else{
            return [
                'noData'    => true,
                'message'   => $teacherFeedback['message']
            ];
        }

    }

}
