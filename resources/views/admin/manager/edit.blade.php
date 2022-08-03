@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-blueGray-100">
        <div class="card-header">

        </div>

        <div class="card-body">
            @livewire('manager.edit')
        </div>
    </div>
</div>
@endsection
