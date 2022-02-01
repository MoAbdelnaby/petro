<?php

namespace App\Services\Report;

use Carbon\Carbon;

abstract class BaseReport
{
    /**
     * Prepare Important Properties to execute report
     *
     * @param $filter
     * @return void
     */
    public function prepare($filter): array
    {
        $data = $this->handleListQuery($filter);
        $key = ucfirst($data["type"]);
        $func_name = "get{$key}Query";
        $list = $data["list"];

        if (!is_array($list)) {
            $list = str_contains($list, ',') ? explode(',', $list) : $list;
        }

        $list = \Arr::wrap($list);
        //Prepare Base Query to get This report base On List Type
        $this->$func_name($list);

        $data["charts"] = $this->getReport($data["type"], $filter);


        return $data;
    }

    /**
     * Helper Function Use to handle time range
     *
     * @param $query
     * @param $filter
     * @param bool $timeStamp
     * @return mixed
     */
    public function handleDateFilter($query, $filter, bool $timeStamp = false)
    {
        if ($filter['start'] ?? false) {
            $start = ($filter['start'] > date('Y-m-d')) ? now()->subDay() : Carbon::parse($filter['start']);
            if ($timeStamp) {
                $query->whereDate($filter['column'], '>=', $start->format('Y-m-d h:i:s'));
            } else {
                $query->whereDate($filter['column'], '>=', $start->format('Y-m-d'));
            }
        }

        if ($filter['end'] ?? false) {
            $end = ($filter['end'] > date('Y-m-d')) ? now() : Carbon::parse($filter['end']);
            if ($timeStamp) {
                $query->whereDate($filter['column'], '<=', $end->format('Y-m-d h:i:s'));
            } else {
                $query->whereDate($filter['column'], '<=', $end->format('Y-m-d'));
            }
        }

        return $query;
    }

    /**
     * Handle List Query [City-Region-Branch]
     *
     * @param $filter
     * @return array
     */
    public function handleListQuery($filter): array
    {
        $result = [];
        if ($filter['show_by'] == 'city') {
            if ($filter['city_type'] == 'comparison') {
                $result['type'] = 'city';
                $result['list'] = $filter['city_comparison'];
            } elseif ($filter['city_type'] == 'region') {
                $result['type'] = 'region';
                $result['list'] = $filter['city_region_comparison'];
            }
        } elseif ($filter['show_by'] == 'region') {
            if ($filter['region_type'] == 'comparison') {
                $result['type'] = 'region';
                $result['list'] = $filter['region_comparison'];
            } elseif ($filter['region_type'] == 'branch') {
                $result['type'] = 'branch';
                $result['list'] = $filter['region_branch_comparison'];
            }
        } elseif ($filter['show_by'] == 'branch') {
            if ($filter['branch_type'] == 'comparison') {
                $result['type'] = 'branch';
                $result['list'] = $filter['branch_comparison'];
            } elseif ($filter['branch_type'] == 'branch') {
                $result['type'] = 'area';
                $result['list'] = $filter['branch_data'];
            } elseif ($filter['branch_type'] == 'area') {
                $result['type'] = 'compare_area';
                $result['list'] = $filter['branch_areas'];
            }
        }
        return $result;
    }
}
