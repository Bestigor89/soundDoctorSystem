@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-blueGray-100">
        <div class="card-header">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('global.view') }}
                    {{ trans('cruds.patient.title_singular') }}:
                    {{ trans('cruds.patient.fields.id') }}
                    {{ $patient->id }}
                </h6>
            </div>
        </div>

        <div class="card-body">
            <div class="pt-3">
                <table class="table table-view">
                    <tbody class="bg-white">
                        <tr>
                            <th>
                                {{ trans('cruds.patient.fields.id') }}
                            </th>
                            <td>
                                {{ $patient->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.patient.fields.name') }}
                            </th>
                            <td>
                                {{ $patient->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.patient.fields.doctor') }}
                            </th>
                            <td>
                                @if($patient->doctor)
                                    <span class="badge badge-relationship">{{ $patient->doctor->name ?? '' }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.patient.fields.phone') }}
                            </th>
                            <td>
                                {{ $patient->phone }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.patient.fields.status') }}
                            </th>
                            <td>
                                <input class="disabled:opacity-50 disabled:cursor-not-allowed" type="checkbox" disabled {{ $patient->status ? 'checked' : '' }}>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.patient.fields.user') }}
                            </th>
                            <td>
                                @if($patient->user)
                                    <span class="badge badge-relationship">{{ $patient->user->name ?? '' }}</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                @can('patient_edit')
                    <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-indigo mr-2">
                        {{ trans('global.edit') }}
                    </a>
                @endcan
                <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
                    {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection