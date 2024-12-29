<?php

namespace App\Modules\Dashboard\Livewire\Visualisation\Widgets\Cards;


use Livewire\Component;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;
use App\Modules\Dashboard\Livewire\Visualisation\Widgets\Charts\Chart;



class IconCard extends Chart
{
    public $prefix = '';
    public $suffix = '';
    public $iconCSSClass = '';

    protected $listeners = [
        'recordSavedEvent' => '$refresh',
    ];



    public function mount()
    {
        
        $aggregationData = $this->fetchChartData();
        $this->setUpAggregationValues($aggregationData["data"]);
        $this->setUpChangedValue($aggregationData["data"]);
        //dd ($aggregationData, $this->total);

    }


    public function render()
    {
         return view('dashboard.views::components.visualisation.widgets.cards.icon-card');


    }

}
