<?php

namespace App\Http\Repositories\Interfaces;
use Illuminate\Support\Facades\Request;

interface MaskRepoInterface
{
    public function shiftSettingSave($request,$usermodelbranchid);
    public function getUserModels();
    public function getUserBranchModels($usermodelbranchid);
    public function getUserBranches();
    public function getUserShiftSettingByUserModel($usermodelbranchid);
    public function getRecordsByUserModelId($usermodelbranchid,$start,$end,$starttime=null,$endtime=null);
    public function getStatisticsByUserModelId($usermodelbranchid,$start,$end,$starttime=null,$endtime=null);
    public function getRecordsByUserModelIdexport($usermodelbranchid,$start,$end,$starttime=null,$endtime=null);
}
