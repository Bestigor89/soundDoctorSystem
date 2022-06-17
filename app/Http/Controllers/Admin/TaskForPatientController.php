<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskForPatient;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskForPatientController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('task_for_patient_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.task-for-patient.index');
    }

    public function create()
    {
        abort_if(Gate::denies('task_for_patient_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.task-for-patient.create');
    }

    public function edit(TaskForPatient $taskForPatient)
    {
        abort_if(Gate::denies('task_for_patient_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.task-for-patient.edit', compact('taskForPatient'));
    }

    public function show(TaskForPatient $taskForPatient)
    {
        abort_if(Gate::denies('task_for_patient_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taskForPatient->load('pacient', 'cost', 'mode');

        return view('admin.task-for-patient.show', compact('taskForPatient'));
    }
}
