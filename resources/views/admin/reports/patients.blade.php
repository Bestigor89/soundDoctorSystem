@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="card bg-white">
            <div class="card-header border-b border-blueGray-200">
                <div class="card-header-container">
                    <h6 class="card-title">
                        {{ trans('cruds.reports.title') }}
                    </h6>
                </div>
            </div>
            @livewire('reports.patients')
        </div>
    </div>
@endsection
