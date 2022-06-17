@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-blueGray-100">
        <div class="card-header">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('global.view') }}
                    {{ trans('cruds.fileLibrary.title_singular') }}:
                    {{ trans('cruds.fileLibrary.fields.id') }}
                    {{ $fileLibrary->id }}
                </h6>
            </div>
        </div>

        <div class="card-body">
            <div class="pt-3">
                <table class="table table-view">
                    <tbody class="bg-white">
                        <tr>
                            <th>
                                {{ trans('cruds.fileLibrary.fields.id') }}
                            </th>
                            <td>
                                {{ $fileLibrary->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.fileLibrary.fields.name') }}
                            </th>
                            <td>
                                {{ $fileLibrary->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.fileLibrary.fields.sound_file') }}
                            </th>
                            <td>
                                @foreach($fileLibrary->sound_file as $key => $entry)
                                    <a class="link-light-blue" href="{{ $entry['url'] }}">
                                        <i class="far fa-file">
                                        </i>
                                        {{ $entry['file_name'] }}
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.fileLibrary.fields.durations') }}
                            </th>
                            <td>
                                {{ $fileLibrary->durations }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                @can('file_library_edit')
                    <a href="{{ route('admin.file-libraries.edit', $fileLibrary) }}" class="btn btn-indigo mr-2">
                        {{ trans('global.edit') }}
                    </a>
                @endcan
                <a href="{{ route('admin.file-libraries.index') }}" class="btn btn-secondary">
                    {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection