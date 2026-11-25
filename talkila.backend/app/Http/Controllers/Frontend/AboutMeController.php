<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Api\V1\Admin\JoinTheClubApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class AboutMeController extends Controller
{
    /**
     * A User model.
     */
    public $user;

    /**
     * App pages names.
     */
    public $pages;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->user  = new User();
        $this->pages = config('pages.names');
    }

    /**
     * Show the About page.
     */
    public function about(Request $request)
    {
        /* dd($this->user->current()->availabilities->sortBy('weekday')); */

        $request->headers->set('Time-Zone-Offset-UTC',  getLocalTimeZone());

        // Current user.
        $user = $request->user();

        $userAvailabilityObject = new JoinTheClubApiController();
        $userAvailability = $userAvailabilityObject->getUserAvailability($request, $user->id)->getData(true);

        return view('frontend.pages.about-me', [
            'page_name'         => $this->pages['about'],
            'userAvailability' => $userAvailability['data'] ?? [],
            'reviews'           => $user->talkReviews()->with('booking.talk')->whereHas('user')->get(),
            'feedbacks'         => $user->feedbacks,
        ]);
    }

     /**
     * Show the About page.
     */
    public function about_me_partial(Request $request)
    {

        $request->headers->set('Time-Zone-Offset-UTC',  getLocalTimeZone());
        $userAvailabilityObject = new JoinTheClubApiController();
        $userAvailability = $userAvailabilityObject->getUserAvailability($request, auth()->user()->id)->getData(true);

        // TODO: Include Talk name
        return view('frontend.partials.pages.about_me.about_me_partial', [
            'page_name'      => $this->pages['about'],
            'availabilities' => $userAvailability['data'] ?? [],
            'reviews'        => $this->user->current()->talkReviews()->with('booking.talk')->get(),
            'feedbacks'      => $this->user->current()->feedbacks,
        ]);
    }

}
