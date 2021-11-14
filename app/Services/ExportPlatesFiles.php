<?php

namespace App\Services;


use App\Exports\PlatesExcelExport;
use App\Models\Carprofile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Excel;
use PDF;

class ExportPlatesFiles
{
    /**
     * @param $file
     * @return bool
     */
    public function export($file): bool
    {
        try {
            $branchid = $file->branch_id;
            $type = $file->type;
            $start = date('Y-m-d h:i:s', strtotime($file->start . ' 00:00:00'));
            $end = date('Y-m-d h:i:s', strtotime($file->end . ' 00:00:00'));


            $query = Carprofile::selectRaw('carprofiles.*')
                ->where('status', 'completed')
                ->where('branch_id', $branchid);

            if ($start) {
                $query = $query->whereDate('checkInDate', '>=', $start);
            }

            if ($end) {
                $query = $query->whereDate('checkInDate', '<=', $end);
            }

            $result = [];
            $query->chunk(500, function ($plates) use (&$result) {
                $result[] = $plates->toArray();
            });

            $path = "branches/$file->branch_id/files/plates";

            $file_path = $path . '/' . $file->name;

            $headers = array(
                "Content-Type: application/{$type}",
            );

            $check = false;
            if ($type == 'pdf') {
                if ($result != []) {
                    $list = $result[0];

                    $check = PDF::loadView('customer.preview.plates.platespdf', compact('list'))
                        ->save('storage/app/public/' . $file_path);
                }
            } else {
                if ($result != []) {
                    $check = Excel::store(new PlatesExcelExport($result[0]), 'public/' . $file_path);
                }
            }

            if ($check) {
                $file->url = $file_path;
                $file->status = true;
                $file->size = Storage::disk('public')->size($file_path);
                $file->save();
            }

            return true;

        } catch (Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }

}
