<?php

namespace App\Exports;

use App\Models\Heatmap;
use App\Models\ImagePosition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

class HeatmapLowHighExport implements FromCollection, WithHeadings
{
    private $myRequest;
    public function __construct(Request $request)
    {
        $this->myRequest = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $validator = Validator::make($this->myRequest->all(), [
            'usermodelbranchid' => 'required|exists:user_model_branches,id',
            'image_id' => 'required',
            'year' => 'required|string',
            'month' => 'nullable|string',
            'day' => 'nullable|string',
        ]);

        if ($validator->errors()->count()) {
            return response()->json(['errors' => $validator->errors()], 500);
        }

        if ($this->myRequest->year == "all") {
            $masks = DB::table((new Heatmap())->getTable())->where('user_model_branch_id', $this->myRequest->usermodelbranchid)->where('image_id', $this->myRequest->image_id)->groupBy('year')->groupBy('region')->get([
                'year',
                'region',
                DB::raw("SUM(value) as count")
            ]);
            $heatmap = Heatmap::select('year')->groupBy('year')->get();
            $filter = [];

            if (count($masks) > 0) {
                foreach ($heatmap as $key=>$heat) {
                    $total = $masks->sum('count');
                    $max_reg = $masks->where('year', $heat->year)->max('count');
                    $min_reg = $masks->where('year', $heat->year)->min('count');

                    if (!is_null($max_reg)) {
                        $max = round($max_reg / $total * 100);
                        $max_reg_name = $masks->where('year', $heat->year)->where('count', $max_reg)->first()->region;
                    }
                    if (!is_null($max_reg)) {
                        $min = round($min_reg / $total * 100);
                        $min_reg_name = $masks->where('year', $heat->year)->where('count', $min_reg)->first()->region;
                    }

                    $filter[$key]['year'] = $heat->year;
                    $filter[$key]['month'] = '';
                    $filter[$key]['day'] = '';
                    $filter[$key]['hour'] = '';
                    $filter[$key]['max'] = is_null($max_reg) ? "0"  :  (string)$max;
                    $filter[$key]['min'] = is_null($min_reg) ? "0"  :  (string)$min;
                    $filter[$key]['max_regname'] = is_null($max_reg) ? ""  :  $max_reg_name;
                    $filter[$key]['min_regname'] = is_null($min_reg) ? "" : $min_reg_name;
                }
            }
        } elseif (!empty($this->myRequest->year) and $this->myRequest->year != "all" and ($this->myRequest->month == "0"  or  $this->myRequest->month == "all")  && ($this->myRequest->day == "0" || $this->myRequest->day == "all")) {
            $masks = DB::table((new Heatmap())->getTable())->where('user_model_branch_id', $this->myRequest->usermodelbranchid)->where('image_id', $this->myRequest->image_id)->where('year', $this->myRequest->year)->groupBy('month')->groupBy('region')->get([
                'month',
                'region',
                DB::raw("SUM(value) as count")
            ]);

            $filter = [];
            if (count($masks) > 0) {
                for ($i=0; $i < 12 ; $i++) {
                    $total = $masks->sum('count');
                    $max_reg = $masks->where('month', $i+1)->max('count');
                    $min_reg = $masks->where('month', $i+1)->min('count');

                    if (!is_null($max_reg)) {
                        $max = round($max_reg / $total * 100);
                        $max_reg_name = $masks->where('month', $i+1)->where('count', $max_reg)->first()->region;
                    }
                    if (!is_null($max_reg)) {
                        $min = round($min_reg / $total * 100);
                        $min_reg_name = $masks->where('month', $i+1)->where('count', $min_reg)->first()->region;
                    }
                    $filter[$i]['year'] = $this->myRequest->year;
                    $filter[$i]['month'] = $i+1;
                    $filter[$i]['day'] = '';
                    $filter[$i]['hour'] = '';
                    $filter[$i]['max'] = is_null($max_reg) ? "0" :  (string)$max;
                    $filter[$i]['min'] = is_null($min_reg) ? "0" :  (string)$min;
                    $filter[$i]['max_regname'] = is_null($max_reg) ? ""  :  $max_reg_name;
                    $filter[$i]['min_regname'] = is_null($min_reg) ? "" : $min_reg_name;
                }
            }
        } elseif (!empty($this->myRequest->year) and $this->myRequest->month != "0" and ($this->myRequest->day == "0" or $this->myRequest->day == "all")) {
            $masks = DB::table((new Heatmap())->getTable())->where('user_model_branch_id', $this->myRequest->usermodelbranchid)->where('image_id', $this->myRequest->image_id)->where('year', $this->myRequest->year)->where('month', $this->myRequest->month)->groupBy('day')->groupBy('region')->get([
                'day',
                'region',
                DB::raw("SUM(value) as count")
            ]);
            $filter = [];

            if (count($masks) > 0) {
                for ($i=0; $i < 31 ; $i++) {
                    $total = $masks->sum('count');
                    $max_reg = $masks->where('day', $i+1)->max('count');
                    $min_reg = $masks->where('day', $i+1)->min('count');

                    if (!is_null($max_reg)) {
                        $max = round($max_reg / $total * 100);
                        $max_reg_name = $masks->where('day', $i+1)->where('count', $max_reg)->first()->region;
                    }
                    if (!is_null($max_reg)) {
                        $min = round($min_reg / $total * 100);
                        $min_reg_name = $masks->where('day', $i+1)->where('count', $min_reg)->first()->region;
                    }

                    $filter[$i]['year'] = $this->myRequest->year;
                    $filter[$i]['month'] = $this->myRequest->month;
                    $filter[$i]['day'] = $i+1;
                    $filter[$i]['hour'] = '';
                    $filter[$i]['max'] = is_null($max_reg) ? "0"  :  (string)$max;
                    $filter[$i]['min'] = is_null($min_reg) ? "0"  :  (string)$min;
                    $filter[$i]['max_regname'] = is_null($max_reg) ? ""  :  $max_reg_name;
                    $filter[$i]['min_regname'] = is_null($min_reg) ? "" : $min_reg_name;
                }
            }
        } elseif (!empty($this->myRequest->year) and ($this->myRequest->month != "0" or $this->myRequest->month !="all") and ($this->myRequest->day != "0" or $this->myRequest->day != "all")) {
            $masks = DB::table((new Heatmap())->getTable())->where('user_model_branch_id', $this->myRequest->usermodelbranchid)->where('image_id', $this->myRequest->image_id)->where('year', $this->myRequest->year)->where('month', $this->myRequest->month)->where('day', $this->myRequest->day)->groupBy('hour')->groupBy('region')->get([
                'hour',
                'region',
                DB::raw("SUM(value) as count")
            ]);

            $filter = [];
            if (count($masks) > 0) {
                for ($i=0; $i < 24 ; $i++) {
                    $total = $masks->sum('count');
                    $max_reg = $masks->where('hour', $i)->max('count');
                    $min_reg = $masks->where('hour', $i)->min('count');

                    if (!is_null($max_reg)) {
                        $max = round($max_reg / $total * 100);
                        $max_reg_name = $masks->where('hour', $i)->where('count', $max_reg)->first()->region;
                    }
                    if (!is_null($max_reg)) {
                        $min = round($min_reg / $total * 100);
                        $min_reg_name = $masks->where('hour', $i)->where('count', $min_reg)->first()->region;
                    }

                    $filter[$i]['year'] = $this->myRequest->year;
                    $filter[$i]['month'] = $this->myRequest->month;
                    $filter[$i]['day'] = $this->myRequest->month;
                    $filter[$i]['hour'] =  $i+1;
                    $filter[$i]['max'] = is_null($max_reg) ? "0"  :  (string)$max;
                    $filter[$i]['min'] = is_null($min_reg) ? "0"  :  (string)$min;
                    $filter[$i]['max_regname'] = is_null($max_reg) ? ""  :  $max_reg_name;
                    $filter[$i]['min_regname'] = is_null($min_reg) ? "" : $min_reg_name;
                }
            }
        }


        return collect($filter);
    }

    public function headings(): array
    {
        return [
            'year',
            'month',
            'day',
            'hour',
            'Min value',
            'Max value',
            'Max Region',
            'Min Region',
        ];
    }
}
