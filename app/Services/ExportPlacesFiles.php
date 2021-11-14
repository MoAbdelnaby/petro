<?php

namespace App\Services;


use App\Exports\PlacesExcelExport;
use App\Exports\RecieptionExcelExport;
use App\Models\AreaDurationDay;
use App\Models\AreaStatus;
use App\Models\BranchFiles;
use App\Models\PlaceMaintenance;
use App\Models\UserModelBranch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Excel;
use PDF;
use Illuminate\Support\Facades\Storage;

class ExportPlacesFiles
{

    /**
     * @param $file
     * @return bool
     */
    public function export($file): bool
    {
        try {
            $branchid = $file->branchid;
            $usermodelbrancid = $file->user_model_branch_id;
            $model_type = $file->model_type;
            $type = $file->type;

            $status = PlaceMaintenance::where('user_model_branch_id', $usermodelbrancid)->first();

            if ($status == null) return true;

            $modelrecords = PlaceMaintenance::where('user_model_branch_id', $usermodelbrancid)->where('active', 1);
            if ($file->start) {
                $modelrecords = $modelrecords->whereDate('date', '>=', $file->start);
            }
            if ($file->end) {
                $modelrecords = $modelrecords->whereDate('date', '<=', $file->end);
            }

            $result = [];
            $modelrecords->chunk(500, function ($places) use (&$result) {
                $result = $places->toArray();
            });

            $path = "branches/$file->branch_id/files/plates";

            $file_path = $path . '/' . $file->name;

            $headers = array(
                "Content-Type: application/{$type}",
            );

            $check = false;

            if ($result != []) {
                if ($type == 'pdf') {
                    $list = $result;
                    $check = PDF::loadView('customer.preview.places.placespdf', compact('list'))
                        ->save('storage/app/public/' . $file_path);

                } else {
                    $check = Excel::store(new PlacesExcelExport($result), 'public/' . $file_path);
                }
            }

            if ($check) {
                $file->url = $file_path;
                $file->status = true;
                $file->size = Storage::disk('public')->size($file_path);
                $file->save();
            }

            return true;

        } catch
        (Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
    }

}
