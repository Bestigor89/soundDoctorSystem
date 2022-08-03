<form wire:submit.prevent="submit" class="pt-3">

    <div class="form-group {{ $errors->has('taskForPatient.pacient_id') ? 'invalid' : '' }}">
        <label class="form-label required" for="pacient">{{ trans('cruds.taskForPatient.fields.pacient') }}</label>
        <x-select-list class="form-control" required id="pacient" name="pacient" :options="$this->listsForFields['pacient']" wire:model="taskForPatient.pacient_id" />
        <div class="validation-message">
            {{ $errors->first('taskForPatient.pacient_id') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.taskForPatient.fields.pacient_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('taskForPatient.cost_id') ? 'invalid' : '' }}">
        <label class="form-label required" for="cost">{{ trans('cruds.taskForPatient.fields.cost') }}</label>
        <x-select-list class="form-control" required id="cost" name="cost" :options="$this->listsForFields['cost']" wire:model="taskForPatient.cost_id" />
        <div class="validation-message">
            {{ $errors->first('taskForPatient.cost_id') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.taskForPatient.fields.cost_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('taskForPatient.mode_id') ? 'invalid' : '' }}">
        <label class="form-label required" for="mode">{{ trans('cruds.taskForPatient.fields.mode') }}</label>
        <x-select-list class="form-control" required id="mode" name="mode" :options="$this->listsForFields['mode']" wire:model="taskForPatient.mode_id" />
        <div class="validation-message">
            {{ $errors->first('taskForPatient.mode_id') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.taskForPatient.fields.mode_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('taskForPatient.status') ? 'invalid' : '' }}">
        <input class="form-control" type="checkbox" name="status" id="status" wire:model.defer="taskForPatient.status">
        <label class="form-label inline ml-1" for="status">{{ trans('cruds.taskForPatient.fields.status') }}</label>
        <div class="validation-message">
            {{ $errors->first('taskForPatient.status') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.taskForPatient.fields.status_helper') }}
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-indigo mr-2" type="submit">
            {{ trans('global.save') }}
        </button>
        <a href="{{ route('admin.task-for-patients.index') }}" class="btn btn-secondary">
            {{ trans('global.cancel') }}
        </a>
    </div>
</form>