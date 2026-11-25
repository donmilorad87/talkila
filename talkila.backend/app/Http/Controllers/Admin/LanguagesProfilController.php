<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLanguagesProfilRequest;
use App\Http\Requests\StoreLanguagesProfilRequest;
use App\Http\Requests\UpdateLanguagesProfilRequest;
use App\Models\Language;
use App\Models\LanguagesProfil;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguagesProfilController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('languages_profil_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $languagesProfils = LanguagesProfil::all();

        $users = User::get()->pluck('name')->toArray();

        $languages = Language::get()->pluck('code')->toArray();

        return view('admin.languagesProfils.index', compact('languagesProfils', 'users', 'languages'));
    }

    public function create()
    {
        abort_if(Gate::denies('languages_profil_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $languages = Language::all()->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.languagesProfils.create', compact('users', 'languages'));
    }

    public function store(StoreLanguagesProfilRequest $request)
    {
        $languagesProfil = LanguagesProfil::create($request->all());

        return redirect()->route('admin.languages-profils.index');
    }

    public function edit(LanguagesProfil $languagesProfil)
    {
        abort_if(Gate::denies('languages_profil_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $languages = Language::all()->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $languagesProfil->load('user', 'language');

        return view('admin.languagesProfils.edit', compact('users', 'languages', 'languagesProfil'));
    }

    public function update(UpdateLanguagesProfilRequest $request, LanguagesProfil $languagesProfil)
    {
        $languagesProfil->update($request->all());

        return redirect()->route('admin.languages-profils.index');
    }

    public function show(LanguagesProfil $languagesProfil)
    {
        abort_if(Gate::denies('languages_profil_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $languagesProfil->load('user', 'language');

        return view('admin.languagesProfils.show', compact('languagesProfil'));
    }

    public function destroy(LanguagesProfil $languagesProfil)
    {
        abort_if(Gate::denies('languages_profil_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $languagesProfil->delete();

        return back();
    }

    public function massDestroy(MassDestroyLanguagesProfilRequest $request)
    {
        LanguagesProfil::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
