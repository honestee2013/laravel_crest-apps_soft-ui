<div>

    <div class="progress-wrapper" >
        <div class="progress-info">
            <div class="progress-percentage">
                <span class="text-sm font-weight-normal">{{ $label ? $label . ' ' : '' }}</span>
            </div>
        </div>


        <div class="rounded-pill progress" style="height: auto" >
            <div class="rounded-pill my-auto  progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $progress }}%; height:2em; "
                aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                {{ $label ? $label . ' ' : '' }}{{ $progress }}%
            </div>
        </div>
    </div>


    <div class="mt-5">
        <button class="btn btn-primary btn-sm" wire:click="incrementProgress">Increase</button>
        <button class="btn btn-danger btn-sm" wire:click="decrementProgress">Decrease</button>
    </div>
</div>
