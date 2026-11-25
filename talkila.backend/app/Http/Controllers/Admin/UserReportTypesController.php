<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserReportTypeRequest;
use App\Http\Requests\StoreUserReportTypeRequest;
use App\Http\Requests\UpdateUserReportTypeRequest;
use App\Models\UserReportType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserReportTypesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_report_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userReportTypes = UserReportType::all();

        return view('admin.userReportTypes.index', compact('userReportTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_report_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userReportTypes.create');
    }

    public function store(StoreUserReportTypeRequest $request)
    {
        $userReportType = UserReportType::create($request->all());

        return redirect()->route('admin.user-report-types.index');
    }

    public function edit(UserReportType $userReportType)
    {
        abort_if(Gate::denies('user_report_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userReportTypes.edit', compact('userReportType'));
    }

    public function update(UpdateUserReportTypeRequest $request, UserReportType $userReportType)
    {
        $userReportType->update($request->all());

        return redirect()->route('admin.user-report-types.index');
    }

    public function show(UserReportType $userReportType)
    {
        abort_if(Gate::denies('user_report_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userReportTypes.show', compact('userReportType'));
    }

    public function destroy(UserReportType $userReportType)
    {
        abort_if(Gate::denies('user_report_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userReportType->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserReportTypeRequest $request)
    {
        UserReportType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
