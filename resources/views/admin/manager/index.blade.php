@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="card bg-white">
        <div class="card-header border-b border-blueGray-200">
            <div class="card-header-container">

            </div>
        </div>
        @livewire('manager.index')

    </div>
</div>
@endsection
