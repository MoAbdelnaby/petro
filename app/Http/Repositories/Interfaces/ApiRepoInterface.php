<?php

namespace App\Http\Repositories\Interfaces;
use Illuminate\Support\Facades\Request;

interface ApiRepoInterface
{
    public function getUserSettingByBranchModelName($data);
    public function saveDoorRecord($data);
    public function saveRecieptionRecord($data);
    public function saveCarPlatesRecord($data);
    public function savePeopleRecord($data);
    public function saveCarCountRecord($data);
    public function saveEmotionRecord($data);
    public function saveMaskRecord($data);
    public function saveHeatMapRecord($data);
    public function savePlaceRecord($data);
    public function saveScreenShot($screenshot);

}
