<?php

namespace App\Http\Controllers;

use App\userSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserSettingsController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\userSetting $r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $col)
    {
        $user_id = Auth::user()->id;
        $row = UserSetting::where('user_id', $user_id)->first();

        if (!$row) {
            $create = UserSetting::create([
                'theme' => 'light',
                'user_id' => $user_id,
                'show_items' => 'small',
                'lang' => 'en',
            ]);
        } else {
            $row->{$col} = $request->input('value');
            $row->save();
        }

        if($request->ajax()){
            return response()->json('success');
        }

        return redirect()->back();
    }

}
