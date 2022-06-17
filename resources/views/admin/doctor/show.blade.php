@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-blueGray-100">
        <div class="card-header">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('global.view') }}
                    {{ trans('cruds.doctor.title_singular') }}:
                    {{ trans('cruds.doctor.fields.id') }}
                    {{ $doctor->id }}
                </h6>
            </div>
        </div>

        <div class="card-body">
            <div class="pt-3">
                <table class="table table-view">
                    <tbody class="bg-white">
                        <tr>
                            <th>
                                {{ trans('cruds.doctor.fields.id') }}
                            </th>
                            <td>
                                {{ $doctor->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.doctor.fields.name') }}
                            </th>
                            <td>
                                {{ $doctor->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.doctor.fields.status') }}
                            </th>
                            <td>
                                <input class="disabled:opacity-50 disabled:cursor-not-allowed" type="checkbox" disabled {{ $doctor->status ? 'checked' : '' }}>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.doctor.fields.user') }}
                            </th>
                            <td>
                                @if($doctor->user)
                                    <span class="badge badge-relationship">{{ $doctor->user->name ?? '' }}</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                @can('doctor_edit')
                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-indigo mr-2">
                        {{ trans('global.edit') }}
                    </a>
                @endcan
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">
                    {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection