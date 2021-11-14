<?php

namespace App\Http\Repositories\Interfaces;

interface PackagesRepoInterface
{
    public function getItems($packageid);
    public function getassignedusers($packageid);
}
