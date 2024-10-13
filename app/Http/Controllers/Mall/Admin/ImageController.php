<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function destroy(Request $request)
    {
        Image::where("id", $request->image_id)->delete();
        return back()->with('success', __("main.delete_successffully"));
    }
}
