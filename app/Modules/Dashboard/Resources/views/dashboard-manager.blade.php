
<div>

            {{--<livewire:dashboard.livewire.visualisation.widgets.charts.chart
                recordTable='sales'
                recordName='Sales'
                column='amount'
            />--}}


            <livewire:dashboard.livewire.visualisation.widgets.cards.icon-card
                recordTable='sales'
                recordName='Sales'
                column='amount'
                timeDuration='this_month'
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


