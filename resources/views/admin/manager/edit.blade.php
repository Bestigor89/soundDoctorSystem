@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-white">
        <div class="card-body">
            @livewire('manager.edit', [$taskForPatient])
        </div>
    </div>
</div>
@endsection
