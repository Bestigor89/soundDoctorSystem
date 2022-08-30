<div>
    <div class="card-controls sm:flex">
    <input type="text" wire:model.debounce.300ms="searchQuery" name="searchQuery" id="searchQuery" class="w-full sm:w-1/3 inline-block">
    </div>


    <div class="overflow-hidden"  >


        @foreach($pacients as $pacient)
        <div>
            {{$pacient->getName()}}
        </div>

        @endforeach
    </div>

    <div class="card-body">
    </div>
</div>
