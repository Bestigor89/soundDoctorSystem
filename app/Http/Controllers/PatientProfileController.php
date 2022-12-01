<?php

namespace App\Http\Controllers;

use App\Models\TaskForPatient;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class PatientProfileController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('patient'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('profile.show');
    }

    public function tasks()
    {
        abort_if(Gate::denies('patient'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('profile.tasks.index');
    }

    public function show(TaskForPatient $taskForPatient)
    {
        abort_if(Gate::denies('patient'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = \Auth::user();
        if ($user->patient->id !== $taskForPatient->pacient_id) {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        $taskForPatient->load(['mode', 'mode.files']);

        return view('profile.tasks.show', compact('taskForPatient'));
    }
}
