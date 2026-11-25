<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVATRequest;
use App\Http\Requests\UpdateVATRequest;
use App\Models\VAT;
use Exception;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use View;
use Yajra\DataTables\Facades\DataTables;

class VATController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return View
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('vat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VAT::query();
            $table = Datatables::of($query);

            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'vat_delete';
                $crudRoutePart = 'vat';

                return view('partials.datatablesActions', compact('viewGate', 'editGate', 'deleteGate', 'crudRoutePart', 'row'));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ?: '';
            });

            $table->editColumn('english', function ($row) {
                return $row->english ?: '';
            });

            $table->editColumn('german', function ($row) {
                return $row->german ?: '';
            });

            $table->editColumn('croatian', function ($row) {
                return $row->croatian ?: '';
            });

            $table->editColumn('country_code', function ($row) {
                return $row->country_code ?: '';
            });

            $table->editColumn('value', function ($row) {
                return $row->value . '%' ?: '';
            });

            $table->rawColumns(['actions']);

            return $table->make(true);
        }

        return view('admin.vat.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        abort_if(Gate::denies('vat_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreVATRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(StoreVATRequest $request): RedirectResponse
    {
        VAT::create($request->validated());

        return redirect()->route('admin.vat.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  VAT  $vat
     *
     * @return View
     */
    public function edit(VAT $vat)
    {
        abort_if(Gate::denies('vat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.vat.edit', [
            'vat' => $vat,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateVATRequest  $request
     * @param  VAT               $vat
     *
     * @return RedirectResponse
     */
    public function update(UpdateVATRequest $request, VAT $vat): RedirectResponse
    {
        $vat->update($request->validated());

        return redirect()->route('admin.vat.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  VAT  $vat
     *
     * @return RedirectResponse
     */
    public function destroy(VAT $vat): RedirectResponse
    {
        abort_if(Gate::denies('vat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vat->delete();

        return redirect()->route('admin.vat.index');
    }
}
