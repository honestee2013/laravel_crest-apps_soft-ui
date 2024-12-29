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
    public $aggregationType = 'total';


    protected $listeners = [
        'configChangedEvent' => 'updateData',
    ];



    public function mount()
    {
        $this->setupData();
    }




    public function setupData() {
        $aggregationData = $this->fetchChartData();
        $this->setUpAggregationValues($aggregationData["data"]);
        $this->setUpChangedValue($aggregationData["data"]);
    }


    public function updateData($data) {
        if (is_array($data) && !empty($data)) {
            foreach ($data as $key => $value) {
                if (isset($this->$key))
                    $this->$key = $value;
            }
        }

        $this->setupData();
    }










    public function render()
    {
        return view('dashboard.views::components.visualisation.widgets.cards.icon-card');
    }

}
