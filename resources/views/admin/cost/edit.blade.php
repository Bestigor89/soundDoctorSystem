@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-blueGray-100">
        <div class="card-header">
            <div class="card-header-container">
                <h6 class="card-title">
                    {{ trans('global.edit') }}
                    {{ trans('cruds.cost.title_singular') }}:
                    {{ trans('cruds.cost.fields.id') }}
                    {{ $cost->id }}
                </h6>
            </div>
        </div>

        <div class="card-body">
            @livewire('cost.edit', [$cost])
        </div>
    </div>
</div>
@endsection