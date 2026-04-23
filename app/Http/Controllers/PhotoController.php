<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->get();
        return view('upload', compact('photos'));
    }

    public function create()
    {
        // Pass $photos to the view, even if empty
        $photos = Photo::latest()->get();
        return view('upload', compact('photos'));
    }

    public function storeSingle(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $image = $request->file('image');
        $name = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $name);

        Photo::create(['image' => $name]);

        return back()->with('success', 'Single image uploaded successfully!');
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $uploadedImages = [];
        
        foreach ($request->file('images') as $image) {
            $name = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $name);

            Photo::create(['image' => $name]);
            $uploadedImages[] = $name;
        }

        return back()->with('success', count($uploadedImages) . ' images uploaded successfully!');
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        
        // Delete the file from storage
        $filePath = public_path('images/' . $photo->image);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        $photo->delete();
        
        return back()->with('success', 'Image deleted successfully!');
    }
}