<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CostController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cost_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cost.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cost_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cost.create');
    }

    public function edit(Cost $cost)
    {
        abort_if(Gate::denies('cost_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cost.edit', compact('cost'));
    }

    public function show(Cost $cost)
    {
        abort_if(Gate::denies('cost_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cost.show', compact('cost'));
    }
}
