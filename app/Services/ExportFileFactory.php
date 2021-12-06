<?php

namespace App\Services;

class ExportFileFactory
{
    public function handle($type)
    {
        if ($type == 'place') {

            return new ExportPlacesFiles();

        } elseif ($type == 'plate') {

            return new ExportPlatesFiles();

        } elseif ($type == 'message') {

            return new ExportBranchMessage();
        }
        return false;
    }

}
