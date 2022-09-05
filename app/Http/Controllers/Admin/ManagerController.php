<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\TaskForPatient;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ManagerController extends Controller
{
    public function index()
    {
//        abort_if(Gate::denies('cost_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.manager.index');
    }

    public function create()
    {
//        abort_if(Gate::denies('cost_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.manager.create');
    }

    /**
     * @param $manager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($manager)
    {
        $taskForPatient = TaskForPatient::query()->findOrFail($manager);
//        abort_if(Gate::denies('cost_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.manager.edit', compact('taskForPatient'));
    }

    public function show()
    {
//        abort_if(Gate::denies('cost_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.manager.show' );
    }
}
