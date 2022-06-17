@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-white">
        <div class="card-header border-b border-blueGray-200">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('cruds.taskForPatient.title_singular') }}
                    {{ trans('global.list') }}
                </h6>

                @can('task_for_patient_create')
                    <a class="btn btn-indigo" href="{{ route('admin.task-for-patients.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.taskForPatient.title_singular') }}
                    </a>
                @endcan
            </div>
        </div>
        @livewire('task-for-patient.index')

    </div>
</div>
@endsection