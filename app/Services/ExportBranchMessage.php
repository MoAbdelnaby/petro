<?php

namespace App\Services;


use App\Exports\PlacesExcelExport;
use Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PDF;

class ExportBranchMessage implements IExportFile
{
    /**
     * @param $file
     * @return bool
     */
    public function export($file): bool
    {
        try {
            $branch_id = $file->branch_id;
            $type = $file->type;

            $query = \DB::table('message_logs')
                ->select('message_logs.*', 'branches.name as branch_name')
                ->join('branches', 'message_logs.branch_id', '=', 'branches.id')
                ->where('message_logs.branch_id', '=', $branch_id)
                ->orderBy('message_logs.id', 'DESC');

            if ($file->start) {
                $start = date('Y-m-d h:i:s', strtotime($file->start . ' 00:00:00'));
                $query = $query->whereDate('message_logs.created_at', '>=', $start);
            }

            if ($file->end) {
                $end = date('Y-m-d h:i:s', strtotime($file->end . ' 00:00:00'));
                $query = $query->whereDate('message_logs.created_at', '<=', $end);
            }

            $result = [];
            $query->chunk(500, function ($item) use (&$result) {
                $result = array_merge($result, $item->toArray());
            });


            $path = "branches/$file->branch_id/files/messages";

            $file_path = $path . '/' . $file->name;

            $check = false;

            if ($type == 'pdf') {
                $list['data'] = $result;
                $list['title'] = "Brach " . $file->branch_name . " Message";
                $list['start'] = $file->start ?? 'First Date';
                $list['end'] = $file->end ?? 'Last Date';
                $check = PDF::loadView('customer.branch_messages.files.pdf', compact('list'))
                    ->setOptions(['defaultFont' => 'sans-serif'])
                    ->save(storage_path() . '/app/public/' . $file_path);

            } elseif ($type == 'xls') {
                $check = Excel::store(new PlacesExcelExport($result), 'public/' . $file_path);
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
