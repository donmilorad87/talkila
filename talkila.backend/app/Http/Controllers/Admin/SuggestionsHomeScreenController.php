<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySuggestionsHomeScreenRequest;
use App\Http\Requests\StoreSuggestionsHomeScreenRequest;
use App\Http\Requests\UpdateSuggestionsHomeScreenRequest;
use App\Models\SuggestionsHomeScreen;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SuggestionsHomeScreenController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('suggestions_home_screen_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SuggestionsHomeScreen::with([
                'users' => function ($query) {
                    $query->select('id', 'username', 'visibility', 'verified', 'username');
                },
                'users.userUserFolloweds',
                'users.participiantFeedback',
                'users.userTalks.category',
                'users.roles',
            ])->whereHas('users.roles', function ($query) {
                $query->where('id', 2);
            })->select(sprintf('%s.*', (new SuggestionsHomeScreen)->table));

            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', function ($row) {
                $addGate       = '';
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'user_delete';
                $crudRoutePart = 'suggestions-home-screen';

                return view('partials.datatablesActions', compact('addGate', 'viewGate', 'editGate', 'deleteGate', 'crudRoutePart', 'row'));
            });

            $table->editColumn('visibility', function ($row) {
                if ($row->users !== null) {
                    return $row->users->visibility ? $row->visibility : "";
                } else {
                    return "";
                }
            });

            $table->editColumn('verified', function ($row) {
                if ($row->users !== null) {
                    return $row->users->verified ? $row->verified : "";
                } else {
                    return "";
                }
            });

            $table->addColumn('username', function ($row) {
                if ($row->users !== null) {
                    return $row->users->username ? $row->username : "";
                } else {
                    return "";
                }
            });

            $table->addColumn('talk_category', function ($row) {
                if ($row->users !== null) {
                    if ($row->users->userTalks->count()) {
                        if ($row->users->userTalks[0]->category) {
                            return $row->users->userTalks[0]->category->english ?: "";
                        }
                    }
                }
                return "";
            });

            $table->addColumn('followers', function ($row) {
                 if ($row->users !== null) {
                     if ($row->users->userUserFolloweds !== null) {
                         return $row->users->userUserFolloweds->count();
                     }
                 }
            });

            $table->addColumn('bookings', function ($row) {
                if ($row->users !== null) {
                    if ($row->users->participiantFeedback !== null) {
                        return $row->users->participiantFeedback->count();
                    }
                }
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $suggestions_count = User::join('suggestions_home_screen', 'suggestions_home_screen.user_id', 'users.id')->select('suggestions_home_screen.id')->where('suggestions_home_screen.state', '=', 1)->where('suggestions_home_screen.deleted_at', '=', null)->count();

        return view('admin.suggestionsHomeScreen.index')->with('suggestions_count', $suggestions_count);
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('suggestions_home_screen_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['userUserFolloweds', 'participiantFeedback', 'suggestionsHomeScreen', 'userTalks.category', 'roles'])
                ->whereHas('roles', function ($query) {
                    $query->where('id', 2);
                })
                ->where('state', '=', 1)->select(sprintf('%s.*', (new User)->table));

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $addGate       = 'user_show';
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = '';
                $crudRoutePart = 'suggestions-home-screen';

                return view('partials.datatablesActionsAdd', compact('addGate','viewGate', 'editGate', 'deleteGate', 'crudRoutePart', 'row'));
            });

            $table->addColumn('username', function ($row) {
                return $row->username ?: "";
            });

            $table->addColumn('talk_category', function ($row) {
                if ($row->userTalks->count()) {
                    if ($row->userTalks[0]->category) {
                        return $row->userTalks[0]->category->english ?: "";
                    }
                }
            });

            $table->addColumn('followers', function ($row) {
                return $row->userUserFolloweds->count();
            });

            $table->addColumn('bookings', function ($row) {
                return $row->participiantFeedback->count();
            });

            $table->editColumn('visibility', function ($row) {
                return $row->visibility ?: "";
            });

            $table->editColumn('verified', function ($row) {
                return $row->verified ?: "";
            });

            $table->rawColumns(['actions', 'placeholder', 'userUserFolloweds', 'participiantFeedback', 'suggestionsHomeScreen']);

            return $table->make(true);
        }

        return view('admin.suggestionsHomeScreen.create');
    }

    public function store(StoreSuggestionsHomeScreenRequest $request)
    {
        $suggestionsHomeScreen = SuggestionsHomeScreen::create($request->all());

        return redirect()->back();
    }

    public function edit(SuggestionsHomeScreen $suggestionsHomeScreen)
    {
        abort_if(Gate::denies('suggestions_home_screen_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.suggestionsHomeScreen.edit', compact('suggestionsHomeScreen'));
    }

    public function update(UpdateSuggestionsHomeScreenRequest $request, SuggestionsHomeScreen $suggestionsHomeScreen)
    {
        $suggestionsHomeScreen->update($request->all());

        return redirect()->route('admin.suggestions-home-screen.index');
    }

    public function show(SuggestionsHomeScreen $suggestionsHomeScreen)
    {
        abort_if(Gate::denies('suggestions_home_screen_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.suggestionsHomeScreen.show', compact('suggestionsHomeScreen'));
    }

    public function destroy(SuggestionsHomeScreen $suggestionsHomeScreen)
    {
        abort_if(Gate::denies('suggestions_home_screen_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $suggestionsHomeScreen->delete();

        return back();
    }

    public function massDestroy(MassDestroySuggestionsHomeScreenRequest $request)
    {
        SuggestionsHomeScreen::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
