<?php

namespace App\Http\Controllers\Admin;

use App\Models\DisposalEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDisposalEmailRequest;
use App\Http\Requests\StoreDisposalEmailRequest;
use App\Http\Requests\UpdateDisposalEmailRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisposalEmailsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('disposal_email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $disposalEmails = DisposalEmail::all();

        return view('admin.disposalEmails.index', compact('disposalEmails'));
    }

    public function create()
    {
        abort_if(Gate::denies('disposal_email_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disposalEmails.create');
    }

    public function store(StoreDisposalEmailRequest $request)
    {
        $disposalEmail = DisposalEmail::create($request->all());

        return redirect()->route('admin.disposal-email.index');
    }

    public function edit(DisposalEmail $disposalEmail)
    {
        abort_if(Gate::denies('disposal_email_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disposalEmails.edit', compact('disposalEmail'));
    }

    public function update(UpdateDisposalEmailRequest $request, DisposalEmail $disposalEmails)
    {
        $disposalEmails->update($request->all());

        return redirect()->route('admin.disposal-emails.index');
    }

    public function show(DisposalEmail $disposalEmail)
    {
        abort_if(Gate::denies('disposal_email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disposalEmails.show', compact('disposalEmail'));
    }

    public function destroy(DisposalEmail $disposalEmail)
    {
        abort_if(Gate::denies('disposal_email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $disposalEmail->delete();

        return back();
    }

    public function massDestroy(MassDestroyDisposalEmailRequest $request)
    {
        DisposalEmail::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
