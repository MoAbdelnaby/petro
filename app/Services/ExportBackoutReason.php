<?php

namespace App\Services;


use App\Exports\BackoutExport;
use App\Models\Branch;
use Carbon\Carbon;
use Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PDF;

class ExportBackoutReason implements IExportFile
{
    /**
     * @param $file
     * @return bool
     */
    public function export($file): bool
    {
        try {
            $branch_id = $file->branch_id;
            $branch = Branch::where('id', $branch_id)->first();

            $type = $file->type;

            $query = \DB::table('backout_reasons')
                ->select('backout_reasons.*', 'branches.name as branch_name')
                ->join('branches', 'backout_reasons.station_code', '=', 'branches.code')
                ->whereNull('branches.deleted_at')
                ->where('backout_reasons.station_code', '=', $branch->code)
                ->orderBy('backout_reasons.id', 'DESC');

            if ($file->start) {
//                $start = date('Y-m-d h:i:s', strtotime($file->start . ' 00:00:00'));
                $query = $query->whereDate('backout_reasons.created_at', '>=', Carbon::parse($file->start));
            }

            if ($file->end) {
//                $end = date('Y-m-d h:i:s', strtotime($file->end . ' 00:00:00'));
                $query = $query->whereDate('backout_reasons.created_at', '<=', Carbon::parse($file->end));
            }

            $result = [];
            $query->chunk(500, function ($item) use (&$result) {
                $result = array_merge($result, $item->toArray());
            });


            $path = "branches/$file->branch_id/files/backout_reasons";

            $file_path = $path . '/' . $file->name;

            $check = false;

            if ($type == 'pdf') {
                $list['data'] = $result;
                $list['title'] = "Brach " . $result[0]->branch_name . " Message";
                $list['start'] = $file->start ?? 'First Date';
                $list['end'] = $file->end ?? 'Last Date';
                $check = PDF::loadView('customer.backout_reasons.files.pdf', compact('list'))
                    ->setOptions(['defaultFont' => 'sans-serif'])
                    ->save(storage_path() . '/app/public/' . $file_path);

            } elseif ($type == 'xls') {
                $check = Excel::store(new BackoutExport($result), 'public/' . $file_path);
            }

            if ($check) {
                $file->url = $file_path;
                $file->status = true;
                $file->size = Storage::disk('public')->size($file_path);
                $file->save();
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }

        return true;
    }

}
