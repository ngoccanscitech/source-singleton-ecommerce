<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ShopProduct, App\Model\Category_Theme, App\Model\Join_Category_Theme, App\Model\Theme_variable_sku, App\Model\Theme_variable_sku_value, App\Model\ThemeVariable;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use Auth, DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ProcessImportData;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function listProduct(){
        if(Auth::guard('admin')->user()->admin_level == 99999){
            /*$data_product = ShopProduct::orderByDesc('id')->paginate(20);
            $count_item = ShopProduct::select('theme.*')
            ->count();*/

            $db = ShopProduct::select('*');

           
            if(request('category_id')){
                $db = $db->join('shop_product_category as pc', 'pc.product_id', 'shop_products.id')->where('category_id', request('category_id'));
            }

            if(request('search_title') != ''){
                $db->where('name', 'like', '%' . request('search_title') . '%');
            }
            

            $data_product = $db->orderByDesc('id')->paginate(20);
            $count_item = ShopProduct::select('theme.*')->count();
        }
        else{
            $data_product = ShopProduct::where('admin_id', '=', Auth::guard('admin')->user()->id)
            ->orderByDesc('id')
            ->paginate(20);
            $count_item = ShopProduct::where('admin_id', '=', Auth::guard('admin')->user()->id)
            ->count();
        }
        return view('admin.product.index')->with(['data_product' => $data_product, 'total_item' => $count_item]);
    }

    
    public function createProduct(){
        $data['variables_selected'] = [];
        $data['listUnit'] = $this->listUnit();
        return view('admin.product.single', $data);
    }

    public function productDetail($id){
        $variables_join = \App\Model\ThemeVariable::where('theme_id', $id)->get();
        $variables = \App\Model\ThemeVariable::where('theme_id', $id)->get('variable_id');
        $variables_selected = [];
        foreach ($variables as $key => $item) {
            $variables_selected[] = $item->variable_id;
        }
        $product_detail = ShopProduct::find($id);
        $listUnit = $this->listUnit();


        if($product_detail){
            return view('admin.product.single', compact('product_detail', 'variables_selected', 'variables_join', 'listUnit'));
        } else{
            return view('404');
        }
    }

    public function postProductDetail(Request $rq){
        $datetime_now = date('Y-m-d H:i:s');
        $datetime_convert = strtotime($datetime_now);
        // $data = $rq->all();
        $data = request()->except(['_token', 'gallery', 'variable', 'created', 'submit', 'category_item', 'taginfo', 'tab_lang', 'stt', 'brand_item', 'element_item']);
        //id post
        $sid = $rq->id ?? 0;
        // $data['name'] = $rq->title ?? '';
        // dd($rq->note);

        $data['slug'] = addslashes($rq->slug);
        if($data['slug'] == '')
           $data['slug'] = Str::slug($data['name']);

        $data['price'] = $rq->price ? str_replace(',', '', $rq->price) : 0;
        $data['promotion'] = $rq->promotion ? str_replace(',', '', $rq->promotion) : 0;

        $data['description'] = $rq->description ? htmlspecialchars($rq->description) : '' ;
        $data['content'] = $rq->content ? htmlspecialchars($rq->content) : '' ;

        //lang
        $tab_langs = $rq->tab_lang ?? '';
        if(is_array($tab_langs)){
            foreach ($tab_langs as $key => $lang) {
                $title_lang = 'name_'. $lang;
                $description = 'description_'. $lang;
                $content = 'content_'. $lang;

                $data['description_'. $lang] = $rq->$title_lang ? $rq->$title_lang : '' ;
                $data['description_'. $lang] = $rq->$description ? htmlspecialchars($rq->$description) : '' ;
                $data['content_'. $lang] = $rq->$content ? htmlspecialchars($rq->$content) : '' ;
            }
        }
        
        //xử lý gallery
        $galleries = $rq->gallery ?? '';
        if($galleries!=''){
            $galleries = array_filter($galleries);
            $data['gallery'] = $galleries ? serialize($galleries) : '';

        }
        //end xử lý gallery

        $data['sort'] = $rq->stt ? addslashes($rq->stt) : 0;
        $data['admin_id'] = Auth::guard('admin')->user()->id;


        $save = $rq->submit ?? 'apply';
        // dd($data);
        if($sid > 0){
            $post_id = $sid;
            \App\Model\ShopProductCategory::where('product_id', $sid)->delete();
            $respons = ShopProduct::where("id", $sid)->update($data);
        } else{
            $respons = ShopProduct::create($data);
            $id_insert = $respons->id;
            $post_id = $id_insert;
        }

        $category_items = $rq->category_item ?? '' ;
        if($category_items!=''){
            \App\Model\ShopProductCategory::where('product_id', $post_id)->delete();
            foreach ($category_items as $key => $item) {
                if($item>0){
                    $datas_item = array(
                        "category_id" => $item,
                        "product_id" => $post_id
                    );
                    \App\Model\ShopProductCategory::create($datas_item);
                }
            }
        }

        $brand_items = $rq->brand_item ?? '' ;
        \App\Model\ShopProductBrand::where('product_id', $post_id)->delete();
        if($brand_items!=''){
            foreach ($brand_items as $key => $item) {
                if($item>0){
                    $datas_item = array(
                        "brand_id" => $item,
                        "product_id" => $post_id
                    );
                    \App\Model\ShopProductBrand::create($datas_item);
                }
            }
        }
        //element
        $element_items = $rq->element_item ?? '' ;
        \App\Model\ShopProductElement::where('product_id', $post_id)->delete();
        if($element_items!=''){

            foreach ($element_items as $key => $item) {
                if($item>0){
                    $datas_item = array(
                        "element_id" => $item,
                        "product_id" => $post_id
                    );
                    \App\Model\ShopProductElement::create($datas_item);
                }
            }
        }

        //variable
        $variables = $rq->variable ? array_filter($rq->variable) : '' ;
        if(is_array($variables)){
            foreach ($variables as $key => $item) {
                if($item>0){
                    $datas_item = array(
                        "variable_id" => $item['id'],
                        "theme_id" => $post_id
                    );
                    $variable_db = \App\Model\ThemeVariable::updateOrCreate(
                        $datas_item,
                        [
                            'description' => $item['description'] ?? ''
                        ]
                    );
                }
            }
        }
        //variable

        //them info
         \App\Model\ThemeInfo::updateOrCreate(
            [
                'theme_id' => $post_id
            ],
            [
                'taginfo' => $rq->taginfo ?? ''
            ]
        );

        if($save=='apply'){
            $msg = "Product has been Updated";
            $url = route('admin.productDetail', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.listProduct'));
        }
        
    }

    public function listUnit()
    {
        return [
            'hộp',
            'vỉ',
        ];
    }

    public function import()
    {
        return view('admin.product.import');
    }
    public function importProcess()
    {
        if (request()->hasFile('file_input')) {
            $file = request()->file('file_input');
            $name = "excel-" . time() . '-' . $file->getClientOriginalName();
            $name = str_replace(' ', '-', $name);
            $url_folder_upload = "/excel-file/";
            $url_full_path = $url_folder_upload . $name;
            $file->move(public_path() . $url_folder_upload, $name);

            $importJob = new ProcessImportData( '/public/'.$url_folder_upload .$name );
            $importJob->delay(\Carbon\Carbon::now()->addSeconds(3));
            dispatch($importJob);
            return view('admin.product.import', ['success'=> 'File Excel của bạn sẽ được hoàn tất sau 2 phút!']);
        }
    }
}









