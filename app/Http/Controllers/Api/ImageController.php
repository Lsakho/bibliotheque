<?php
  
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Image;
  
use Illuminate\Http\Request;
  
class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('imageUpload');
    }
      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
      
        $imageName = time().'.'.$request->image->extension();  
       
        $request->image->move(public_path('images'), $imageName); 
    
        $name = $request->file('image')->getClientOriginalName();
 
        $path = $request->file('image')->store('app/public/images');
 
 
        $save = new Image;
 
        $save->name = $name;
        $save->path = $path;
        $save->imageable_type = Author::find(1);
        $save->imageable_id = '2';



 
        $save->save();

        return back()
            ->with('success','You have successfully upload image.')
            ->with('image',$imageName); 
    }
}