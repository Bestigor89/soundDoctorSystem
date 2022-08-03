<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileLibrary;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileLibraryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('file_library_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.file-library.index');
    }

    public function create()
    {
        abort_if(Gate::denies('file_library_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.file-library.create');
    }

    public function edit(FileLibrary $fileLibrary)
    {
        abort_if(Gate::denies('file_library_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.file-library.edit', compact('fileLibrary'));
    }

    public function show(FileLibrary $fileLibrary)
    {
        abort_if(Gate::denies('file_library_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fileLibrary->load('section');

        return view('admin.file-library.show', compact('fileLibrary'));
    }

    public function storeMedia(Request $request)
    {
        abort_if(Gate::none(['file_library_create', 'file_library_edit']), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('size')) {
            $this->validate($request, [
                'file' => 'max:' . $request->input('size') * 1024,
            ]);
        }

        $model                     = new FileLibrary();
        $model->id                 = $request->input('model_id', 0);
        $model->exists             = true;
        $media                     = $model->addMediaFromRequest('file')->toMediaCollection($request->input('collection_name'));
        $media->wasRecentlyCreated = true;

        return response()->json(compact('media'), Response::HTTP_CREATED);
    }
}
