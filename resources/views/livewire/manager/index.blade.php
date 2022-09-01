<div>
    <div class="card-header">

    </div>
    <div class="card-body">
        <div class="sm:flex">
            <div class="w-full sm:w-1/2">
                <label for="patient" class="form-label">Patient</label>
                <input type="text" wire:model.debounce.300ms="searchPatient" name="searchPatient" id="searchPatient" class="block w-full form-control">
                <div class="flex justify-center items-center" wire:loading.grid wire:target="searchPatient">
                    Loading...
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
                                                >Select patient</a>
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
                    <dd class="text-sm text-gray-900 sm:col-span-2">
                        <div class="divide-y divide-gray-200 rounded-md border border-gray-200">
                            <div class="flex items-center justify-between py-3 pl-3 pr-4 text-sm {{ !blank($patient) ? 'bg-green-500' : '' }}">
                                @if(!blank($patient))
                                    {{ $patient->name }}
                                @else
                                    Please select patient...
                                @endif
                            </div>
                        </div>
                    </dd>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

@endpush
