@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-white">
        <div class="card-header border-b border-blueGray-200">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('cruds.fileLibrary.title_singular') }}
                    {{ trans('global.list') }}
                </h6>

                @can('file_library_create')
                    <a class="btn btn-indigo" href="{{ route('admin.file-libraries.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.fileLibrary.title_singular') }}
                    </a>
                @endcan
            </div>
        </div>
        @livewire('file-library.index')

    </div>
</div>
@endsection