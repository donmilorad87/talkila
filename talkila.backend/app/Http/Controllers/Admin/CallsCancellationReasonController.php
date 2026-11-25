<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCallsCancellationReasonRequest;
use App\Http\Requests\StoreCallsCancellationReasonRequest;
use App\Http\Requests\UpdateCallsCancellationReasonRequest;
use App\Models\CallsCancellationReason;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CallsCancellationReasonController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('calls_cancellation_reason_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CallsCancellationReason::query()->select(sprintf('%s.*', (new CallsCancellationReason)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'calls_cancellation_reason_delete';
                $crudRoutePart = 'calls-cancellation-reasons';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ?: "";
            });
            $table->editColumn('croatian', function ($row) {
                return $row->croatian ?: "";
            });
            $table->editColumn('german', function ($row) {
                return $row->german ?: "";
            });
            $table->editColumn('english', function ($row) {
                return $row->english ?: "";
            });
            $table->editColumn('polish', function ($row) {
                return $row->polish ?: "";
            });
            $table->editColumn('state', function ($row) {
                return $row->state ?: "";
            });
            $table->editColumn('type', function ($row) {
                return $row->type ?: "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.callsCancellationReasons.index');
    }

    public function create()
    {
        abort_if(Gate::denies('calls_cancellation_reason_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.callsCancellationReasons.create');
    }

    public function store(StoreCallsCancellationReasonRequest $request)
    {
        $callsCancellationReason = CallsCancellationReason::create($request->all());

        return redirect()->route('admin.calls-cancellation-reasons.index');
    }

    public function edit(CallsCancellationReason $callsCancellationReason)
    {
        abort_if(Gate::denies('calls_cancellation_reason_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.callsCancellationReasons.edit', compact('callsCancellationReason'));
    }

    public function update(UpdateCallsCancellationReasonRequest $request, CallsCancellationReason $callsCancellationReason)
    {
        $callsCancellationReason->update($request->all());

        return redirect()->route('admin.calls-cancellation-reasons.index');
    }

    public function show(CallsCancellationReason $callsCancellationReason)
    {
        abort_if(Gate::denies('calls_cancellation_reason_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $callsCancellationReason->load('cancellationReasonBookings');

        return view('admin.callsCancellationReasons.show', compact('callsCancellationReason'));
    }

    public function destroy(CallsCancellationReason $callsCancellationReason)
    {
        abort_if(Gate::denies('calls_cancellation_reason_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $callsCancellationReason->delete();

        return back();
    }

    public function massDestroy(MassDestroyCallsCancellationReasonRequest $request)
    {
        CallsCancellationReason::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
