<?php

namespace App\Http\Composers;

use App\Http\Controllers\Api\V1\Admin\NotificationsApiController;
use Illuminate\Contracts\View\View;


class LoggedHeaderComposer{

    public function compose(View $view){
        $view->with('notificationsCount', NotificationsApiController::countUnreadNotifications(request())['data']);
    }

}
