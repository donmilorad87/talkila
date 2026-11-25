<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Api\V1\Admin\FeedbackApiController;
use App\Http\Controllers\Api\V1\Admin\TalksApiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Requests\ApiRequests\StoreFeedbackApiRequest;
use App\Http\Requests\ApiRequests\StoreTalkRequest;
use App\Http\Requests\ApiRequests\UpdateTalkRequest;
use App\ModelsApi\Talk;
use Illuminate\Http\Request;

class TalksController extends Controller
{
    public function addTalk(StoreTalkRequest $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $addTalkObject = new TalksApiController();
        $addTalk       = $addTalkObject->store($request)->getData(true);

        return $addTalk;
    }


    public function editTalks(Request $request)
    {
        $loggedUser = UserController::loggedUserData($request);

        $talk_id = $request->input('id');

        if (isset($talk_id) && ! empty($talk_id)) {
            $request->request->add(['talk_id' => $talk_id]);

            $requestedTalkDataObject = new TalksApiController();
            $requestedTalkData       = $requestedTalkDataObject->teacherTalks($request, $loggedUser['data']['id'])->getData(true);

            $requestedTalk = $requestedTalkData['data'][0] ?? [];
        } else {
            $requestedTalk = [];
        }

        return [
            'requestedTalk' => $requestedTalk,
        ];
    }

    public function deleteTalk(Request $request, $talk_id)
    {
        $talk = Talk::query()->where('id', $talk_id)->first();

        $deleteTalkObject = new TalksApiController();
        $deleteTalk       = $deleteTalkObject->destroy($request, $talk)->getData(true);

        return $deleteTalk;
    }

    public function pauseTalk(Request $request, $talkId)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $pauseTalkObject = new TalksApiController();
        $pauseTalk       = $pauseTalkObject->pauseUnpauseTalk($request, $talkId, 2)->getData(true);

        return $pauseTalk;
    }

    public function unPauseTalk(Request $request, $talkId)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $unPauseTalkObject = new TalksApiController();
        $unPauseTalk       = $unPauseTalkObject->pauseUnpauseTalk($request, $talkId, 1)->getData(true);

        return $unPauseTalk;
    }

    public function updateTalk(UpdateTalkRequest $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $talk = Talk::query()->where('id', $request->input('talkId'))->first();

        $updateTalkObject = new TalksApiController();
        $updateTalk       = $updateTalkObject->update($request, $talk)->getData(true);

        return $updateTalk;
    }

    public function store(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $storeTalkObject = new TalksApiController();
        $storeTalk       = $storeTalkObject->store($request)->getData(true);

        return $storeTalk;
    }

    public function storeFeedback(StoreFeedbackApiRequest $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $storeTalkObject = new FeedbackApiController();
        $storeTalk       = $storeTalkObject->store($request)->getData(true);


        return $storeTalk;
    }
}
