<div class="w-full sm:w-1/2 form-group {{ $errors->has('mod.name') ? 'invalid' : '' }}">
    <label for="searchModule" class="form-label">@lang('models.mod.labels.label')</label>
    <input type="text" wire:model.debounce.300ms="searchModule" name="searchModule" id="searchModule"
           class="block w-full form-control"
    >
    <div class="validation-message">
        {{ $errors->first('mod.name') }}
    </div>
    <div class="flex justify-center items-center" wire:loading.grid wire:target="searchModule">
        @lang('global.loading')
    </div>
    @push('forms')
        <form wire:submit.prevent="saveModule" class="hidden">
            <input type="text" id="mod.name" name="mod.name" wire:model="mod.name" />
            <button type="submit" id="save__module"></button>
        </form>
    @endpush
    @if(!blank($moduleList))
        <div class="bg-white py-5 sm:grid sm:grid-cols-3 sm:gap-4 mt-2 w-full">
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                <ul class="divide-y divide-gray-200 rounded-md border border-gray-200">
                    @foreach($moduleList as $moduleItem)
                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm {{ $moduleItem->id === data_get($mod, 'id') ? 'bg-green-500' : '' }}">
                            <div class="flex w-0 flex-1 items-center">
                                <span class="ml-2 w-0 flex-1 truncate">{{ $moduleItem->name }}</span>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                @if($moduleItem->id !== data_get($mod, 'id'))
                                    <a class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer"
                                       wire:click.prevent="setModule({{ $moduleItem->id }})"
                                    >@lang('models.mod.labels.set')</a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </dd>
        </div>
    @elseif(blank($moduleList) && !blank($searchModule))
        <button class="btn btn-indigo mt-2" type="button" wire:click.prevent="$emit('saveModule')">
            {{ trans('models.mod.actions.create') }}
        </button>
    @endif
</div>
<div class="w-full sm:w-1/2">
    <div class="ml-3 bg-white py-5 sm:gap-4 mt-1">
        <dd class="text-sm text-gray-900 sm:col-span-2 form-group {{ $errors->has('mod.id') ? 'invalid' : '' }}">
            <div class="divide-y divide-gray-200 rounded-md border border-gray-200">
                <div class="flex py-3 pl-3 pr-4 text-sm">
                    @if($mod->exists)
                        {{ $mod->name }} <span class="text-xs ml-4 inline-block py-1 pl-3 pr-4 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded">@lang('models.mod.labels.selected')</span>
                        <input type="hidden" wire:model="mod" />
                    @else
                        @lang('models.mod.labels.select')
                    @endif
                </div>
            </div>
            <div class="validation-message">
                {{ $errors->first('mod.id') }}
            </div>
        </dd>
    </div>
</div>
