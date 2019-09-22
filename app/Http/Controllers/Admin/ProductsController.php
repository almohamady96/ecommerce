<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\ProductsDatatable;
use App\Http\Controllers\Controller;
use App\Model\MallProduct;
use App\Model\OtherData;
use App\Model\Product;

use App\Model\Sizes;
use App\Model\Weight;
use http\Env\Response;
use Illuminate\Http\Request;
use Storage;

class ProductsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(ProductsDatatable $product) {
	return $product->render('admin.products.index', ['title' => trans('admin.products')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function prepare_wight_size() 
	{	
 		if(request()->ajax() and request()->has('dep_id')){
 		//    return get_parent(\request('dep_id'));
 $dep_list = array_diff( explode(',', get_parent(request('dep_id'))), [request('dep_id')]);
 $sizes = Sizes::Where('is_public','yes')
          ->WhereIn('department_id', $dep_list)
          ->OrWhere('department_id',request('dep_id'))
          ->pluck('name_' . session('lang'), 'id');
//$size_2 = Sizes:: Where('department_id',request('dep_id'))->pluck('name_' . session('lang'), 'id');
//$sizes = array_merge(json_decode($size_1,true),json_decode($size_2,true));
// return  $sizes ; 
	$weights = Weight::pluck('name_'.session('lang'), 'id');
	return view('admin.products.ajax.size_weight', [
	    'sizes'=> $sizes,
        'weights' => $weights,
        'product' => Product::find(\request('product_id')),
    ])->render();
	}else{
		return 'رجاء  اختيار قسم';
	}
}

	/*-----------------------------------------------------------------*/
	public function create() {
	 $product= Product::create([]);
		if(!empty( $product)){
			return redirect(aurl('products/'. $product->id .'/edit'));
		}
       // return view('admin.manufacturers.create', ['title' => trans('admin.add')]);

    }
  //-----------------------------------------------------------
public function delete_main_image($id) {

			 $product = Product::find($id);
			 Storage::delete($product->photo);
			 $product->photo = null;
 			 $product->save();
	 		// 'id' => $fid], 
   	 			  return response(['status' => true], 200);
	}
	//-----------------------------------
	public function update_Product_image ($id) {
	 $product = Product::where('id',$id)->update([
	 	'photo'=> up()->upload([
					'file'        => 'file',
					'path'        => 'products/'.$id,
					'upload_type' => 'single',
					'delete_file' => '',
		]),
   	 ]);
   	 //'photo' => $product->photo
   	 	return response(['status' => true, ], 200);

 	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store() {
/*
        $data = $this->validate(request(),
            [
                'title'            => 'required',
                'content'          => 'required',
                'department_id'    => 'required|numeric',
                'trade_id'         => 'required|numeric',
                'menu_id'          => 'required|numeric',
                'color_id'         => 'sometimes|nullable|numeric',
                'size_id'          => 'sometimes|nullable|numeric',
                'currency_id'      => 'sometimes|nullable|numeric',
                'price'            => 'required|numeric',
                'stock'            => 'required|numeric',
                'start_at'         => 'required|date',
                'end_at'           => 'required|date',
                'start_offer_at'   => 'sometimes|nullable|date',
                'end_offer_at'     => 'sometimes|nullable|date',
                'price_offer'      => 'sometimes|nullable|numeric',
                'weight'           => 'sometimes|nullable',
                'weight_id'        => 'sometimes|nullable|numeric',
                'status'           => 'sometimes|nullable|in:pending,refused,active',
                'reason'           => 'sometimes|nullable|numeric',
                'size'             => 'sometimes|nullable',

            ], [], [
                'title'            => trans('admin.title'),
                'content'          => trans('admin.content'),
                'department_id'    => trans('admin.department_id'),
                'trade_id'         => trans('admin.trade_id'),
                'menu_id'          => trans('admin.menu_id'),
                'color_id'         => trans('admin.color_id'),
                'size_id'          => trans('admin.size_id'),
                'currency_id'      => trans('admin.currency_id'),
                'price'            => trans('admin.price'),
                'stock'            => trans('admin.stock'),
                'start_at'         => trans('admin.start_at'),
                'end_at'           => trans('admin.end_at'),
                'start_offer_at'   => trans('admin.start_offer_at'),
                'end_offer_at'     => trans('admin.end_offer_at'),
                'price_offer'      => trans('admin.price_offer'),
                'weight'           => trans('admin.weight'),
                'weight_id'        => trans('admin.weight_id'),
                'status'           => trans('admin.status'),
                'reason'           => trans('admin.reason'),
                'size'             => trans('admin.size'),
            ]);
        Product::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('products'));
*/
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
    {
        $product = Product::find($id);
      //  $title = trans('admin.edit');
       return view('admin.products.product', ['title' => trans('admin.create_or_edit_product', ['title' => $product->title]), 'product' => $product]);
       // return view('admin.products.edit', compact('product', 'title'));
    }


    /**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function upload_file($id) {
		if (request()->hasFile('file')) {
			$fid =  up()->upload([
					'file'        => 'file',
					'path'        => 'products/'.$id,
					'upload_type' => 'files',
					'file_type'   => 'product',
					'relation_id' =>  $id ,
				]);
			  return response(['status' => true, 'id' => $fid], 200);
		}


	}

	public function delete_file() 
	   {
			if (request()->has('id')) {
  			  up()->delete(request('id'));
		}
 	}
 
	public function update( $id) {

		$data = $this->validate(request(),
			[
				'title'            => 'required',
				'content'          => 'required',
				'department_id'    => 'required|numeric',
				'trade_id'         => 'required|numeric',
				'manu_id'          => 'required|numeric',
				'color_id'         => 'sometimes|nullable|numeric',
                'size_id'          => 'sometimes|nullable|numeric',
                'currency_id'      => 'sometimes|nullable|numeric',
                'price'            => 'required|numeric',
                'stock'            => 'required|numeric',
                'start_at'         => 'required|date',
                'end_at'           => 'required|date',
                'start_offer_at'   => 'sometimes|nullable|date',
                'end_offer_at'     => 'sometimes|nullable|date',
                'price_offer'      => 'sometimes|nullable|numeric',
                'weight'           => 'sometimes|nullable',
                'weight_id'        => 'sometimes|nullable|numeric',
                'status'           => 'sometimes|nullable|in:pending,refused,active',
                'reason'           => 'sometimes|nullable|numeric',
                'size'             => 'sometimes|nullable',

            ], [], [
				'title'            => trans('admin.title'),
				'content'          => trans('admin.product_content'),
				'department_id'    => trans('admin.department_id'),
				'trade_id'         => trans('admin.trade_id'),
				'manu_id'          => trans('admin.manu_id'),
				'color_id'         => trans('admin.color_id'),
                'size_id'          => trans('admin.size_id'),
                'currency_id'      => trans('admin.currency_id'),
                'price'            => trans('admin.price'),
                'stock'            => trans('admin.stock'),
                'start_at'         => trans('admin.start_at'),
                'end_at'           => trans('admin.end_at'),
                'start_offer_at'   => trans('admin.start_offer_at'),
                'end_offer_at'     => trans('admin.end_offer_at'),
                'price_offer'      => trans('admin.price_offer'),
                'weight'           => trans('admin.weight'),
                'weight_id'        => trans('admin.weight_id'),
                'status'           => trans('admin.status'),
                'reason'           => trans('admin.reason'),
                'size'             => trans('admin.size'),
            ]);
        if (request()->has('mall') ) {
            MallProduct::where('product_id',$id)->delete();
            foreach (request('mall') as $mall){
                MallProduct::create([
                    'product_id'=>$id,
                    'mall_id'=>$mall,
                ]);
            }
        }
            if (request()->has('input_value') && request()->has('input_key')){
		    $i=0;
		    $other_data="";
		    OtherData::where('product_id',$id)->delete();
		    foreach (request('input_key') as $key){
		        $data_value=!empty(\request('input_value')[$i])?\request('input_value')[$i]:'';
		        OtherData::create([
		           'product_id'=>$id,
                    'data_key'=>$key,
                    'data_value'=>$data_value,

                ]);
		       // $other_data .= $key . '||' . request('input_value')[$i] .'|';
		        $i++;
            }
		    $data['other_data']=rtrim($other_data , '|');
        }
		Product::where('id', $id)->update($data);
		return response(['status'=>true,'message'=>trans('admin.updated_record')],200);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$products = Product::find($id);
		Storage::delete($products->logo);
		$products->delete();
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {
			foreach (request('item') as $id) {
				$products = Product::find($id);
				Storage::delete($products->logo);
				$products->delete();
			}
		} else {
			$products = Product::find(request('item'));
			Storage::delete($products->logo);
			$products->delete();
		}
		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}

}