<?php

namespace App\Services;


use App\Exports\PlacesExcelExport;
use App\Models\PlaceMaintenance;
use Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PDF;

class ExportPlacesFiles implements IExportFile
{

    /**
     * @param $file
     * @return bool
     */
    public function export($file): bool
    {
        try {
            $usermodelbrancid = $file->user_model_branch_id;
            $type = $file->type;

            $modelrecords = PlaceMaintenance::where('user_model_branch_id', $usermodelbrancid)->where('active', 1);

            if ($file->start) {
                $modelrecords = $modelrecords->whereDate('date', '>=', $file->start);
            }
            if ($file->end) {
                $modelrecords = $modelrecords->whereDate('date', '<=', $file->end);
            }

            $result = [];
            $modelrecords->chunk(500, function ($places) use (&$result) {
                $result = array_merge($result, $places->toArray());
            });


            $path = "branches/$file->branch_id/files/places";
            if (!is_dir(storage_path("/app/public/".$path))) {
                \File::makeDirectory(storage_path("/app/public/".$path), 0777, true, true);
            }

            $file_path = $path . '/' . $file->name;

            $check = false;
            if ($type == 'pdf') {
                $list = $result;
                try {

                    $check = PDF::loadView('customer.preview.places.placespdf', compact('list'))
                        ->save(storage_path( 'app/public/' . $file_path));

                } catch (\Exception $e) {
                }
            } elseif ($type == 'xls') {
                $check = Excel::store(new PlacesExcelExport($result), 'public/' . $file_path);
            }


            if ($check) {
                $file->url = $file_path;
                $file->status = true;
                $file->size = Storage::disk('public')->size($file_path);
                $file->save();
            }

            return true;

        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getLine());
        }
        return true;
    }

}
