<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $model;
    private $paaginateNumber = 10;
    private $view = 'Dashboard.products.';
    public function __construct(Product $product){
        $this->model =new Repository($product);
    }
    public function index(Request $request){
          //dd(substr(base64_encode(addslashes(file_get_contents(request()->file('image')))),0,200));
        $products = Product::where(function($query){

            if(request()->filled('height') && request()->filled('width')){
               // dd('sdf');
               $query->where('height', request()->height)
               ->where('width', request()->width);
              //  $query->where('height', '=', 'request()->height');
            }
            /*
            if (request()->filled('image')) {
               // dd('sdf1');
                $query->where('base_image', 'like', '%' . substr(base64_encode(file_get_contents(request()->file('image'))),0,200) . '%');
            }
            **/
           // dd('sdf2');
        })->latest()->paginate($this->paaginateNumber);

        return view($this->view . 'index', compact('products'));

    }
    public function create(){
        return view($this->view . 'create');
    }
    public function store(ProductRequest $request){
        try {
            $imagedata = substr(base64_encode(file_get_contents($request->file('image'))),0,200);
         // $imagedata = base64_encode(request()->image);
          //  dd($imagedata);
         // iVBORw0KGgoAAAANSUhEUgAAA9EAAADfCAIAAAB+sMfJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAKdiSURBVHhe7b1ZehxHsuerragIIBOZibMHdYmDROipH+59qk8iCYJb6DoUiWEJdUQSw/26F8ASCWAB3Q8sEsMi
            /*
            dd($imagedata);
            $img = $request['image'];
            $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        dd($image_base64);
         // dd($request->all());
         $stt = ''; // string containing base64 encoded image files.
         preg_match('#data:image/(gif|png|jpeg);base64,([\w=+/]++)#', $stt, $x);
         while(isset($x[0]))
         {
             dd('sdf1');
             $imgdata = base64_decode($x[0]);
             $info = explode(";", explode("/", $x[0])[1])[0];
             $textareaImages = $request->image;

             $imm = Image::make(file_get_contents($x[0]));
             $imp = public_path().'/uploads/product_images';
             $imn = date('y_m_d') . "_" . uniqid().".".$info;
             $imm->save($imp.$imn);

             $stt = str_replace($x[0], 'http://127.0.0.1:8000//uploads/product_images/'.$imn, $stt);
             preg_match('#data:image/(gif|png|jpeg);base64,([\w=+/]++)#', $stt, $x);

         }

         dd('sdf2');
         return $stt;
         dd('sdf');
         **/

            $request_data = $request->except('image');

            if ($request->image) {

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/product_images/' . $request->image->hashName()));

                $request_data['image'] = $request->image->hashName();

            }
            DB::table('products')->insert([
                'base_image' => $imagedata,
                'image' =>  $request_data['image'],
                'name' => $request_data['name'],
                'height' => $request_data['height'],
                'width' => $request_data['width'],
                'description' => $request_data['description']

            ]);
            // $this->model->create($request_data);
            // return true;
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('admin.products');

        } catch (\Exception $ex) {
              return $ex;
            return redirect()->route('admin.products')->with(['error'=> 'eror in data']);
        }
     }
    public function edit($id){
       $product = $this->model->getByID($id);
        if(!$product){
            return redirect()->route('admin.products')->with(['error' => 'products not found']);
        }
        return view($this->view . 'edit', compact('product'));
    }
    public function update(ProductRequest $request, $id){
    try {
       // return $request;
        $request_data = $request->except(['_token', 'image']);
        $product = $this->model->getByID($id);
        if(!$product){
            return redirect()->route('admin.products')->with(['error' => 'this products not found']);
        }
        if ($request->image) {
            if ($product->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
            }//end of if

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        }
           $this->model->update($request_data, $id);

        session()->flash('success', __('site.edited_successfully'));
            return redirect()->route('admin.products');
    } catch (\Exception $ex) {
              return $ex;
        return redirect()->route('admin.products')->with(['error'=> 'Error in data']);
    }
    }
    public function destroy($id){
        try {
            $product = $this->model->getByID($id);
            if(!$product){
                return redirect()->route('admin.products')->with(['error' => 'this products not found']);
            }
            if ($product->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
            }//end of if
         $product->delete($id);
           session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('admin.products');
        } catch (\Exception $ex) {
            return redirect()->route('admin.products')->with(['error'=> 'error in data']);
        }
    }

}
