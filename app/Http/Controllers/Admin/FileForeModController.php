<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileForeMod;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileForeModController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('file_fore_mod_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.file-fore-mod.index');
    }

    public function create()
    {
        abort_if(Gate::denies('file_fore_mod_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.file-fore-mod.create');
    }

    public function edit(FileForeMod $fileForeMod)
    {
        abort_if(Gate::denies('file_fore_mod_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.file-fore-mod.edit', compact('fileForeMod'));
    }

    public function show(FileForeMod $fileForeMod)
    {
        abort_if(Gate::denies('file_fore_mod_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fileForeMod->load('file', 'mod');

        return view('admin.file-fore-mod.show', compact('fileForeMod'));
    }
}
