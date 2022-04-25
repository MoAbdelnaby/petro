<?php

namespace App\Http\Resources;

class PositionResource
{
    /**
     * @param $positions
     * @return array
     */
    public static function make($positions): array
    {

        return static::resolvePosition($positions);
    }

    /**
     * @param $positions
     * @param null $parent_id
     * @return array
     */
    public static function resolvePosition($positions, $parent_id = null): array
    {
        $children = [];
        $positions = collect($positions)->filter(function ($item) use (&$children, $parent_id) {
            if ($item->parent_id != $parent_id) {
                $children[] = $item;
                return null;
            }
            return $item;
        });

        $json = [];
        $i = 0;
        foreach ($positions as $position) {
            $json[$i] = [
                'id' => $position->id,
                'name' => $position->name,
                'users' => optional($position->users()->select('id','name','avatar')->first())->toArray()??[],
                'children' => array_values(static::resolvePosition($children, $position->id)),
            ];
            $i++;
        }

        return $json;
    }
}
