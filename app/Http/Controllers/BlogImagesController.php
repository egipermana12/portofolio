<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogImages;
use Illuminate\Support\Facades\Storage;

class BlogImagesController extends Controller
{
    public function storeImage(Request $request, BlogImages $blogImages)
    {
        if ($request->hasFile('image')) {
            $ori = $request->file('image');
            $originName = $ori->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;

            $request->file('image')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return response()->json(
                [
                    'fileName' => $fileName, 
                    'messages' => 'file was uploaded', 
                    'path' => $url
                ]
            );
        }
        
    }
}
