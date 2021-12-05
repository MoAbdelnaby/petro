<?php

namespace App\Services;

use App\Models\Config;

class ConfigService
{
    /**
     * @param string $model
     * @return array
     */
    public static function get($model = 'all'): array
    {
        if ($model != 'all') {
            return self::modelQuery($model);
        }

        return self::allModelQuery();
    }

    /**
     * @param $model
     * @return mixed
     */
    protected static function allModelQuery()
    {
        return Config::where('user_id', parentID())
            ->get()
            ->groupBy('model_type')
            ->map(function ($item) {
                return $item->groupBy('key')
                    ->map(function ($type) {
                        return $type->groupBy('value')->map(function ($value) {
                            return $value->filter(function ($key) {
                                if ($key->active != false) {
                                    return $key;
                                }
                            })->map(function ($item) {
                                return $item->view;
                            });
                        });
                    });
            })->toArray();
    }

    /**
     * @param $model
     * @return mixed
     */
    protected static function modelQuery($model)
    {
        return Config::where('user_id', parentID())
            ->where('model_type', $model)
            ->get()
            ->groupBy('key')
            ->map(function ($type) {
                return $type->groupBy('value')->map(function ($value) {
                    return $value->filter(function ($key) {
                        if ($key->active != false) {
                            return $key;
                        }
                    })->map(function ($item) {
                        return $item->view;
                    });
                });

            })->toArray();
    }

}
