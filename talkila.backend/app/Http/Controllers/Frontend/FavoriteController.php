<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Filters;
use App\Http\Controllers\Api\V1\Admin\TalksApiController;
use App\Http\Controllers\Api\V1\Admin\UserFollowedApiController;
use App\Http\Controllers\Controller;
use App\Models\TalkCategories;
use App\Models\User;
use Illuminate\Http\Request;



class FavoriteController extends Controller
{
    /**
     * A Categories Model.
     */
    public $categories;

    /**
     * A User Model.
     */
    public $user;

    /**
     * App pages names.
     */
    public $pages;

    /**
     * Talk filters.
     */
    public $filters;

    public $talks_api;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->categories = new TalkCategories();
        $this->user       = new User();
        $this->filters    = new Filters();
        $this->talks_api  = new TalksApiController();
        $this->pages      = config('pages.names');
    }

    public function showMoreFavoriteUsers(Request $request, $offset)
    {


        if (auth()->user()) {

            $request->request->add(['page' => $offset]);

            $limit = config('app.default_favorites_show_more_users');

            try {

                $favoriteUsers = auth()->user()->followings()->paginate($limit);

                return [
                    'succes'                => true,
                    'data'                  => $favoriteUsers->toArray()['data'] ?? [],
                    'total_favorite_users'  => count(auth()->user()->followings) ?? 0,
                    'message'               => __('NO_FAVORITE_PROFILES_FOUND')
                ];
            } catch (\Throwable $th) {
                return [
                    'succes'                => false,
                    'message'               => __('SOMETHING_WENT_WRONG')
                ];
            }

        }
    }

    public function favoriteUsers(Request $request)
    {
        $loggedUserData = UserController::loggedUserData($request);

        $pointer = $request->input('pointer');

        if (empty($request->input('offset'))) {
            $request->request->add(['offset' => 0]);
        }

        if (empty($request->input('limit'))) {
            $request->request->add(['limit' => config('app.default_favorites_show_more_users')]);
        }

        if (empty($request->input('filter'))) {
            $request->request->add(['filter' => '']);
        }

        $request->request->add(['favorite_type' => 1]);

        $favoritesUsersDataObject = new UserFollowedApiController();
        $favoritesUsersData       = $favoritesUsersDataObject->userTalkFollowers($request)->getData(true);

        if ($pointer) {
            if ($request->ajax()) {
                return [
                    'html'        => view('frontend.partials.pages.favorites._pagination_favorite_users2', [
                        'userFavoritesData'  => $favoritesUsersData['data'] ?? [],
                        'favoritesUsersData' => $favoritesUsersData['data'] ?? [],
                    ])->render(),
                    'total_users' => $favoritesUsersData['data']['users_total'] ?? [],
                    'success'     => true,

                ];
            }
            return view('frontend.pages.favorites_users', [
                'page_name'         => __('FAVORITE_USERS'),
                'loggedUserData'    => $loggedUserData['data'] ?? [],
                'userFavoritesData' => $favoritesUsersData ?? [],
            ]);
        } else {
            if ($request->ajax()) {

                return [
                    'html'        => view('frontend.partials.pages.favorites._pagination_favorite_users', [
                        'favoritesUsersData' => $favoritesUsersData['data'] ?? [],
                    ])->render(),
                    'html2'       => view('frontend.partials.pages.favorites._pagination_favorite_users2', [
                        'userFavoritesData' => $favoritesUsersData['data'] ?? [],
                    ])->render(),
                    'total_users' => $favoritesUsersData['data']['users_total'] ?? [],
                    'success'     => true,
                ];
            }

            return view('frontend.pages.favorites_users', [
                'page_name'         => $this->pages['favorites'],
                'loggedUserData'    => $loggedUserData['data'] ?? [],
                'userFavoritesData' => $favoritesUsersData['data'] ?? [],
            ]);
        }
    }

    /**
     * Show all Favored Talks.
     */
    public function favoriteTalks(Request $request)
    {


        if (!$request->has('offset')) {
            $request->request->add(['offset' => 0]);
        }

        if (!$request->has('limit')) {
            $request->request->add(['limit' => config('app.show_more_talks')]);
        }

        if (!$request->has('filter')) {
            $request->request->add(['filter' => []]);
        }

        if (!$request->has('favorite_type')) {
            $request->request->add(['favorite_type' => 1]);
        }

        // Get all Favored talks for a current user.
        // $talks = $this->user->current()->getFavoredTalks();
        $talks = $this->talks_api->getTalkSearch($request, 'favorites', 'talks')->getData(true);

        // Get active filters for given talks.
        $activeFilters = $this->talks_api->checkActiveFilters($request, 'favorites', 'talks')->getData(true);


        if ($request->ajax()) {

            // Get filtered Talks.
            $talks = $this->talks_api->getTalkSearch($request, 'favorites', 'talks')->getData(true);

            return [
                'html'        => view('frontend.partials.pages.courses._paginate_new_talks2', [
                    'talks' => $talks['data'],
                ])->render(),
                'htmlMobile'  => view('frontend.partials.pages.courses._paginate_new_talks_mobile', [
                    'talks' => $talks['data'],
                ])->render(),
                'talks_count' => $talks['talks_count'],
                'talks'       => $talks['data'],
                'success'     => true,
            ];
        }


        return view('frontend.pages.favorites_talks', [
            'categories'  => $this->categories->all(),
            'filters'     => $activeFilters['data'],
            'page_name'   => $this->pages['favorites'],
            'talks'       => $talks['data'],
            'talks_count' => $talks['talks_count'],
        ]);
    }
}
