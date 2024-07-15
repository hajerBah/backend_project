<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the file upload
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Process file upload
        if ($request->file('file')) {
            $imageName = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('uploads'), $imageName);

            return response()->json(['success' => 'File uploaded successfully.', 'file' => $imageName], 200);
        }

        return response()->json(['error' => 'File upload failed.'], 400);
    }
}
