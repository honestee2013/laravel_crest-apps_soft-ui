<?php
namespace App\Modules\Analytics\Data;

use Illuminate\Support\Facades\DB;

class Aggregator
{
    protected string $table;
    protected string $column;
    protected string $groupBy;
    protected array $filters = [];
    protected string $aggregationMethod = 'count'; // Default to count

    public function setTable(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function setColumn(string $column): self
    {
        $this->column = $column;
        return $this;
    }

    public function groupBy(string $groupBy): self
    {
        $this->groupBy = match ($groupBy) {
            'daily' => "DATE_FORMAT(created_at, '%Y-%m-%d')", // e.g., 2024-12-21
            'weekly' => "CONCAT(YEARWEEK(created_at, 1), '-W')", // e.g., 202451-W (Week 51 of 2024)
            'monthly' => "DATE_FORMAT(created_at, '%Y-%m')", // e.g., 2024-12
            'yearly' => "YEAR(created_at)", // e.g., 2024
            default => $groupBy,
        };

        return $this;
    }





    public function setFilters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    public function setAggregationMethod(string $method): self
    {
        $this->aggregationMethod = match ($method) {
            'sum', 'average', 'count', 'max', 'min' => $method,
            default => throw new \InvalidArgumentException("Invalid aggregation method: {$method}"),
        };
        return $this;
    }




    public function fetch(): array
    {
        $query = DB::table($this->table);

        
        $aggregationColumn = $this->aggregationMethod === 'count' ? '*' : $this->column;
        $query->selectRaw("{$this->groupBy} as label, {$this->aggregationMethod}({$aggregationColumn}) as value");

        foreach ($this->filters as $filter) {
            if (is_callable($filter)) {
                // Apply closure-based filters
                $filter($query);
            } elseif (is_array($filter)) {
                // Apply key-value filters (if needed)
                foreach ($filter as $key => $value) {
                    $query->where($key, $value);
                }
            }
        }

        $query->groupBy('label')->orderBy('label', 'asc');

        $data = $query->get();

        // Convert labels to user-friendly formats
        $formattedLabels = $data->pluck('label')->map(function ($label) {
            return $this->formatLabel($label);
        })->toArray();

        return [
            'labels' => $formattedLabels,
            'data' => $data->pluck('value')->toArray(),
        ];
    }




    protected function formatLabel(string $label): string
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $label)) {
            // Daily format (YYYY-MM-DD)
            return \Carbon\Carbon::parse($label)->format('jS M Y'); // e.g., 21st Dec 2024
        } elseif (preg_match('/^\d{4}-\d{2}$/', $label)) {
            // Monthly format (YYYY-MM)
            return \Carbon\Carbon::parse($label . '-01')->format('F Y'); // e.g., December 2024
        } elseif (preg_match('/^\d{4}\d{2}-W$/', $label)) {
            // Weekly format (YearWeek-W)
            $year = substr($label, 0, 4);
            $week = substr($label, 4, 2);
            return "Week {$week}, {$year}";
        } elseif (is_numeric($label)) {
            // Yearly format (e.g., 2024)
            return (string)$label;
        }

        // Default: return as-is
        return $label;
    }






    public function setTimeRange(string $fromTime, string $toTime): self
    {

        $this->filters[] = function ($query) use ($fromTime, $toTime) {
            $query->whereBetween("created_at", [$fromTime, $toTime]);
        };
        return $this;
    }



}
