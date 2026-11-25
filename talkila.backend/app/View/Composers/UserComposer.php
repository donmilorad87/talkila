<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;

class UserComposer
{
    /**
     * The User Model implementation.
     */
    protected $user;

    /**
     * Create a new User composer.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('user', $this->user->current());
    }
}
