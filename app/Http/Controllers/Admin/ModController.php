<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mod;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ModController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('mod_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.mod.index');
    }

    public function create()
    {
        abort_if(Gate::denies('mod_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.mod.create');
    }

    public function edit(Mod $mod)
    {
        abort_if(Gate::denies('mod_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.mod.edit', compact('mod'));
    }

    public function show(Mod $mod)
    {
        abort_if(Gate::denies('mod_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mod->load('section', 'soundFile');

        return view('admin.mod.show', compact('mod'));
    }
}
