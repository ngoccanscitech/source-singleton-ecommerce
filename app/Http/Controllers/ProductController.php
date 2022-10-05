<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory as Category;
use App\Product as Product;
use App\Http\Filters\ProductFilter;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Session;
class ProductController extends Controller
{   
    use \App\Traits\LocalizeController;
    public $data = [];

    public function allProducts()
    {
        $this->localized();
        $this->data['categories'] = Category::where('status', 0)->where('parent', 0)->get();
        $this->data['page'] = \App\Model\Page::where('slug', 'products')->first();
        // $this->data['products'] = Product::orderbyDesc('id')->paginate(20); 
        $data_search = [
            'sort_order'    => 'id__desc',
            'element'    => request('element')??'',
        ];
        $this->data['products'] = (new Product)->getList($data_search); 
        $this->data['categories_list'] = \App\ProductCategory::where('status', 1)->where('parent', 0)->orderby('priority')->limit(10)->get();

        
        return view($this->templatePath .'.product.product-sale', $this->data);
    }

    public function categoryDetail($slug, $province='', $district='', ProductFilter $filter){
        $this->localized();
        $category = Category::where('slug', $slug)->first();
        // dd($category);
        if($category){
            $this->data['categories_list'] = \App\ProductCategory::where('status', 1)->where('parent', 0)->orderby('priority')->limit(12)->get();

            $dataSearch = [
                'sort_order'  => request('sort')??'id__desc',
            ];
            $products_ = (new Product)
                    ->getProductToCategory($category->id)
                    ->getList($dataSearch);

            // dd($posts_);
            /*$db = Product::with('categories')
                ->whereHas('categories', function($query) use($category){
                    return $query->where('category_id', $category->id);
                })
                ->where('status', 1);

            $products = $db->orderbyDesc('id')->paginate(20); */
            // dd($products);
            $this->data['category'] = $category;
            $this->data['products'] = $products_;
            $this->data['slug'] = $slug;
            if($category->parent!=0)
                $this->data['categories'] = Category::where('parent', $category->parent)->get();
            else
                $this->data['categories'] = Category::where('parent', $category->id)->get();

            $this->data['seo'] = [
                'seo_title' => $category->seo_title!=''? $category->seo_title : $category->name,
                'seo_image' => $category->image,
                'seo_description'   => $category->seo_description ?? '',
                'seo_keyword'   => $category->seo_keyword ?? '',

            ];

            return view($this->templatePath .'.product.product-category', $this->data)->compileShortcodes();
        }
        else
            return $this->productDetail($slug);
    }

    public function productDetail($slug){

        $this->localized();

        $product = Product::where('slug', $slug)->first();
        if($product){
            $session_products = session()->get('products.recently_viewed');
            if( !is_array($session_products) ||  array_search($product->id, $session_products) === false){
                session()->push('products.recently_viewed', $product->id);
                $session_products = session()->get('products.recently_viewed');
            }

            // dd($session_products);
            $this->data['product_viewed'] = [];
            if($session_products)
                $this->data['product_viewed'] = Product::whereIn('id', $session_products)->take(10)->get();
            // dd($product_viewed);
            $thongke = \App\Model\Thongke::where('theme_id', $product->id)->first();
            if($thongke){
                $thongke->view = ($thongke->view ?? 0) + 1;
                $thongke->click = ($thongke->click ?? 0) + 1;
                $thongke->save();
            }
            else{
                $thongke = \App\Model\Thongke::create([
                    'theme_id' => $product->id,
                    'view' => 1,
                    'click' => 1
                ]);
            }
            $this->data['category'] = $product->categories->last();
            $this->data['product'] = $product;
            
            $brands = $product->brands()->pluck('name');
            if($brands->count())
                $brand = implode(', ', $brands->toArray());
            $this->data['brand'] = $brand ?? null;

            $elements = $product->element()->pluck('slug');

            if($elements->count()){
                $element = implode(', ', $elements->toArray());
                // dd($element);
            }
            $this->data['element'] = $element ?? null;

            $this->data['related'] = Product::with('getInfo')->whereHas('getInfo', function($query) use($product){
                // return $query->where('province_id', $product->getInfo->province_id)->where('theme_id', '<>', $product->id);
                return $query->where('theme_id', '<>', $product->id);
            })->limit(10)->get();

            $this->data['brc'] = [];
            if($this->data['category']){
                $brc = $this->getCategoryParent($this->data['category']);
                if(count($brc)){
                    $this->data['brc'] = array_reverse($brc);
                }
                array_push($this->data['brc'], ['url' => '' , 'name' => $this->data['product']->name]);
                
            }

            $this->data['seo'] = [
                'seo_title' => $product->seo_title!=''? $product->seo_title : $product->name,
                'seo_image' => $product->image,
                'seo_description'   => $product->seo_description ?? '',
                'seo_keyword'   => $product->seo_keyword ?? '',

            ];
            
            return view($this->templatePath .'.product.product-single', $this->data)->compileShortcodes();
        }
        else{
            return view('errors.404');
        }
    }

    public function getCategoryParent($category, $brc=[])
    {   
        $item = ['url' => route('shop.detail', [$category->slug]) , 'name' => $category->name];
        array_push($brc, $item);
        
        if($category->parent){
            $category = Category::find($category->parent);
            $brc = $this->getCategoryParent($category, $brc);
        }
        return $brc;
    }

    public function getBuyNow()
    {
        $data = request()->all();
        $optionPrice = 0;
        $id = $data['product'];
        $product = \App\Product::find($id);
        if (!$product) {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => 'Không tìm thấy sản phẩm',
                ]
            );
        }
        $variables = \App\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->get();
        // dd($variables);
        $attr = $data['option'] ?? '';
        foreach($variables as $variable){
            if(isset($attr[$variable->id])){
                $form_attr[$variable->id] = $attr[$variable->id];

                $variable_data = explode('__', $attr[$variable->id]);
                if(isset($variable_data[2]))
                    $optionPrice = $variable_data[2];
                elseif(isset($variable_data[1]))
                    $optionPrice = $variable_data[1];
            }
        }
        $price = $optionPrice > 0 ? $optionPrice : $product->getFinalPrice();

        //Check product allow for sale
        
        $option = array(
                'id'      => $id,
                'title'    => $product->title,
                'qty'     => $data['qty'],
                'price'   => $price,
                'options' => $form_attr ?? []
            );
        session()->forget('option');
        session()->push('option', json_encode($option, JSON_UNESCAPED_SLASHES));
        
        return response()->json(
            [
                'error' => 0,
                'msg' => 'Success',
            ]
        );
    }
    public function buyNow($id)
    {
        $product = Product::find($id);
        $option = session()->get('option');
        // dd($option);
        if($option){
            $option = json_decode($option[0], true);
            // dd($option);
            if($option['id'] != $product->id)
                return redirect()->route('shop.detail', $product->slug);
        }
        else
            return redirect()->route('shop.detail', $product->slug);
        if($product){
            $this->data['product'] = $product;
        
            $this->data['seo'] = [
                'seo_title' => 'Mua ngay - '. $product->name,

            ];
            if(session()->has('cart-info')){
                $data = session()->get('cart-info')[0];
                // dd($data);
                $this->data["cart_info"] = $data;
            }
            return view($this->templatePath .'.cart.quick-buy', $this->data);
        }
    }

    public function quickView()
    {
        $id = request()->id;
        if($id){
            $this->localized();

            $product = Product::find($id);
            if($product){
                $session_products = session()->get('products.recently_viewed');

                if( !is_array($session_products) ||  array_search($product->id, $session_products) === false)
                    session()->push('products.recently_viewed', $product->id);

                $this->data['product'] = $product;
                // $this->data['related'] = Product::with('getInfo')->whereHas('getInfo', function($query) use($product){
                //     return $query->where('province_id', $product->getInfo->province_id)->where('theme_id', '<>', $product->id);
                // })->limit(10)->get();
                
                return response()->json([
                    'error' => 0,
                    'msg'   => 'Success',
                    'view'   => view($this->templatePath .'.product.quick-view', ['data'=>$this->data])->compileShortcodes()->render(),
                ]);
                // return view($this->templatePath .'.product.product-single', ['data'=>$this->data])->compileShortcodes();
            }
        }
    }

    public function ajax_categoryDetail($slug)
    {
        $this->localized();
        $category = Category::where('categorySlug', $slug)->first();
        // dd($this->data['category']);
        $lc = $this->data['lc'];
        // dd($category->products);
        $view = view('theme.partials.product-banner-home', compact('category', 'lc'))->render();
        return response()->json($view);
    }

    public function wishlist(Request $request)
    {
        $this->localized();

        $id = $request->id;
        $type = 'save';
        if(auth()->check()){
            $data_db = array(
                'product_id' => $id,
                'user_id' => auth()->user()->id,
            );

            $db = \App\Model\Wishlist::where('product_id', $id)->where('user_id', auth()->user()->id)->first();
            if($db != ''){
                $db->delete();
                $type = 'remove';
            }
            else
                \App\Model\Wishlist::create($data_db)->save();

            $count_wishlist = \App\Model\Wishlist::where('user_id', auth()->user()->id)->count();
            $this->data['count_wishlist'] = $count_wishlist;
            $this->data['status'] = 'success';
        }
        else{
            $wishlist = json_decode(\Cookie::get('wishlist'));
            $key = false;
            

            if($wishlist != '')
                $key = array_search( $id, $wishlist);
            if($key !== false){
                unset($wishlist[$key]);
                $type = 'remove';
            }
            else{
                $wishlist[] = $id;
            }
            $this->data['count_wishlist'] = count($wishlist);
            $this->data['status'] = 'success';
            $cookie = Cookie::queue('wishlist', json_encode($wishlist), 1000000000);
        }
        $this->data['type'] = $type;
        // $this->data['view'] = view('theme.product.includes.wishlist-icon', ['type'=>$type, 'id'=>$id])->render();
        
        return response()->json($this->data);
    }

    public function ajax_get_categories($slug)
    {
        $this->localized();
        if($slug == 'du-an')
        {
            $this->data['type'] = 'project';
            $projects = \App\Model\Project::where('status', 0)->limit(20)->get();
            $this->data['view'] = view('theme.product.includes.category-dropdown', compact('projects'))->render();
        }
        else
        {
            $this->data['type'] = 'category';
            $category_parent = Category::where('categorySlug', $slug)->first();
            $categories = Category::where('categoryParent', $category_parent->categoryID)->get();
            $this->data['view'] = view('theme.product.includes.category-dropdown', compact('categories'))->render();
        }
        
        return response()->json($this->data);
    }


    /*==================attr select=====================*/
    
    public function changeAttr()
    {
        $data = request()->all();
        // dd($data);
        // $attr_id = $data['attr_id'] ? explode('_', $data['attr_id'])[1] : '';
        // dd($attr_id);
        $product = Product::find($data['product']);
        if($product){
            return response()->json(
                [
                    'error' => 0,
                    'show_price' => $product->showPriceDetail($data['option'])->render(),
                    'view'  => view($this->templatePath .'.product.includes.product-variations', [ 'product' => $product, 'attr_id' => $data['attr_id'], 'attr_list_selected' => $data['option'] ])->render(),
                    'msg'   => 'Success'
                ]
            );
        }
    }

    /*==================end attr select=====================*/
}
