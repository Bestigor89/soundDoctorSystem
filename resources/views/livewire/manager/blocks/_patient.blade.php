<div class="w-full sm:w-1/2">
    <label for="searchPatient" class="form-label">@lang('models.patient.labels.label')</label>
    <input type="text" wire:model.debounce.300ms="searchPatient" name="searchPatient" id="searchPatient" class="block w-full form-control">
    <div class="flex justify-center items-center" wire:loading.grid wire:target="searchPatient">
        @lang('global.loading')
    </div>
    @if(!blank($patientList))
        <div class="bg-white py-5 sm:grid sm:grid-cols-3 sm:gap-4 mt-2 w-full">
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                <ul class="divide-y divide-gray-200 rounded-md border border-gray-200">
                    @foreach($patientList as $patientItem)
                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm {{ $patientItem->id === data_get($patient, 'id') ? 'bg-green-500' : '' }}">
                            <div class="flex w-0 flex-1 items-center">
                                <span class="ml-2 w-0 flex-1 truncate">{{ $patientItem->name }}</span>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                @if($patientItem->id !== data_get($patient, 'id'))
                                    <a class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer"
                                       wire:click.prevent="setPatient({{ $patientItem->id }})"
                                    >@lang('models.patient.labels.set')</a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </dd>
        </div>
    @endif
</div>
<div class="w-full sm:w-1/2">
    <div class="ml-3 bg-white py-5 sm:gap-4 mt-1">
        <dd class="text-sm text-gray-900 sm:col-span-2 form-group {{ $errors->has('patient.id') ? 'invalid' : '' }}">
            <div class="divide-y divide-gray-200 rounded-md border border-gray-200">
                <div class="flex py-3 pl-3 pr-4 text-sm">
                    @if(!blank($patient))
                        {{ $patient->name }} <span class="text-xs ml-4 inline-block py-1 pl-3 pr-4 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded">@lang('models.patient.labels.selected')</span>
                    @else
                        @lang('models.patient.labels.select')
                    @endif
                </div>
            </div>
            <div class="validation-message">
                {{ $errors->first('patient.id') }}
            </div>
        </dd>
    </div>
</div>
