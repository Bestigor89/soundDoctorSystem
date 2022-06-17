<form wire:submit.prevent="submit" class="pt-3">

    <div class="form-group {{ $errors->has('cost.price') ? 'invalid' : '' }}">
        <label class="form-label required" for="price">{{ trans('cruds.cost.fields.price') }}</label>
        <input class="form-control" type="number" name="price" id="price" required wire:model.defer="cost.price" step="0.01">
        <div class="validation-message">
            {{ $errors->first('cost.price') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.cost.fields.price_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('cost.status') ? 'invalid' : '' }}">
        <input class="form-control" type="checkbox" name="status" id="status" wire:model.defer="cost.status">
        <label class="form-label inline ml-1" for="status">{{ trans('cruds.cost.fields.status') }}</label>
        <div class="validation-message">
            {{ $errors->first('cost.status') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.cost.fields.status_helper') }}
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-indigo mr-2" type="submit">
            {{ trans('global.save') }}
        </button>
        <a href="{{ route('admin.costs.index') }}" class="btn btn-secondary">
            {{ trans('global.cancel') }}
        </a>
    </div>
</form>