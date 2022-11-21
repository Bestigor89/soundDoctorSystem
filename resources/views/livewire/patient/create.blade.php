<form wire:submit.prevent="submit" class="pt-3">

    <div class="form-group {{ $errors->has('user.name') ? 'invalid' : '' }}">
        <label class="form-label required" for="name">{{ trans('cruds.user.fields.name') }}</label>
        <input class="form-control" type="text" name="name" id="name" required wire:model.defer="user.name">
        <div class="validation-message">
            {{ $errors->first('user.name') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.user.fields.name_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('user.email') ? 'invalid' : '' }}">
        <label class="form-label required" for="email">{{ trans('cruds.user.fields.email') }}</label>
        <input class="form-control" type="email" name="email" id="email" required wire:model.defer="user.email">
        <div class="validation-message">
            {{ $errors->first('user.email') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.user.fields.email_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('password') ? 'invalid' : '' }}">
        <label class="form-label required" for="password">{{ trans('cruds.user.fields.password') }}</label>
        <input class="form-control" type="password" name="password" id="password" required wire:model.defer="password">
        <div class="validation-message">
            {{ $errors->first('password') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.user.fields.password_helper') }}
        </div>
    </div>

    <div class="form-group {{ $errors->has('user.status') ? 'invalid' : '' }}">
        <input class="form-control" type="checkbox" name="status" id="status" required wire:model.defer="user.status">
        <label class="form-label inline ml-1 required" for="status">{{ trans('cruds.user.fields.status') }}</label>
        <div class="validation-message">
            {{ $errors->first('user.status') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.user.fields.status_helper') }}
        </div>
    </div>

    <div class="form-group {{ $errors->has('patient.phone') ? 'invalid' : '' }}">
        <label class="form-label" for="phone">{{ trans('cruds.patient.fields.phone') }}</label>
        <input class="form-control" type="text" name="phone" id="phone" wire:model.defer="phone">
        <div class="validation-message">
            {{ $errors->first('patient.phone') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.patient.fields.phone_helper') }}
        </div>
    </div>

    <div class="form-group {{ $errors->has('patient.doctor_id') ? 'invalid' : '' }}">
        <label class="form-label required" for="doctor">{{ trans('cruds.patient.fields.doctor') }}</label>
        <x-select-list class="form-control" required id="doctor" name="doctor" :options="$this->listsForFields['doctor']" wire:model="doctor_id" />
        <div class="validation-message">
            {{ $errors->first('patient.doctor_id') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.patient.fields.doctor_helper') }}
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
