@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-blueGray-100">
        <div class="card-header">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('global.view') }}
                    {{ trans('cruds.taskForPatient.title_singular') }}:
                    {{ trans('cruds.taskForPatient.fields.id') }}
                    {{ $taskForPatient->id }}
                </h6>
            </div>
        </div>

        <div class="card-body">
            <div class="pt-3">
                <table class="table table-view">
                    <tbody class="bg-white">
                        <tr>
                            <th>
                                {{ trans('cruds.taskForPatient.fields.id') }}
                            </th>
                            <td>
                                {{ $taskForPatient->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.taskForPatient.fields.pacient') }}
                            </th>
                            <td>
                                @if($taskForPatient->pacient)
                                    <span class="badge badge-relationship">{{ $taskForPatient->pacient->name ?? '' }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.taskForPatient.fields.cost') }}
                            </th>
                            <td>
                                @if($taskForPatient->cost)
                                    <span class="badge badge-relationship">{{ $taskForPatient->cost->price ?? '' }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.taskForPatient.fields.mode') }}
                            </th>
                            <td>
                                @if($taskForPatient->mode)
                                    <span class="badge badge-relationship">{{ $taskForPatient->mode->name ?? '' }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.taskForPatient.fields.status') }}
                            </th>
                            <td>
                                <input class="disabled:opacity-50 disabled:cursor-not-allowed" type="checkbox" disabled {{ $taskForPatient->status ? 'checked' : '' }}>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                @can('task_for_patient_edit')
                    <a href="{{ route('admin.task-for-patients.edit', $taskForPatient) }}" class="btn btn-indigo mr-2">
                        {{ trans('global.edit') }}
                    </a>
                @endcan
                <a href="{{ route('admin.task-for-patients.index') }}" class="btn btn-secondary">
                    {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection