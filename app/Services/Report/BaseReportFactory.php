<?php

namespace App\Services\Report;

use Exception;

class BaseReportFactory
{
    /**
     * Handle Creating object for correct report type
     *
     * @throws Exception
     */
    public static function handle($type)
    {
        try {
            $className = config("app.report.type.$type.className");

            $full_name = "\App\\Services\\Report\\type\\" . $className;

            //Prepare Class Report BaseOn Report type
            return new $full_name();

        } catch (\Error $e) {
            throw new Exception($e->getMessage());
        }
    }
}
