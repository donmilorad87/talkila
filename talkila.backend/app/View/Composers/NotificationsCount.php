<?php

namespace App\View\Composers;

use App\Http\Controllers\Api\V1\Admin\NotificationsApiController;
use Illuminate\View\View;

class NotificationsCount
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     */

    public function compose(View $view)
    {
        $notificationsCount = new NotificationsApiController();
        $response           = $notificationsCount->countUnreadNotifications(request())->getData(true);

        $view->with('notificationsCount', $response['data'] ?? 0);
    }
}
