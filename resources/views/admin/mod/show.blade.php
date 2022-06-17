@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-blueGray-100">
        <div class="card-header">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('global.view') }}
                    {{ trans('cruds.mod.title_singular') }}:
                    {{ trans('cruds.mod.fields.id') }}
                    {{ $mod->id }}
                </h6>
            </div>
        </div>

        <div class="card-body">
            <div class="pt-3">
                <table class="table table-view">
                    <tbody class="bg-white">
                        <tr>
                            <th>
                                {{ trans('cruds.mod.fields.id') }}
                            </th>
                            <td>
                                {{ $mod->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.mod.fields.name') }}
                            </th>
                            <td>
                                {{ $mod->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.mod.fields.section') }}
                            </th>
                            <td>
                                @if($mod->section)
                                    <span class="badge badge-relationship">{{ $mod->section->name ?? '' }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.mod.fields.sound_file') }}
                            </th>
                            <td>
                                @foreach($mod->soundFile as $key => $entry)
                                    <span class="badge badge-relationship">{{ $entry->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                @can('mod_edit')
                    <a href="{{ route('admin.mods.edit', $mod) }}" class="btn btn-indigo mr-2">
                        {{ trans('global.edit') }}
                    </a>
                @endcan
                <a href="{{ route('admin.mods.index') }}" class="btn btn-secondary">
                    {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection