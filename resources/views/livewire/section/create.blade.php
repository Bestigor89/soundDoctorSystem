<form wire:submit.prevent="submit" class="pt-3">

    <div class="form-group {{ $errors->has('section.name') ? 'invalid' : '' }}">
        <label class="form-label required" for="name">{{ trans('cruds.section.fields.name') }}</label>
        <input class="form-control" type="text" name="name" id="name" required wire:model.defer="section.name">
        <div class="validation-message">
            {{ $errors->first('section.name') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.section.fields.name_helper') }}
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-indigo mr-2" type="submit">
            {{ trans('global.save') }}
        </button>
        <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary">
            {{ trans('global.cancel') }}
        </a>
    </div>
</form>