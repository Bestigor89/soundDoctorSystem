@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-blueGray-100">
        <div class="card-header">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('global.view') }}
                    {{ trans('cruds.fileForeMod.title_singular') }}:
                    {{ trans('cruds.fileForeMod.fields.id') }}
                    {{ $fileForeMod->id }}
                </h6>
            </div>
        </div>

        <div class="card-body">
            <div class="pt-3">
                <table class="table table-view">
                    <tbody class="bg-white">
                        <tr>
                            <th>
                                {{ trans('cruds.fileForeMod.fields.id') }}
                            </th>
                            <td>
                                {{ $fileForeMod->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.fileForeMod.fields.file') }}
                            </th>
                            <td>
                                @if($fileForeMod->file)
                                    <span class="badge badge-relationship">{{ $fileForeMod->file->name ?? '' }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.fileForeMod.fields.sort_order') }}
                            </th>
                            <td>
                                {{ $fileForeMod->sort_order }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.fileForeMod.fields.mod') }}
                            </th>
                            <td>
                                @if($fileForeMod->mod)
                                    <span class="badge badge-relationship">{{ $fileForeMod->mod->name ?? '' }}</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                @can('file_fore_mod_edit')
                    <a href="{{ route('admin.file-fore-mods.edit', $fileForeMod) }}" class="btn btn-indigo mr-2">
                        {{ trans('global.edit') }}
                    </a>
                @endcan
                <a href="{{ route('admin.file-fore-mods.index') }}" class="btn btn-secondary">
                    {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection