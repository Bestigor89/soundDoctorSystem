@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-blueGray-100">
        <div class="card-header">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('global.view') }}
                    {{ trans('cruds.section.title_singular') }}:
                    {{ trans('cruds.section.fields.id') }}
                    {{ $section->id }}
                </h6>
            </div>
        </div>

        <div class="card-body">
            <div class="pt-3">
                <table class="table table-view">
                    <tbody class="bg-white">
                        <tr>
                            <th>
                                {{ trans('cruds.section.fields.id') }}
                            </th>
                            <td>
                                {{ $section->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.section.fields.name') }}
                            </th>
                            <td>
                                {{ $section->name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                @can('section_edit')
                    <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-indigo mr-2">
                        {{ trans('global.edit') }}
                    </a>
                @endcan
                <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary">
                    {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection