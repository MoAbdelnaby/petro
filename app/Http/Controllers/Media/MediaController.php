<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => 'mimes:png,jpg,jpeg,pdf|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $fileNameWithExtension = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            $Extension = $request->file('image')->getClientOriginalExtension();
            $fileNameStore = $fileName . '_' . time() . '.' . $Extension;
            $path = $request->file('image')->storeAs('public/images', $fileNameStore);

            // thumbs
            if (in_array($Extension, ['png', 'jpg', 'jpeg'])) {
//                $thumb_sm = Image::make("storage/app/public/images/{$fileNameStore}")->resize(350, 130)->save(storage_path("app/public/images/thumb/sm/{$fileNameStore}"));
//                $thumb_lg = Image::make("storage/app/public/images/{$fileNameStore}")->resize(1110, 410)->save(storage_path("app/public/images/thumb/lg/{$fileNameStore}"));
            }


            return $fileNameStore;
        }

        return response()->json(['message' => 'Uploading Failed'], 500);
    }

    public function get(Request $request)
    {
//        $file =
        if ($request->has('file') && file_exists()) {

        }
    }

    public function destroy(Request $request)
    {
        if ($request->has('file')) {
            @unlink(storage_path("app/public/images/" . $request->input('file')));
            @unlink(storage_path("app/public/images/thumb/sm/" . $request->input('file')));
            @unlink(storage_path("app/public/images/thumb/lg/" . $request->input('file')));

            return response()->json(['message' => 'Deleted']);
        }

        return response()->json(['message' => 'Deleting Failed', 500]);
    }

}
