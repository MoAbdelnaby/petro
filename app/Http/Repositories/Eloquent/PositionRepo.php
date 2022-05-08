<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\IPosition;
use App\Models\Position;

class PositionRepo extends AbstractRepo implements IPosition
{
    public function __construct()
    {
        parent::__construct(Position::class);
    }

}
