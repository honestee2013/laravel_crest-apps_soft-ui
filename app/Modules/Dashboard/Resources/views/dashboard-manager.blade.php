
<div>

            {{--<livewire:dashboard.livewire.visualisation.widgets.charts.chart
                recordTable='sales'
                recordName='Sales'
                column='amount'
            />--}}



            <div class="input-group  w-90 col-sm-auto w-sm-auto border border-light rounded-pill p-3 p-sm-0 ms-3 mt-2">

                <select wire:model.live.500ms="timeDuration" id="time_duration"
                    class="form-select  rounded-pill p-1 ps-3  px-sm-3 m-1" style="height: 2.1em;">
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="this_week">This Week</option>
                    <option value="last_week">Last Week</option>
                    <option value="this_month">This Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="this_year">This Year</option>
                    <option value="last_year">Last Year</option>
                    {{--<option value="custom">Custom Range...</option>--}}
                </select>



                {{--<div class="input-group col-12 w-100 col-sm-auto w-sm-auto" x-show="$wire.timeDuration === 'custom'">
                    <span for="from_time" class=" ms-3 me-1 mt-1 text-sm ">From:</span>
                    <input type="date" wire:model.live.500ms="fromTime" id="from_time"
                        class="form-control rounded-pill  ps-3  px-sm-3 m-1 " style="height: 2em;">
                    @error('fromTime')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <span for="to_time" class=" ms-3 me-1 mt-1 text-sm">To:</span>
                    <input type="date" wire:model.live.500ms="toTime" id="to_time"
                        class="form-control rounded-pill ps-3  px-sm-3 m-1" style="height: 2em;">
                    @error('toTime')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>--}}

            </div>

            <select wire:model.live.500ms="selectedProcessId" id="time_duration"
                class="form-select  rounded-pill p-1 ps-3  px-sm-3 m-1" style="height: 2.1em;">
                @foreach (App\Modules\Production\Models\ProductionProcess::all() as $process )
                    <option value="{{$process->id}}">{{ucfirst($process->name)}}</option>
                @endforeach
            </select>





            <livewire:dashboard.livewire.visualisation.widgets.cards.icon-card
                recordTable='sales'
                recordName='Sales'
                column='amount'
                :timeDuration='$timeDuration'
                prefix='$'
                iconCSSClass='ni ni-money-coins text-lg opacity-10'
            />












{{---

    <livewire:dashboard.livewire.visualisation.widgets.counters.count-up count-to="23980" />

    @php
        $duration = "+10 year";
    @endphp
    <livewire:dashboard.livewire.visualisation.widgets.counters.count-down :end-time="strtotime($duration)" />



    <livewire:dashboard.livewire.visualisation.widgets.progresses.progress-bar
        :progress="40"
        label="Loading"
        color="success"

    />


    <livewire:dashboard.livewire.visualisation.widgets.steppers.stepper-wizard
        :steps="[
            ['label' => 'Step 1', 'content' => '<p>Content for Step 1</p>'],
            ['label' => 'Step 2', 'content' => '<p>Content for Step 2</p>'],
            ['label' => 'Step 3', 'content' => '<p>Content for Step 3</p>'],
            ['label' => 'Step 4', 'content' => '<p>Content for Step 3</p>'],
            ['label' => 'Step 5', 'content' => '<p>Content for Step 3</p>'],
        ]"
    />


--}}





</div>


