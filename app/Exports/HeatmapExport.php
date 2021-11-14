<?php

namespace App\Exports;

use App\Models\Heatmap;
use App\Models\ImagePosition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

class HeatmapExport implements FromCollection, WithHeadings
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
        $filter = [];
        if ($this->myRequest->year == "all") {
            $masks = DB::table((new Heatmap())->getTable())->where('user_model_branch_id', $this->myRequest->usermodelbranchid)->where('image_id', $this->myRequest->image_id)->select(['region', DB::raw("SUM(value) as count"),'year'])->groupBy('region')->groupBy('year')->get();

            if (count($masks) > 0) {
                foreach ($masks as $key=>$mask) {
                    $filter[$key]['year'] = $mask->year;
                    $filter[$key]['month'] = '';
                    $filter[$key]['day'] = '';
                    $filter[$key]['hour'] = '';
                    $filter[$key]['region'] = $mask->region ;
                    $filter[$key]['count'] = $mask->count;
                }
            }
        } elseif ($this->myRequest->year != "all" and   $this->myRequest->month == "all") {
            $masks = DB::table((new Heatmap())->getTable())->where('user_model_branch_id', $this->myRequest->usermodelbranchid)->where('image_id', $this->myRequest->image_id)->where('year', $this->myRequest->year)->select(['region', DB::raw("SUM(value) as count"),'month'])->groupBy('region')->groupBy('month')->get();

            foreach ($masks as $key=>$mask) {
                $filter[$key]['year'] = $this->myRequest->year;
                $filter[$key]['month'] =  $mask->month;
                $filter[$key]['day'] = '';
                $filter[$key]['hour'] = '';
                $filter[$key]['region'] = $mask->region ;
                $filter[$key]['count'] = $mask->count;
            }
        } elseif ($this->myRequest->year != "all" and $this->myRequest->month != "all" and  $this->myRequest->day == "all") {
            $masks = DB::table((new Heatmap())->getTable())->where('user_model_branch_id', $this->myRequest->usermodelbranchid)->where('image_id', $this->myRequest->image_id)->where('year', $this->myRequest->year)->where('month', $this->myRequest->month)->select(['region', DB::raw("SUM(value) as count"),'day'])->groupBy('region')->groupBy('day')->get();

            foreach ($masks as $key=>$mask) {
                $filter[$key]['year'] = $this->myRequest->year;
                $filter[$key]['month'] =  $this->myRequest->month;
                $filter[$key]['day'] =  $mask->day;
                $filter[$key]['hour'] = '';
                $filter[$key]['region'] = $mask->region ;
                $filter[$key]['count'] = $mask->count;
            }
        } elseif ($this->myRequest->year != "all" and $this->myRequest->month != "all" and  $this->myRequest->day != "all") {
            $masks = DB::table((new Heatmap())->getTable())->where('user_model_branch_id', $this->myRequest->usermodelbranchid)->where('image_id', $this->myRequest->image_id)->where('year', $this->myRequest->year)->where('month', $this->myRequest->month)->where('day', $this->myRequest->day)->select(['region', DB::raw("SUM(value) as count"),'hour'])->groupBy('region')->groupBy('hour')->get();
            foreach ($masks as $key=>$mask) {
                $filter[$key]['year'] = $this->myRequest->year;
                $filter[$key]['month'] =  $this->myRequest->month;
                $filter[$key]['day'] =  $this->myRequest->day;
                $filter[$key]['hour'] = $mask->hour;
                $filter[$key]['region'] = $mask->region ;
                $filter[$key]['count'] = $mask->count;
            }
        } elseif ($this->myRequest->year == "none") {
            $masks = [];

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
            'region',
            'count'
        ];
    }
}
