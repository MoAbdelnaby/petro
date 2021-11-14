<?php

namespace App\Http\Repositories\Interfaces;

interface CustomerRepoInterface
{
    public function getactivePackage();
    public function getOldRequests();
    public function getAllPackages();
    public function retrievePackage($packageid);
    public function getPackagesItems($packageid);
    public function packageDetails($package);
}
