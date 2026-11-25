<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Api\V1\Admin\TalkCategoriesApiController;
use App\Http\Controllers\Api\V1\Admin\TalksApiController;
use App\Http\Controllers\Controller;
use App\Models\TalkCategories;
use App\Models\TalkSubcategories;
use App\ModelsApi\StaticProfession;
use Illuminate\Http\Request;

class TalksController extends Controller
{
    /**
     * App pages names.
     */
    public $pages;

    public $talks_api;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->pages   = config('pages.names');
        $this->talks_api   = new TalksApiController();

    }

    /**
     * Show all Talks.
     *
     * @return \Illuminate\View\View
     */
    public function talks(Request $request)
    {

        if (!isset($_COOKIE['jtc2redirect'])) {
            $user = auth()->user();
            if($user && $user->jtc){
                $array = [
                    'step_1' => $user->jtc?->step_1,
                    'step_2' => $user->jtc?->step_2,
                    'step_3' => $user->jtc?->step_3,
                    'step_4' => $user->jtc?->step_4,
                ];
    
                $step = '';
    
                foreach ($array as $key => $item) {
                    if (!$item) {
                        $step = $key;
                        break;
                    }
                }
                setcookie('jtc2redirect', 'true', time() + 86400 * 30, '/');
    
                switch ($step) {
                    case 'step_2':
    
                        return redirect()->route('jtc2_add_your_first_talk');
                        break;
                    case 'step_3':
                        return redirect()->route('jtc2_set_availabilities');
                        break;
                    case 'step_4':
                        return redirect()->route('jtc2_verify_account');
                        break;
                }
    
            }
           

        }

        $talkCategoriesObject = new TalkCategoriesApiController();
        $categories           = $talkCategoriesObject->getTalkCategories($request)->getData(true);

        return view('frontend.pages.talks', [
            'page_name'  => $this->pages['talks'],
            'categories' => $categories['data'] ?? [],
        ]);
    }

    public function talks_all(Request $request)
    {
        $talkCategoriesObject = new TalkCategoriesApiController();
        $categories           = $talkCategoriesObject->getTalkCategories($request)->getData(true);

        return view('frontend.pages.talks_all', [
            'page_name'  => $this->pages['talks'],
            'categories' => $categories['data'] ?? [],
        ]);
    }

    /**
     * Show all Talks for a specific Category.
     */
    public function talkCategory(Request $request, TalkCategories $category)
    {
        if (! $request->has('limit')) {
            $request->request->add(['limit' => config('app.show_more_talks')]);
        }
        if (! $request->has('offset')) {
            $request->request->add(['offset' => 0]);
        }

        $user_language = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', $request->user() ? $request->user()->last_language: 'en')];

        // Talks for a given Category.
        // $talks = $category->getTalks('*', $request->offset, $request->limit);
        $talks = $this->talks_api->getTalkSearch($request, $category[$user_language], null)->getData(true);

        if (empty($talks['talks_count'])) {
            return redirect()->back();
        }

        // Subcategories with Active talks.
        $subcategories = $category->getActiveSubcategoriesForTalks($talks['data']);

        // Active filters for given talks.
        // $activeFilters = $talks['filters'];
        $activeFilters = $this->talks_api->checkActiveFilters($request, $category[$user_language])->getData(true);

        if ($request->ajax()) {
            // Get filtered Talks.
            $talks = $this->talks_api->getTalkSearch($request, $category[$user_language], null)->getData(true);;

            return [
                'html'        => view('frontend.partials.pages.courses._paginate_new_talks', [
                    'category'      => $category->load('subcategories')->loadCount('talks'),
                    'subcategories' => $subcategories,
                    'talks'         => $talks['data'],
                    'filters'       => $activeFilters['data'],
                    'page_name'     => $this->pages['talks'],
                ])->render(),
                'htmlMobile'  => view('frontend.partials.pages.courses._paginate_new_talks_mobile', [
                    'category'      => $category->load('subcategories')->loadCount('talks'),
                    'subcategories' => $subcategories,
                    'talks'         => $talks['data'],
                    'filters'       => $activeFilters['data'],
                    'page_name'     => $this->pages['talks'],
                ])->render(),
                'talks_count' => $talks['talks_count'],
                'message'     => 'Message',
                'success'     => true,
            ];
        }
        return view('frontend.pages.talks-category', [
            'category'      => $category->load('subcategories', 'subcategories.category', 'subcategories.talks')->loadCount('talks'),
            'subcategories' => $subcategories,
            'talks'         => $talks['data'],
            'filters'       => $activeFilters['data'],
            'page_name'     => $this->pages['talks'],
            'talks_count'   => $talks['talks_count'],
        ]);
    }

    /**
     * Show all Talks for a specific Subcategory.
     */
    public function talkCategorySubcategory(Request $request, TalkCategories $category, TalkSubcategories $subcategory)
    {
        if ($subcategory->english === 'Other') {
            $subcategory = $category->subcategories()->where('english', 'Other')->first();
        }

        if (! $request->has('limit')) {
            $request->request->add(['limit' => config('app.show_more_talks')]);
        }
        if (! $request->has('offset')) {
            $request->request->add(['offset' => 0]);
        }

        $user_language = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', $request->user() ? $request->user()->last_language : 'en')];


        // Talks for a given Category.
        // $talks = $subcategory->getTalks('*', $request->offset, $request->limit);
        $talks = $this->talks_api->getTalkSearch($request, $category[$user_language], $subcategory[$user_language])->getData(true);

        // Subcategories with Active talks.
        $subcategories = $category->getActiveSubcategoriesForTalks($talks['data']);

        // Active filters for given talks.
        $activeFilters = $this->talks_api->checkActiveFilters($request, $category[$user_language], $subcategory[$user_language])->getData(true);

        if ($request->ajax()) {
            // Filtered Talks.
            $talks = $this->talks_api->getTalkSearch($request, $category[$user_language], $subcategory[$user_language])->getData(true);

            return [
                'html'        => view('frontend.partials.pages.courses._paginate_new_talks', [
                    'subcategory'   => $subcategory->load('category')->loadCount('talks'),
                    'subcategories' => $subcategories,
                    'talks'         => $talks['data'],
                    'filters'       => $activeFilters['data'],
                    'page_name'     => $this->pages['talks'],
                ])->render(),
                'htmlMobile'  => view('frontend.partials.pages.courses._paginate_new_talks_mobile', [
                    'subcategory'   => $subcategory->load('category')->loadCount('talks'),
                    'subcategories' => $subcategories,
                    'talks'         => $talks['data'],
                    'filters'       => $activeFilters['data'],
                    'page_name'     => $this->pages['talks'],
                ])->render(),
                'talks_count' => $talks['talks_count'],
                'message'     => 'Message',
                'success'     => true,
            ];
        }

        return view('frontend.pages.talks-subcategory', [
            'subcategory'   => $subcategory->load('category', 'category.subcategories', 'category.subcategories.category', 'talks')->loadCount([
                'talks as talks_count' => function ($query) {
                    $query->where('teacher_user_id', '!=', auth()->id());
                },
            ]),
            'subcategories' => $subcategories,
            'talks'         => $talks['data'],
            'filters'       => $activeFilters['data'],
            'page_name'     => $this->pages['talks'],
            'talks_count'   => $talks['talks_count'],
        ]);
    }
}
