<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Images;

class ImagesController extends Controller
{
    public function index()
    {
        // $images = DB::table('images')->get();
        // return view('images.index', compact('images'));
        return Images::all();
    }

    public function store(Request $request)
    {
        // $image = $request->file('image');
        // $path = $image->store('images', 'public');
        // $imageUrl = Storage::url($path);

        // DB::table('images')->insert([
        //     'image_url' => $imageUrl
        // ]);

        // return redirect()->route('images.index')
        //     ->with('success', 'Image uploaded successfully');
        $images = new Images;
        $images->image_url = $request->file('image_url')->store('uploadedImgs');
        $images->save();
        return $images;
    }

    public function destroy($id)
    {
        // $image = DB::table('images')->find($id);
        // $path = str_replace(Storage::url(''), '', $image->image_url);
        // Storage::delete($path);

        // DB::table('images')->where('id', $id)->delete();

        // return redirect()->route('images.index')
        //     ->with('success', 'Image deleted successfully');
    }
}