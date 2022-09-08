<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class PatientProfileController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('patient'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
}
