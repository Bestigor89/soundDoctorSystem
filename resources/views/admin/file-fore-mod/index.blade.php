@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-white">
        <div class="card-header border-b border-blueGray-200">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('cruds.fileForeMod.title_singular') }}
                    {{ trans('global.list') }}
                </h6>

                @can('file_fore_mod_create')
                    <a class="btn btn-indigo" href="{{ route('admin.file-fore-mods.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.fileForeMod.title_singular') }}
                    </a>
                @endcan
            </div>
        </div>
        @livewire('file-fore-mod.index')

    </div>
</div>
@endsection