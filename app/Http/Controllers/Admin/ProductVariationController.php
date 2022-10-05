<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ThemeVariable;

class ProductVariationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    public function add()
    {
        return response()->json([
            'view'  => view('admin.product.variation.add', ['product_id' => request('product_id')])->render()
        ]);
    }
    public function edit($id = 0)
    {
        if($id)
            return response()->json([
                'view'  => view('admin.product.variation.add', ['product_id' => request('product_id'), 'variable_id' => $id])->render()
            ]);
    }

    public function post(Request $request)
    {
        $data = $request->all();
        // dd($data);
        if($data['attribute_sets']){
            $parent = 0;
            $id = $data['id'];
            $variable_edit = ThemeVariable::find($id);
            if($variable_edit){
                $variable_edit->delete();
                ThemeVariable::where('parent', $variable_edit->id)->delete();
            }

            $galleries = $data['gallery'] ?? '';
            if($galleries!=''){
                $galleries = array_filter($galleries);
                $data['gallery'] = $galleries ? serialize($galleries) : '';

            }

            foreach ($data['attribute_sets'] as $key => $attr) {
                if($attr){
                    if($id){
                        $next_attr = ThemeVariable::where('parent', $id)->where('variable_parent', $key)->first();
                        if($next_attr)
                            $id = $next_attr->id;
                    }
                    $db = ThemeVariable::updateOrCreate(
                        [
                            'id' => $id,
                            'variable_parent'   => $key,
                        ],
                        [
                            'theme_id' => $data['product_id'],
                            'variable_id' => $attr,
                            'parent'   => $parent,
                            'sku'   => $data['sku'] ?? '',
                            'price'   => $data['price'] ?? 0,
                            'promotion'   => $data['promotion'] ?? 0,
                            'image'   => $data['gallery'] ?? '',
                        ]
                    );
                    
                    if($parent == 0){
                        if($db->id){
                            $parent = $db->id;
                            $data['gallery'] = '';
                            $id = 0;
                        }
                    }
                }
            }

            return response()->json([
                'error' => 0,
                'view'  => view('admin.product.variation.variation-list', ['product_id' => $data['product_id'] ])->render(),
                'msg'   => 'Thêm thành công'
            ]);
        }

        return response()->json([
            'error' => 1,
            'msg'   => 'Thông tin chưa chính xác'
        ]);
    }

    public function delete()
    {
        $id = request()->id;
        $variable_edit = ThemeVariable::find($id);
        $variable_edit->delete();
        ThemeVariable::where('parent', $variable_edit->id)->delete();

        return response()->json([
            'error' => 0,
            'msg'   => 'Delete success'
        ]);
    }
}
