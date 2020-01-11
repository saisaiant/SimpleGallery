<?php

namespace App\Http\Controllers;

use App\Album;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Inline\Element\Strong;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::get();
        return view('home', compact('images'));
    }


    public function album()
    {
        $albums = Album::with('images')->get();
        return view('welcome', compact('albums'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'album' => 'required|min:3|max:15',
            'image' => 'required'
        ]);

        $album = Album::create(['name' => $request->get('album')]);
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('uploads', 'public');
                Image::create([
                    'name' => $path,
                    'album_id' => $album->id
                ]);
            }
        }
        return "<div class='alert alert-success'>Successfully</div>";
    }

    public function show($id)
    {
        $albums = Album::findOrFail($id);
        return view('gallery', compact('albums'));
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $filname = $image->name;
        $image->delete();
        Storage::delete('public/'.$filname);
        return redirect('/')->with('msg', "deleted");
        //dd($image->id);
    }

    public function addImage(Request $request)
    {
        $albumId = request('id');
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('uploads', 'public');
                Image::create([
                    'name' => $path,
                    'album_id' => $albumId
                ]);
            }
        }
        return redirect()->back()->with('msg', "Added");
    }

}
