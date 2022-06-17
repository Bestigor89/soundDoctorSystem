<form wire:submit.prevent="submit" class="pt-3">

    <div class="form-group {{ $errors->has('doctor.name') ? 'invalid' : '' }}">
        <label class="form-label required" for="name">{{ trans('cruds.doctor.fields.name') }}</label>
        <input class="form-control" type="text" name="name" id="name" required wire:model.defer="doctor.name">
        <div class="validation-message">
            {{ $errors->first('doctor.name') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.doctor.fields.name_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('doctor.status') ? 'invalid' : '' }}">
        <input class="form-control" type="checkbox" name="status" id="status" wire:model.defer="doctor.status">
        <label class="form-label inline ml-1" for="status">{{ trans('cruds.doctor.fields.status') }}</label>
        <div class="validation-message">
            {{ $errors->first('doctor.status') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.doctor.fields.status_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('doctor.user_id') ? 'invalid' : '' }}">
        <label class="form-label required" for="user">{{ trans('cruds.doctor.fields.user') }}</label>
        <x-select-list class="form-control" required id="user" name="user" :options="$this->listsForFields['user']" wire:model="doctor.user_id" />
        <div class="validation-message">
            {{ $errors->first('doctor.user_id') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.doctor.fields.user_helper') }}
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-indigo mr-2" type="submit">
            {{ trans('global.save') }}
        </button>
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">
            {{ trans('global.cancel') }}
        </a>
    </div>
</form>