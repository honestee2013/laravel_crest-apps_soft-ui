<?php

namespace App\Modules\Dashboard\Livewire\Visualisation\Widgets\Charts;


use Livewire\Component;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Modules\Analytics\Data\Dataset;

use App\Modules\Analytics\Data\Aggregator;
use App\Modules\Analytics\Helpers\DataGroupingHelper;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;




class Chart extends Component
{

    protected $listeners = [
        'recordSavedEvent' => '$refresh',
    ];




    public $chartType = 'bar'; // Default chart type
    public $chartId = 'line-chart'; // Chart element ID
    public $chartData = []; // Chart data
    public $chartOptions = []; // Chart options
    //public $model;
    public $recordTable;
    public $recordName;
    public $column;
    public $groupBy = 'daily'; // Default grouping
    public $aggregationMethod = "sum";


    public $timeDuration = 'this_month'; // Default predefined duration
    public $fromTime; // Custom range start
    public $toTime;   // Custom range end

    // Aggregation values
    public $min = true;
    public $ave = true;
    public $max = true;
    public $total = true;
    public $count = true;

    public $valueChange = 0;
    public $valueChangePercent = 0;
    public $valueChangeTimeDuration;



    private $colorPalette = [
        '#FF5733', // Vibrant orange
        '#33FF57', // Bright green
        '#3357FF', // Deep blue
        '#FF33A1', // Hot pink
        '#33FFF5', // Aqua
        '#F5FF33', // Yellow
        '#FF8C00', // Dark orange
        '#800080', // Purple
        '#008080', // Teal
        '#000080', // Navy
    ];

    private $defaultTransparency = 0.6; // Adjust transparency level (0.0 to 1.0)





    public function mount()
    {
        $this->updateChart();
    }




    public function fetchChartData()
    {

        if ($this->timeDuration === 'custom') {
            // Use defaults if custom range is not fully specified
            if (!$this->fromTime) {
                $this->fromTime = now()->startOfMonth()->toDateString(); // Default to start of the current month
            }

            if (!$this->toTime) {
                $this->toTime = now()->endOfMonth()->toDateString(); // Default to end of the current month
            }

            // Validate after applying defaults
            $this->validateTimeRange();
        }

        // Fetch data using the Aggregator or DataHelper
        $aggregator = new Aggregator();
        $aggregator = $this->setUpAggregatorParameters($aggregator);
        $timeRange = $this->getTimeRange($this->timeDuration);

        if ($timeRange) {
            $aggregator->setTimeRange($timeRange['from'], $timeRange['to']);
        }



        $aggregationData = $aggregator->fetch();
        return $aggregationData;
    }


    private function setUpAggregatorParameters($aggregator) {
        if ($aggregator) {
            $aggregator->setTable($this->recordTable)
                ->setColumn($this->column)
                ->groupBy($this->groupBy)
                ->setAggregationMethod($this->aggregationMethod);
                // ->setFilters(['status' => 'completed'])

            if ($this->timeDuration === 'custom' && $this->fromTime && $this->toTime) {
                $aggregator->setTimeRange($this->fromTime, $this->toTime);
            } /*else {

                $timeRange = $this->getTimeRange($this->timeDuration);
                if ($timeRange) {
                    $aggregator->setTimeRange($timeRange['from'], $timeRange['to']);
                }
            }*/

            $aggregator;
        }

        return $aggregator;
    }


    protected function getTimeRange($duration)
    {
        switch ($duration) {
            case 'today':
                return [
                    'from' => now()->startOfDay()->toDateTimeString(),
                    'to' => now()->endOfDay()->toDateTimeString(),
                ];
            case 'yesterday':
                return [
                    'from' => now()->subDay()->startOfDay()->toDateTimeString(),
                    'to' => now()->subDay()->endOfDay()->toDateTimeString(),
                ];
            case 'this_week':
                return [
                    'from' => now()->startOfWeek()->toDateTimeString(),
                    'to' => now()->endOfWeek()->toDateTimeString(),
                ];
            case 'last_week':
                return [
                    'from' => now()->subWeek()->startOfWeek()->toDateTimeString(),
                    'to' => now()->subWeek()->endOfWeek()->toDateTimeString(),
                ];
            case 'this_month':
                return [
                    'from' => now()->startOfMonth()->toDateTimeString(),
                    'to' => now()->endOfMonth()->toDateTimeString(),
                ];
            case 'last_month':
                return [
                    'from' => now()->subMonth()->startOfMonth()->toDateTimeString(),
                    'to' => now()->subMonth()->endOfMonth()->toDateTimeString(),
                ];
            case 'this_year':
                return [
                    'from' => now()->startOfYear()->toDateTimeString(),
                    'to' => now()->endOfYear()->toDateTimeString(),
                ];
            case 'last_year':
                return [
                    'from' => now()->subYear()->startOfYear()->toDateTimeString(),
                    'to' => now()->subYear()->endOfYear()->toDateTimeString(),
                ];
            default:
                return null;
        }
    }









    public function updatedTimeDuration()
    {
        if ($this->timeDuration !== 'custom') {
            $this->fromTime = null;
            $this->toTime = null;
            $this->resetErrorBag(['fromTime', 'toTime']); // Clear errors
        }

        $this->updateChart();
    }

    public function updatedFromTime()
    {
        if ($this->validateTimeRange()) {
            $this->updateChart();
        }
    }

    public function updatedToTime()
    {
        if ($this->validateTimeRange()) {
            $this->updateChart();
        }
    }

    protected function validateTimeRange(): bool
    {
        if ($this->fromTime && $this->toTime) {
            if ($this->fromTime > $this->toTime) {
                $this->addError('fromTime', 'The "From" date must be earlier than the "To" date.');
                $this->addError('toTime', 'The "To" date must be later than the "From" date.');
                return false;
            } else {
                $this->resetErrorBag(['fromTime', 'toTime']);
                return true;
            }
        }

        return false;
    }













    private function setUpChartData($aggregationData) {

        $data = [];
        $labels = [];
        if (!empty($aggregationData["data"]))
            $data = $aggregationData["data"];
        if (!empty($aggregationData["labels"]))
            $labels = $aggregationData["labels"];

        // Aggregation data
        $this->setUpAggregationValues($data);
        // Increase/Decrease of the record
        $this->setUpChangedValue($data);



        $dataSets = [
            [
                'label' => $this->recordName,
                'data' => $data,
                'fill' => false,

                'backgroundColor' => 'rgba(54, 162, 235, 0.5)', // Semi-transparent blue
                'borderColor' => 'rgba(54, 162, 235, 1)',       // Solid blue

                'tension' => 0.1,
                'pointRadius' => 4,

                'borderWidth' => 2,
                'maxBarThickness' => 60,
                'borderRadius' => 10,
            ]
        ];

        return $this->chartData = [
            'labels' => $labels,
            'datasets' => $dataSets,
        ];

    }

    protected function setUpAggregationValues($data) {
        if ($data) {
            if ($this->total)
                $this->total = array_sum($data);
            if ($this->count)
                $this->count = count($data);
            if ($this->max)
                $this->max = max($data);
            if ($this->min)
                $this->min = min($data);
            if ($this->ave)
                $this->ave = round(array_sum($data)/count($data), 2);
        }
    }


    protected function setUpChangedValue($data) {
        if ($data) {
            // Assuming the $this->timeDuration = "today"
            $otherTimeDuration = "yesterday";
            if($this->timeDuration == "yesterday")
                $otherTimeDuration = "today";
            else if($this->timeDuration == "this_week")
                $otherTimeDuration = "last_week";
            else if($this->timeDuration == "last_week")
                $otherTimeDuration = "this_week";
            else if($this->timeDuration == "this_month")
                $otherTimeDuration = "last_month";
            else if($this->timeDuration == "last_month")
                $otherTimeDuration = "this_month";
            else if($this->timeDuration == "this_year")
                $otherTimeDuration = "last_year";
            else if($this->timeDuration == "last_year")
                $otherTimeDuration = "this_year";


            $aggregator = new Aggregator();
            $aggregator = $this->setUpAggregatorParameters($aggregator);

            $timeRange = $this->getTimeRange($otherTimeDuration);
            if ($timeRange) {
                $aggregator->setTimeRange($timeRange['from'], $timeRange['to']);
            }
            $otherAggregationData = $aggregator->fetch();

            // Defference should be between current time and the previous tmie eg. (this_week - last_week)
            if (str_contains($this->timeDuration, "this") || str_contains($this->timeDuration, "today") && array_sum($data)) {
                $this->valueChange = array_sum($data) -  array_sum($otherAggregationData["data"]);

                $sum = array_sum($data);
                if ($sum != 0 && $this->valueChange)
                    $this->valueChangePercent = $this->valueChange/$sum*100;
            } else if (array_sum($data)) {
                $this->valueChange = array_sum($otherAggregationData["data"]) - array_sum($data);

                $sum = array_sum($otherAggregationData["data"]);
                if ($sum != 0 && $this->valueChange)
                    $this->valueChangePercent = $this->valueChange/$sum*100;
            }


            $this->valueChangePercent = intval(round($this->valueChangePercent));

            //dd($this->timeDuration, $this->valueChangePercent, $this->valueChange,  $data, $otherAggregationData["data"]);
        } else {
            $this->valueChangePercent = 0;
        }


        // To be used for label
        $this->valueChangeTimeDuration = "today";
        if(str_contains($this->timeDuration, "week"))
            $this->valueChangeTimeDuration = "this week";
        if(str_contains($this->timeDuration, "month"))
            $this->valueChangeTimeDuration = "this month";
        if(str_contains($this->timeDuration, "year"))
            $this->valueChangeTimeDuration = "this year";

    }


    private function setUpchartOptions() {
        return $this->chartOptions = [
            'responsive' => true,
            'maintainAspectRatio' => true,

            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
            'interaction' => [
                'intersect' => false,
                'mode' => 'index',
            ],
            'scales' => [
                'x' => [
                    'ticks' => [
                        'beginAtZero' => true,
                    ],
                    'grid' => [
                        'borderDash' => [5, 5],
                    ],
                ],
                'y' => [
                    'grid' => [
                        'borderDash' => [5, 5],
                    ],

                    'ticks' => [
                        'beginAtZero' => true,
                    ],
                ]
            ]
        ];
    }


    public function updateChart() {

        $aggregationData = $this->fetchChartData();
        $this->setUpChartData($aggregationData);



        $colors = 'rgba(54, 162, 235, 0.5)';

        // Generate dynamic colors for pie chart datasets
        if ($this->chartType == "pie" || $this->chartType == "doughnut" ) {
            $colors = $this->generateColors(count($this->chartData["datasets"][0]["data"]));
        }

        $this->chartData["datasets"][0]["backgroundColor"] = $colors;
        $this->chartData["datasets"][0]["hoverBackgroundColor"] = $colors;


        $data = [
            "chartType" => $this->chartType,
            "chartData" => $this->chartData,
            "chartOptions" => $this->chartOptions,
        ];
        $this->dispatch('update-chart-event', $data);
    }



    public function updatedGroupBy($value)
    {
        $aggregator = new Aggregator();
        $aggregator->setTable($this->recordTable)
            ->setColumn($this->column)
            ->groupBy($this->groupBy)
            ->setAggregationMethod($this->aggregationMethod);
            // ->setFilters(['status' => 'completed'])

        $aggregationData = $aggregator->fetch();
        $this->setUpChartData($aggregationData);

        // Emit an event to update the chart
        $this->updateChart();
    }


    // Function to generate colors dynamically
    private function generateColors($count)
    {
        $colors = [];
        $paletteSize = count($this->colorPalette);

        for ($i = 0; $i < $count; $i++) {
            $baseColor = $this->colorPalette[$i % $paletteSize];
            $rgbaColor = $this->hexToRgba($baseColor, $this->defaultTransparency);
            $colors[] = $rgbaColor;
        }

        return $colors;
    }

    // Helper function to convert HEX to RGBA
    private function hexToRgba($hex, $transparency)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "rgba($r, $g, $b, $transparency)";
    }









    public function render()
    {
        return view('dashboard.views::components.visualisation.widgets.charts.chart');
    }

}
