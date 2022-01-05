<?php

namespace App\Services;


use App\Exports\PlatesExcelExport;
use App\Models\Carprofile;
use Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PDF;

class ExportPlatesFiles implements IExportFile
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
                ->where('plate_status', 'success')
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
                $result = array_merge($result, $plates->toArray());
            });

            $path = "branches/$file->branch_id/files/plates";

            if (!is_dir(storage_path("/app/public/".$path))) {
                \File::makeDirectory(storage_path("/app/public/".$path), 777);
            }
            info('branches-status: '. is_dir(storage_path("/app/public/".$path)));
            dd(is_dir(storage_path("/app/public/".$path)));

            $file_path = $path . '/' . $file->name;

            $check = false;
            if ($type == 'pdf') {
                $list = $result;
                $check = PDF::loadView('customer.preview.plates.platespdf', compact('list'))
                    ->save('storage/app/public/' . $file_path);

            } elseif ($type == 'xls') {
                $check = Excel::store(new PlatesExcelExport($result), 'public/' . $file_path);
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
