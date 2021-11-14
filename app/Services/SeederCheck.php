<?php

namespace App\Services;

class SeederCheck
{
    protected static $running = false;

    public static function isRunning(): bool
    {
        return static::$running;
    }

    public static function start(): void
    {
        static::$running = true;
    }

}
