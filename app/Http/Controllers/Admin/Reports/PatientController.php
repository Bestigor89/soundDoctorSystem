<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class PatientController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        abort_if(Gate::denies('reports'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reports.patients');
    }
}
