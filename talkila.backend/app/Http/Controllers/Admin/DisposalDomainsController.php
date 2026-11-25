<?php

namespace App\Http\Controllers\Admin;

use App\Models\DisposalDomain;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDisposalDomainRequest;
use App\Http\Requests\StoreDisposalDomainRequest;
use App\Http\Requests\UpdateDisposalDomainRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisposalDomainsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('disposal_domain_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $disposalDomains = DisposalDomain::all();

        return view('admin.disposalDomains.index', compact('disposalDomains'));
    }

    public function create()
    {
        abort_if(Gate::denies('disposal_domain_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disposalDomains.create');
    }

    public function store(StoreDisposalDomainRequest $request)
    {
        $disposalDomain = DisposalDomain::create($request->all());

        return redirect()->route('admin.disposal-domains.index');
    }

    public function edit(DisposalDomain $disposalDomain)
    {
        abort_if(Gate::denies('disposal_domain_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disposalDomains.edit', compact('disposalDomain'));
    }

    public function update(UpdateDisposalDomainRequest $request, DisposalDomain $disposalDomain)
    {
        $disposalDomain->update($request->all());

        return redirect()->route('admin.disposal-domains.index');
    }

    public function show(DisposalDomain $disposalDomain)
    {
        abort_if(Gate::denies('disposal_domain_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disposalDomains.show', compact('disposalDomain'));
    }

    public function destroy(DisposalDomain $disposalDomain)
    {
        abort_if(Gate::denies('disposal_domain_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $disposalDomain->delete();

        return back();
    }

    public function massDestroy(MassDestroyDisposalDomainRequest $request)
    {
        DisposalDomain::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
