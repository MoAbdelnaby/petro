<?php

namespace App\Http\Repositories\Interfaces;

interface ApiRepoInterface
{
    public function getUserSettingByBranchModelName($data);

    public function saveCarPlatesRecord($data);

    public function savePlaceRecord($data);

    public function saveScreenShot($screenshot);

}
