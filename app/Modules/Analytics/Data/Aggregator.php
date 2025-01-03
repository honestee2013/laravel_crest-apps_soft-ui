<?php
namespace App\Modules\Analytics\Data;

use Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Aggregator
{
    protected string $table;
    protected string $model;
    protected string $column;
    protected string $groupBy;
    protected array $filters = [];
    protected string $aggregationMethod = 'count'; // Default to count

    public function setTable(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
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




    /*public function fetch(): array
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
    }*/



    public function fetch(): array
    {
        $query = null;
        if (!isset($this->table) && !isset($this->model))
            throw new \Exception("Table or Model is required");

        if (isset($this->model)) {
            // Default: use the model's query builder instead of the raw table
            $query = $this->model::query();
        } else{
            $query = DB::table($this->table);
        }



        $aggregationColumn = $this->aggregationMethod === 'count' ? '*' : $this->column;
        $query->selectRaw("{$this->groupBy} as label, {$this->aggregationMethod}({$aggregationColumn}) as value");

        foreach ($this->filters as $filter) {
            if (is_callable($filter)) {
                // Apply closure-based filters
                $filter($query);
            } elseif (is_array($filter) && count($filter) === 3) {
                // Apply key-operator-value filters
                [$key, $operator, $value] = $filter;

                // Check if column exists in the table
                if ($this->columnExists($key)) {
                    $query->where($key, $operator, $value);

                } else {
                    Log::warning("Filter column '{$key}' does not exist in the table or model");
                }
            } else {
                throw new \InvalidArgumentException("Invalid filter format");
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


    protected function columnExists(string $column): bool
    {
        static $columnsCache = [];

        // Determine the table name
        $table = $this->table ?? (new ($this->model))?->getTable() ?? null;

        if (!$table) {
            throw new \InvalidArgumentException('Table name or model must be defined to check column existence.');
        }

        // Cache the column listing for the table
        if (!isset($columnsCache[$table])) {
            $columnsCache[$table] = Schema::getColumnListing($table);
        }

        // Check if the column exists
        return in_array($column, $columnsCache[$table], true);
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
