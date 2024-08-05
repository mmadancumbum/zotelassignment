<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ImageGallery;


class ImageGalleryController extends Controller
{

    public function index()
    {
    	$images = ImageGallery::all();
    	return view('image-gallery',compact('images'));
    }

    public function upload(Request $request)
    {
    	$this->validate($request, [
    		'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $input['image']);


        $input['title'] = $request->title;
        $input['description'] = $request->description;
        ImageGallery::create($input);


    	return back()->with('success','Image Uploaded successfully.');
    }


    public function edit($id)
    {
    	$images = ImageGallery::find($id);
    	return response()->json([
            'data' => $images,
            'status' => 200
        ]);
    }

    public function update(Request $request)
    {
        // dd($request->all());
    	$images = ImageGallery::find($request->id);
        $images->title = $request->title;
        $images->description = $request->description;
        $images->save();

    	return redirect('image-gallery')->with('success','Updated successfully');
    }

    public function destroy($id)
    {
    	ImageGallery::find($id)->delete();
    	return back()
    		->with('success','Image removed successfully.');	
    }
}
