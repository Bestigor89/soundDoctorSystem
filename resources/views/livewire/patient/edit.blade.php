<form wire:submit.prevent="submit" class="pt-3">

    <div class="form-group {{ $errors->has('patient.name') ? 'invalid' : '' }}">
        <label class="form-label required" for="name">{{ trans('cruds.patient.fields.name') }}</label>
        <input class="form-control" type="text" name="name" id="name" required wire:model.defer="patient.name">
        <div class="validation-message">
            {{ $errors->first('patient.name') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.patient.fields.name_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('patient.doctor_id') ? 'invalid' : '' }}">
        <label class="form-label required" for="doctor">{{ trans('cruds.patient.fields.doctor') }}</label>
        <x-select-list class="form-control" required id="doctor" name="doctor" :options="$this->listsForFields['doctor']" wire:model="patient.doctor_id" />
        <div class="validation-message">
            {{ $errors->first('patient.doctor_id') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.patient.fields.doctor_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('patient.phone') ? 'invalid' : '' }}">
        <label class="form-label" for="phone">{{ trans('cruds.patient.fields.phone') }}</label>
        <input class="form-control" type="text" name="phone" id="phone" wire:model.defer="patient.phone">
        <div class="validation-message">
            {{ $errors->first('patient.phone') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.patient.fields.phone_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('patient.status') ? 'invalid' : '' }}">
        <input class="form-control" type="checkbox" name="status" id="status" wire:model.defer="patient.status">
        <label class="form-label inline ml-1" for="status">{{ trans('cruds.patient.fields.status') }}</label>
        <div class="validation-message">
            {{ $errors->first('patient.status') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.patient.fields.status_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('patient.user_id') ? 'invalid' : '' }}">
        <label class="form-label required" for="user">{{ trans('cruds.patient.fields.user') }}</label>
        <x-select-list class="form-control" required id="user" name="user" :options="$this->listsForFields['user']" wire:model="patient.user_id" />
        <div class="validation-message">
            {{ $errors->first('patient.user_id') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.patient.fields.user_helper') }}
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-indigo mr-2" type="submit">
            {{ trans('global.save') }}
        </button>
        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">
            {{ trans('global.cancel') }}
        </a>
    </div>
</form>