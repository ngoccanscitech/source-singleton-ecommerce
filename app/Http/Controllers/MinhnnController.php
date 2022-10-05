<?php

namespace App\Http\Controllers;

use App\Facades\WebService;
use App\Model\Category;
use App\Model\Addtocard, App\Model\Addtocard_Detail;
use App\Model\Theme, App\Model\Category_Theme, App\Model\Join_Category_Theme, App\Model\Rating_Product;
use App\Model\Discount_code;
use App\Model\Discount_for_brand;
use App\Model\Check_product_limit_event;
use Illuminate\Http\Request;
use URL;
use Illuminate\Support\Collection, Illuminate\Pagination\LengthAwarePaginator;
use App\User;
use Auth;
use Redirect;
use Route;
use App\Model\Page;

use DB;
use Response;
use Input;
use Mail;
use Validator;
use Cart;
use App\Libraries\Helpers;
use App\Jobs\SendMailNewOrder;


class MinhnnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateCart(Request $request){
        if(Cart::content()->count()>0):
            //$rowId="";
            $id_cart=0;
        foreach(Cart::content() as $cart_items):
            $id_cart=$cart_items->id;
                //dd($cart_items->where('id', $id_cart)->first()->rowId);
                //$rowId = Cart::search(array('id' => $id_cart));
            $rowId=$cart_items->rowId;
            $quantity=(int)$request->qty[$id_cart];
            if($quantity>0):
                Cart::update($rowId, ['qty' => $quantity]);
            endif;
        endforeach;
        $msg = "Cập nhật giỏ hàng thành công.";
        echo "<script language='javascript'>alert('".$msg."');</script>";
        return redirect()->route('cart')->with('status', 'Cập nhật giỏ hàng thành công.');
    endif;
}
public function ajaxUpdateCart(Request $request){
    if(Cart::content()->count()>0):
        $row_id_cart=0;
    foreach(Cart::content() as $cart_items):
        $row_id_cart=$cart_items->rowId;
        if($row_id_cart == $request->row_id_product){
            $quantity=(int)$request->qty;
            if($quantity>0):
                Cart::update($row_id_cart, ['qty' => $quantity]);
            endif;
            $new_price = $cart_items->price*$quantity;
            $new_price = number_format($new_price);
        }
    endforeach;
    $total = Cart::total();
    return json_encode(array('new_price'=>$new_price,'total'=>$total));
endif;
}
public function LoadAjaxAddCart(Request $request){
        // print_r(Cart::content());
    $variables_arr = "";
    $action = addslashes($request->action);
    $product_id=(int)$request->code;
    $product_quantity=(int)$request->quantity;
    $products=Theme::where('id',$product_id)->first();
    if($products):
        if($products->store_status == 0){
            header('Content-Type: application/json');
            return json_encode(array('status'=>'outofstock'));
        }
        $price_pastion=0;
        $date_now = date("Y-m-d H:i:s");
        $discount_for_brand = Discount_for_brand::where('brand_id', '=', $products->id_brand)
        ->where('start_event', '<', $date_now)
        ->where('end_event', '>', $date_now)
        ->first();
        if($discount_for_brand){
            $price_pastion=intval($products->price_origin - $products->price_origin*$discount_for_brand->percent/100);
            $price_origin=number_format($products->price_origin);
            $price_promotion=number_format($products->price_origin - $products->price_origin*$discount_for_brand->percent/100);
        } else{
            if(!empty($products->start_event) && !empty($products->end_event)){
                $date_start_event = $products->start_event;
                $date_end_event = $products->end_event;

                if(strtotime($date_now) < strtotime($date_end_event) && strtotime($date_now) > strtotime($date_start_event)){
                    if(!empty($products->price_promotion) &&  $products->price_promotion >0):
                        $price_pastion=intval($products->price_promotion);
                    else:
                        if(!empty($products->price_origin) &&  $products->price_origin >0):
                            $price_pastion=intval($products->price_origin);
                        else:
                            $price_pastion=0;
                        endif;
                    endif;
                } else{
                    if(!empty($products->price_origin) &&  $products->price_origin >0){
                        $price_pastion= intval($products->price_origin);
                    }
                }

            } 
        }
        $product_quantity=(int)$request->quantity;
        if($request->variable != ''){
            $variables=\GuzzleHttp\json_decode($request->variable);
        }else{
            $variables='';
        }
        $price_add_tocart=$price_pastion;
        if(WebService::objectEmpty($variables)):
            $variables_arr=[];
        else:
            $variables_arr=WebService::objectToArray($variables);
            $key_price_add="";
            $string_json_variable=array();
            for($mh=0;$mh<count($variables_arr);$mh++):
                $string_json_variable=\GuzzleHttp\json_decode($variables_arr[$mh]);

                if(!WebService::objectEmpty($string_json_variable)):
                 $key_price_add .=$string_json_variable->id.",";
             endif;
         endfor;
         $key_price_add=substr($key_price_add,0,-1);
         $query_variable=Helpers::query_value_variable($product_id,$key_price_add);
         if($query_variable):
            $price_add_tocart=$query_variable->price;
        endif;
    endif;
            //dd($price_add_tocart);
    if($action !=""):
        switch($action) {
            case "add":
            Cart::add(['id' => $product_id, 'name' => $products->title, 'qty' => $product_quantity, 'price' => $price_add_tocart, 'options' => $variables_arr]);
            $variables_arr = "";
            header('Content-Type: application/json');
            return json_encode(array('status'=>'ok'));
            break;
            case "update":
                        /*
                        if($product_quantity !=""):
                            if( ($product_quantity == 0) and (is_numeric($product_quantity))){
                                unset ($_SESSION['cart'][$product_id]);
                            }elseif(($product_quantity > 0) and (is_numeric($product_quantity))){
                                $_SESSION['cart'][$product_id]=$product_quantity;
                            }
                        endif;
                        */
                        header('Content-Type: application/json');
                        return json_encode(array('status'=>'ok'));
                        break;
                        case "remove":
                        $rowId = Cart::search(array('id' => $product_id));
                        Cart::remove($rowId[0]);

                        header('Content-Type: application/json');
                        return json_encode(array('status'=>'ok'));
                        break;
                        case "empty":
                        Cart::destroy();
                        header('Content-Type: application/json');
                        return json_encode(array('status'=>'ok'));
                        break;
                    }
                endif;
            endif;
        }
        public function LoadAjaxPost(Request $request){
            $this->validate($request, [
                'category_current' => 'required'
            ],[
                'category_current.required' => 'Thể loại dự án rỗng'
            ]);
            $cate_slug=addslashes($request->category_current);
            $cate_slug_parent=addslashes($request->category_parent);
            $currentpage=(int)$request->page;
            $count_datas=DB::table('category')
            ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
            ->join('post','join_category_post.id_post','=','post.id')
            ->where('post.status','=',0)
            ->where('category.categorySlug','=',$cate_slug)
            ->count();
            $numrows = $count_datas;
            $rowsperpage =Helpers::get_option_minhnn('item-releted-post');
            $totalpages = ceil($numrows / $rowsperpage);
            if ($currentpage > $totalpages) {
                $currentpage = $totalpages;
            }
            if ($currentpage < 1) {
                $currentpage = 1;
            }
            $offset = ($currentpage - 1) * $rowsperpage;
            $Datas=DB::table('category')
            ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
            ->join('post','join_category_post.id_post','=','post.id')
            ->where('post.status','=',0)
            ->where('category.categorySlug','=',$cate_slug)
            ->orderByRaw('post.order_short DESC')
            ->select('post.*','category.categoryName','category.categorySlug','category.categoryParent','category.categoryID','category.seo_title as seo_title_category')
            ->limit($rowsperpage)
            ->offset($offset)
            ->get()
            ->toArray();
        //dd($Datas);
            $count_item=count($Datas);
            $k=0; $thumbnail_thumb=""; $url_img=""; $ahref="";$description_excerpt="";
            if($count_item > 0):
                for($i=0; $i<$count_item; $i++):
                    $k++;
                    $List = $Datas[$i];
                //dd($List->thubnail);
                    $url_img='images/article';
                    if(!empty($List->thubnail) && $List->thubnail !=""):
                        $thumbnail_thumb= Helpers::getThumbnail($url_img,$List->thubnail, 120, 90, "resize");
                        if(strpos($thumbnail_thumb, 'placehold') !== false):
                            $thumbnail_thumb=$thumbnail_thumb;
                        endif;
                    else:
                        $thumbnail_thumb="https://dummyimage.com/120x90/000/fff";
                    endif;
                    if(!empty($List->description) && $List->description !=""):
                        $description_excerpt=WebService::excerpts(htmlspecialchars_decode($List->description),120);
                    else:
                        $description_excerpt=WebService::excerpts(htmlspecialchars_decode($List->content),120);
                    endif;
                    $check_category_parent =Category::where('categorySlug','=',$cate_slug_parent)
                    ->select('categoryID','categoryName','categorySlug','thubnail','thubnail_alt','categoryParent')
                    ->count();
                    if($check_category_parent && $check_category_parent>0):
                        $href=route('tintuc.details_Child_redirect',array($cate_slug_parent,$List->categorySlug,$List->slug));;
                    else:
                        $href=route('tintuc.details',array($List->categorySlug,$List->slug));
                    endif;
                    echo '<div class="col-xs-12 col-sm-12 col-md-12 list_news_full">
                    <div class="contentScroll clear">
                    <div class="newsitem clear">
                    <a href="'.$href.'">
                    <img width="120" height="90" alt="'.$List->thubnail_alt.'" src="'.$thumbnail_thumb.'" />
                    </a>
                    <h3>
                    <a href="'.$href.'">
                    '.$List->title.'
                    </a>
                    </h3>
                    <p>'.$description_excerpt.'</p>
                    </div><!--newsitem-->
                    </div><!--contentScroll-->
                    </div><!--list_news-->';
                endfor;
            endif;
            ?>
            <div class="navi clear">
                <ul class="clear">
                    <?php
                    $range = 3;
                    if ($currentpage > 1)
                    {
                        $prevpage = $currentpage - 1;
                        if ($prevpage == 1):
                            echo "<li class='next_btn'> <a href='#load' onclick=Load_Releated_Cate_post('$cate_slug','$cate_slug_parent',$prevpage,event) rel='PREV'>Trước</a> </li>";
                        else:
                            echo "<li class='next_btn'> <a href='#load' onclick=Load_Releated_Cate_post('$cate_slug','$cate_slug_parent',$prevpage,event) rel='PREV'>Trước</a> </li>";
                        endif;
                    }
                    for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                        if (($x > 0) && ($x <= $totalpages)) {
                            if ($x == $currentpage) {
                                echo "<li class='currentPage'><b style='color:#F00'>$x</b></li> ";
                            }
                            else
                            {
                                if($x==1):
                                    echo " <li><a href='#load' onclick=Load_Releated_Cate_post('$cate_slug','$cate_slug_parent',$x,event) rel='PAGE-$x'>$x</a></li> ";
                                else:
                                    echo " <li><a href='#load' onclick=Load_Releated_Cate_post('$cate_slug','$cate_slug_parent',$x,event)  rel='PAGE-$x'>$x</a></li> ";
                                endif;

                            }
                        }
                    }
                    if ($currentpage != $totalpages) {
                        $nextpage = $currentpage + 1;
                        if(($currentpage+$range)<$totalpages){
                            echo "<li>...</li>";
                            echo " <li><a href='#load' onclick=Load_Releated_Cate_post('$cate_slug','$cate_slug_parent',$totalpages,event) rel='End-$totalpages' >$totalpages</a></li> ";
                        }
                        echo "<li class='next_btn'> <a href='#load' onclick=Load_Releated_Cate_post('$cate_slug','$cate_slug_parent',$nextpage,event) rel='NEXT'>Tiếp</a> </li>";
                    }

                    echo '</ul>
                    </div>';
                }
                public function LoadAjaxTheme(Request $request){
        //dd('ok');
                    $this->validate($request, [
                        'category' => 'required'
                    ],[
                        'category.required' => 'Thể loại dự án rỗng'
                    ]);
                    $cate_slug=addslashes($request->category);
                    $currentpage=(int)$request->page;
                    $count_datas=DB::table('category_theme')
                    ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                    ->join('theme','join_category_theme.id_theme','=','theme.id')
                    ->where('category_theme.categorySlug','=',$cate_slug)
                    ->where('theme.status','=',0)
                    ->count();
                    $numrows = $count_datas;
                    $rowsperpage =Helpers::get_option_minhnn('item-releted-theme');
                    $totalpages = ceil($numrows / $rowsperpage);
                    if ($currentpage > $totalpages) {
                        $currentpage = $totalpages;
                    }
                    if ($currentpage < 1) {
                        $currentpage = 1;
                    }
                    $offset = ($currentpage - 1) * $rowsperpage;
                    $Datas=DB::table('category_theme')
                    ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                    ->join('theme','join_category_theme.id_theme','=','theme.id')
                    ->where('category_theme.categorySlug','=',$cate_slug)
                    ->where('theme.status','=',0)
                    ->orderByRaw('theme.order_short DESC')
                    ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID')
                    ->limit($rowsperpage)
                    ->offset($offset)
                    ->get()
                    ->toArray();
        //dd($Datas);
                    $count_item=count($Datas);
                    $k=0; $thumbnail_thumb=""; $url_img=""; $ahref="";


                    if($count_item > 0):
                        for($i=0; $i<$count_item; $i++):
                            $k++;
                            $List = $Datas[$i];
                //dd($List->thubnail);
                            $url_img='images/product';
                            if(!empty($List->thubnail) && $List->thubnail !=""):
                                $thumbnail_thumb= Helpers::getThumbnail($url_img,$List->thubnail, 720, 540, "resize");
                                if(strpos($thumbnail_thumb, 'placehold') !== false):
                                    $thumbnail_thumb=$url_img.$thumbnail_thumb;
                                endif;
                            else:
                                $thumbnail_thumb="https://dummyimage.com/720x540/000/fff";
                            endif;
                            ?>
                            <div class="col-xs-6 col-sm-6 col-md-6 box-item" id="theme_cate_<?php echo $k;?>">
                                <div class="boxImg">
                                    <div class="boxImgContent">
                                        <h2 class="namePro"><a href="<?php echo route('tintuc.details',array($List->categorySlug,$List->slug)); ?>"><?php echo $List->title ?></a></h2>
                                        <div class="imgPro col-sm-9 col-md-9">
                                            <div class="imgProduct"><span class="Centerer"></span>
                                                <a href="<?php echo route('tintuc.details',array($List->categorySlug,$List->slug));?>">
                                                    <img width="240" height="180" alt="<?php echo $List->thubnail_alt;?>" src="<?php echo $thumbnail_thumb;?>" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3">
                                            <h3 class="product_desc"><a href="<?php echo route('tintuc.details',array($List->categorySlug,$List->slug)); ?>"><?php echo $List->title ?></a></h3>
                                        </div>
                                        <div class="product_name">
                                            <a rel="nofollow" href="<?php echo route('tintuc.details',array($List->categorySlug,$List->slug)); ?>">Mời xem đầy đủ thiết kế</a></a>
                                        </div>
                                    </div><!--boxImgContent-->
                                </div><!--boxImg-->
                            </div><!--box-item-->
                            <?php
                        endfor;
                    endif;
                    ?>
                    <div class="navi clear">
                        <ul class="clear">
                            <?php
                            $range = 3;
                            if ($currentpage > 1)
                            {
                                $prevpage = $currentpage - 1;
                                if ($prevpage == 1):
                                    echo "<li class='next_btn'> <a href='#load' onclick=Load_Releated_Cate_Theme('$cate_slug',$prevpage,event) rel='PREV'>Trước</a> </li>";
                                else:
                                    echo "<li class='next_btn'> <a href='#load' onclick=Load_Releated_Cate_Theme('$cate_slug',$prevpage,event) rel='PREV'>Trước</a> </li>";
                                endif;
                            }
                            for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                                if (($x > 0) && ($x <= $totalpages)) {
                                    if ($x == $currentpage) {
                                        echo "<li class='currentPage'><b style='color:#F00'>$x</b></li> ";
                                    }
                                    else
                                    {
                                        if($x==1):
                                            echo " <li><a href='#load' onclick=Load_Releated_Cate_Theme('$cate_slug',$x,event) rel='PAGE-$x'>$x</a></li> ";
                                        else:
                                            echo " <li><a href='#load' onclick=Load_Releated_Cate_Theme('$cate_slug',$x,event)  rel='PAGE-$x'>$x</a></li> ";
                                        endif;

                                    }
                                }
                            }
                            if ($currentpage != $totalpages) {
                                $nextpage = $currentpage + 1;
                                if(($currentpage+$range)<$totalpages){
                                    echo "<li>...</li>";
                                    echo " <li><a href='#load' onclick=Load_Releated_Cate_Theme('$cate_slug',$totalpages,event) rel='End-$totalpages' >$totalpages</a></li> ";
                                }
                                echo "<li class='next_btn'> <a href='#load' onclick=Load_Releated_Cate_Theme('$cate_slug',$nextpage,event) rel='NEXT'>Tiếp</a> </li>";
                            }

                            echo '</ul>
                            </div>';
                        } 
                        public function DetailsChildRedirect($slug1,$slug2,$slug3){
                            $parent_category=Category::where('categorySlug','=',$slug1)
                            ->select('category.*')
                            ->first();

                            if($parent_category):
                                $parent_category_id=$parent_category->categoryID;
                                $child_categories=Category::where('categorySlug','=',$slug2)
                                ->select('category.*')
                                ->first();
                                if($child_categories):

                                    $child_categories_parent=$child_categories->categoryParent;

                                    if($child_categories_parent==$parent_category_id):
                                        $data_customers_news=DB::table('category')
                                        ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                        ->join('post','join_category_post.id_post','=','post.id')
                                        ->where('post.slug','=',$slug3)
                                        ->where('post.status','=',0)
                                        ->where('category.categorySlug','=',$slug2)
                                        ->select('post.*','category.categoryName','category.categorySlug','category.categoryParent','category.categoryID','category.seo_title as seo_title_category')
                                        ->first();
                    //dd($data_customers_news);
                                        if($data_customers_news):
                                            $id_post=$data_customers_news->id;
                                            $data_news_releteds=DB::table('category')
                                            ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                            ->join('post','join_category_post.id_post','=','post.id')
                                            ->where('post.content','!=','')
                                            ->where('post.id','!=',$id_post)
                                            ->where('post.status','=',0)
                                            ->where('category.categorySlug','=',$slug1)
                                            ->select('post.*','category.categoryName','category.categorySlug','category.categoryParent','category.categoryID')
                                            ->offset(0)
                                            ->limit(config('app.item_releted_post'))
                                            ->orderBy('post.updated','DESC')
                                            ->get();
                                            return view('tintuc.details')
                                            ->with('id_category',$child_categories->categoryID)
                                            ->with('parent_category',$slug1)
                                            ->with('child_category',$slug2)
                                            ->with('data_customers',$data_customers_news)
                                            ->with('data_releated_news',$data_news_releteds);
                                        else:
                                            return view('errors.404');
                                        endif;
                                    else:
                                        return view('errors.404');
                                    endif;
                                else:
                                    $slug_expot=explode("-",$slug3);
                                    $id_post_redirect=end($slug_expot);
                                    $id_post_redirect=(int)$id_post_redirect;
                                    $data_customers_news_redirects=DB::table('category')
                                    ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                    ->join('post','join_category_post.id_post','=','post.id')
                                    ->where('post.id_old','=',$id_post_redirect)
                                    ->where('post.status','=',0)
                                    ->where('category.categorySlug','=',$slug2)
                                    ->select('post.*')
                                    ->first();
                                    if(isset($data_customers_news_redirects) && $data_customers_news_redirects):
                                        $newUrl=route('tintuc.details',array($slug2,$data_customers_news_redirects->slug));
                                        return redirect($newUrl, 301);
                                    else:
                                        return view('errors.404');
                                    endif;

                                endif;
                            else:
                                $slug_expot=explode("-",$slug3);
                                $id_post_redirect=end($slug_expot);
                                $id_post_redirect=(int)$id_post_redirect;
                                $data_customers_news_redirects=DB::table('category')
                                ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                ->join('post','join_category_post.id_post','=','post.id')
                                ->where('post.id_old','=',$id_post_redirect)
                                ->where('post.status','=',0)
                                ->where('category.categorySlug','=',$slug2)
                                ->select('post.*')
                                ->first();
                                if(isset($data_customers_news_redirects) && $data_customers_news_redirects):
                                    $newUrl=route('tintuc.details',array($slug2,$data_customers_news_redirects->slug));
                                    return redirect($newUrl, 301);
                                else:
                                    return view('errors.404');
                                endif;
                            endif;
                        }

                        public function DetailsChildRedirectAMP($slug1,$slug2,$slug3){
                            $parent_category=Category::where('categorySlug','=',$slug1)
                            ->select('category.*')
                            ->first();

                            if($parent_category):
                                $parent_category_id=$parent_category->categoryID;
                                $child_categories=Category::where('categorySlug','=',$slug2)
                                ->select('category.*')
                                ->first();
                                if($child_categories):

                                    $child_categories_parent=$child_categories->categoryParent;

                                    if($child_categories_parent==$parent_category_id):
                                        $data_customers_news=DB::table('category')
                                        ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                        ->join('post','join_category_post.id_post','=','post.id')
                                        ->where('post.slug','=',$slug3)
                                        ->where('post.status','=',0)
                                        ->where('category.categorySlug','=',$slug2)
                                        ->select('post.*','category.categoryName','category.categorySlug','category.categoryParent','category.categoryID','category.seo_title as seo_title_category')
                                        ->first();
                    //dd($data_customers_news);
                                        if($data_customers_news):
                                            $id_post=$data_customers_news->id;
                                            $data_news_releteds=DB::table('category')
                                            ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                            ->join('post','join_category_post.id_post','=','post.id')
                                            ->where('post.content','!=','')
                                            ->where('post.id','!=',$id_post)
                                            ->where('post.status','=',0)
                                            ->where('category.categorySlug','=',$slug1)
                                            ->select('post.*','category.categoryName','category.categorySlug','category.categoryParent','category.categoryID')
                                            ->offset(0)
                                            ->limit(config('app.item_releted_post'))
                                            ->orderBy('post.updated','DESC')
                                            ->get();
                                            return view('tintucAMP.details')
                                            ->with('id_category',$child_categories->categoryID)
                                            ->with('parent_category',$slug1)
                                            ->with('child_category',$slug2)
                                            ->with('data_customers',$data_customers_news)
                                            ->with('data_releated_news',$data_news_releteds);
                                        else:
                                            return view('errors.404');
                                        endif;
                                    else:
                                        return view('errors.404');
                                    endif;
                                else:
                                    $slug_expot=explode("-",$slug3);
                                    $id_post_redirect=end($slug_expot);
                                    $id_post_redirect=(int)$id_post_redirect;
                                    $data_customers_news_redirects=DB::table('category')
                                    ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                    ->join('post','join_category_post.id_post','=','post.id')
                                    ->where('post.id_old','=',$id_post_redirect)
                                    ->where('post.status','=',0)
                                    ->where('category.categorySlug','=',$slug2)
                                    ->select('post.*')
                                    ->first();
                                    if(isset($data_customers_news_redirects) && $data_customers_news_redirects):
                                        $newUrl=route('tintuc.details',array($slug2,$data_customers_news_redirects->slug));
                                        return redirect($newUrl, 301);
                                    else:
                                        return view('errors.404');
                                    endif;

                                endif;
                            else:
                                $slug_expot=explode("-",$slug3);
                                $id_post_redirect=end($slug_expot);
                                $id_post_redirect=(int)$id_post_redirect;
                                $data_customers_news_redirects=DB::table('category')
                                ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                ->join('post','join_category_post.id_post','=','post.id')
                                ->where('post.id_old','=',$id_post_redirect)
                                ->where('post.status','=',0)
                                ->where('category.categorySlug','=',$slug2)
                                ->select('post.*')
                                ->first();
                                if(isset($data_customers_news_redirects) && $data_customers_news_redirects):
                                    $newUrl=route('tintuc.details',array($slug2,$data_customers_news_redirects->slug));
                                    return redirect($newUrl, 301);
                                else:
                                    return view('errors.404');
                                endif;
                            endif;
                        }

                        public function DetailsRedirect($slug1,$slug2,$slug3,$slug4){
                            $data_customers=DB::table('category_theme')
                            ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                            ->join('theme','join_category_theme.id_theme','=','theme.id')
                            ->where('category_theme.categorySlug','=',$slug1)
                            ->where('theme.slug','=',$slug4)
                            ->where('theme.id_old','=',$slug3)
                            ->where('theme.id_cate_old','=',$slug2)
                            ->where('theme.status','=',0);
                            if(isset($data_customers) && $data_customers):
                                $newUrl=route('tintuc.details',array($slug1,$slug4));
                                return redirect($newUrl, 301);
                            else:

                                $data_customers_sub_themes=DB::table('category_theme')
                                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                ->join('theme','join_category_theme.id_theme','=','theme.id')
                                ->where('category_theme.categorySlug','=',$slug1)
                                ->where('theme.slug','=',$slug4)
                                ->where('theme.id_old','=',$slug3)
                                ->where('theme.id_cate_old','=',$slug2)
                                ->where('theme.id_cate_child_old','=',$slug2)
                                ->where('theme.status','=',0);
                            endif;
                        }
                        public function PageTintuc(){
                            $data_customers=array();
                            $categories=DB::table('category')
                            ->where('category.status_category','=',0)
                            ->select('category.*')
                            ->first();
                            $data_customers=DB::table('category')
                            ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                            ->join('post','join_category_post.id_post','=','post.id')
                            ->where('post.status','=',0)
                            ->select('post.*','category.categoryName','category.categorySlug','category.categoryID')
                            ->groupBy('post.id')
                            ->orderByRaw('post.updated DESC')
                            ->paginate(config('app.item_list_post'));
                            return view('tintuc.index')
                            ->with('categories',$categories)
                            ->with('data_customers',$data_customers);
                        }
                        public function NewItems(){
                            $list_category=DB::table('category_theme')
                            ->whereNotIn('categoryID', [69])
                            ->where('status_category','=',0)
                            ->orderBy('categoryName', 'ASC')
                            ->get();
                            $list_size=DB::table('variable_theme')
                            ->where('variable_theme.variable_theme_parent','=','2')
                            ->select('variable_theme.variable_theme_name','variable_theme.variable_theme_slug', 'variable_theme.variable_themeID')
                            ->get();
                            $data_customers=DB::table('category_theme')
                            ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                            ->join('theme','join_category_theme.id_theme','=','theme.id')
                            ->where('theme.status','=',0)
                            ->groupBy('theme.slug')
                            ->orderByRaw('theme.updated DESC')
                            ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                            ->paginate(config('app.item_list_category_product'));
                            return view('theme.newitem')
                            ->with('list_categories',$list_category)
                            ->with('list_size',$list_size)
                            ->with('data_customers',$data_customers);
                        }

                        public function HotDealItems(){
                            $date_now = date("Y-m-d H:i:s");

                            $list_category=DB::table('category_theme')
                            ->where('status_category','=',0)
                            ->whereNotIn('categoryID', [69])
                            ->orderBy('categoryName', 'ASC')
                            ->get();
                            $list_size=DB::table('variable_theme')
                            ->where('variable_theme.variable_theme_parent','=','2')
                            ->select('variable_theme.variable_theme_name','variable_theme.variable_theme_slug', 'variable_theme.variable_themeID')
                            ->get();

                            $data_customers=DB::table('category_theme')
                            ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                            ->join('theme','join_category_theme.id_theme','=','theme.id')
                            ->whereNotNull('theme.price_origin')
                            ->whereNotNull('theme.price_promotion')
                            ->where('theme.end_event', '>', $date_now)
                            ->where('theme.status','=',0)
                            ->groupBy('theme.slug')
                            ->orderByRaw('theme.order_short DESC')
                            ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                            ->paginate(config('app.item_list_category_product'));
                            return view('theme.hotdeal')
                            ->with('list_categories',$list_category)
                            ->with('categories',$list_category)
                            ->with('list_size',$list_size)
                            ->with('data_customers',$data_customers);
                        }

                        public function KhuyenMaiItems(Request $rq)
                        {
                            if(!isset($rq->ordersort)):
                            $data_customers=DB::table('category_theme')
                            ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                            ->join('theme','join_category_theme.id_theme','=','theme.id')
                            ->where('theme.status','=',0)
                            ->whereDate('end_event', '>=', date('Y-m-d H:s:i'))
                            ->orderBy('theme.order_short','DESC')
                            ->orderBy('theme.updated','DESC')
                            ->groupBy('theme.slug')
                            ->select('theme.id','theme.title','theme.slug','theme.description','theme.thubnail','theme.thubnail_alt','theme.price_origin',
                                'theme.price_promotion',
                                'theme.start_event',
                                'theme.end_event',
                                'theme.countdown',
                                'theme.theme_code',
                                'theme.updated',
                                'theme.id_brand',
                                'theme.gallery_images',
                                'theme.in_stock', 'theme.store_status', 'theme.pro_views', 'theme.item_new','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                            ->paginate(16);
                            return view('page.khuyen-mai')
                                ->with('data_customers',$data_customers);
                            else:
                                //khi fitler
                                $order = ($rq->ordersort=="priced") ? "DESC" : "ASC";
                                $data_customers=DB::table('category_theme')
                                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                ->join('theme','join_category_theme.id_theme','=','theme.id')
                                ->where('theme.status','=',0)
                                ->whereDate('end_event', '>=', date('Y-m-d H:s:i'))
                                ->orderBy('theme.price_promotion',$order)
                                ->groupBy('theme.slug')
                                ->select('theme.id','theme.title','theme.slug','theme.description','theme.thubnail','theme.thubnail_alt','theme.price_origin',
                                    'theme.price_promotion',
                                    'theme.start_event',
                                    'theme.end_event',
                                    'theme.countdown',
                                    'theme.theme_code',
                                    'theme.updated',
                                    'theme.id_brand',
                                    'theme.gallery_images',
                                    'theme.in_stock', 'theme.store_status', 'theme.pro_views', 'theme.item_new','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                                ->paginate(16);
                                return view('page.khuyen-mai')
                                ->with('data_customers',$data_customers);

                            endif;
                        }
                        public function KhuyenMaiItemsSort(Request $rq){
                            $order = ($rq->order=="pricea") ? "DESC" : "ASC";
                            $data_customers=DB::table('category_theme')
                            ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                            ->join('theme','join_category_theme.id_theme','=','theme.id')
                            ->where('theme.status','=',0)
                            ->whereDate('end_event', '>=', date('Y-m-d H:s:i'))
                            ->orderBy('theme.price_origin',$order)
                            ->groupBy('theme.slug')
                            ->select('theme.id','theme.title','theme.slug','theme.description','theme.thubnail','theme.thubnail_alt','theme.price_origin',
                                'theme.price_promotion',
                                'theme.start_event',
                                'theme.end_event',
                                'theme.countdown',
                                'theme.theme_code',
                                'theme.updated',
                                'theme.id_brand',
                                'theme.gallery_images',
                                'theme.in_stock', 'theme.store_status', 'theme.pro_views', 'theme.item_new','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                            ->paginate(1);
                            $view = View('page.khuyen-mai-ajax', ['data_customers' => $data_customers])->render();

                            return response()->json([
                                'view' => $view
                            ]);
                        }
                        public function autocomplete(Request $rq){
                            $output="";
                            if(isset($rq->query_string)){
                                $name_product = $rq->query_string;
                                $data_customers=DB::table('category_theme')
                                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                ->join('theme','join_category_theme.id_theme','=','theme.id')
                                ->where('theme.title', 'like', '%'.$name_product.'%')
                                ->where('theme.status','=',0)
                                ->groupBy('theme.slug')
                                ->orderByRaw('theme.order_short DESC')
                                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                                ->paginate(config('app.item_list_category_product'));
                                if($data_customers):
                //return json_encode($data_customers);
                                    $suggestions=array();
                                    $item_array=array();
                                    foreach ($data_customers as $row):
                                        $item_array=array(
                                            "type" => "product",
                                            "title" => $row->title,
                                            "url" => route('tintuc.details',array($row->categorySlug,$row->slug)));
                                        array_push($suggestions,$item_array);
                                    endforeach;
                                    return json_encode(array("suggestions"=>$suggestions));
                                else:
                                    return NULL;
                                endif;
                            } else{
                                return view('errors.404');
                            }
                        }
                        public function themeSearch(Request $rq){
                            //echo $rq->ordersort;die();
                            if(!isset($rq->ordersort)):
                                $order = ($rq->ordersort=="priced") ? "DESC" : "ASC";
                                $name_product = $rq->query_string;
                                $list_category=DB::table('category_theme')
                                ->whereNotIn('categoryID', [69])
                                ->where('status_category','=',0)
                                ->orderBy('categoryName', 'ASC')
                                ->get();
                                $data_customers=DB::table('category_theme')
                                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                ->join('theme','join_category_theme.id_theme','=','theme.id')
                                ->where('theme.title', 'like', '%'.$name_product.'%')
                                ->where('theme.status','=',0)
                                ->groupBy('theme.slug')
                                ->orderByRaw('theme.order_short DESC')
                                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                                ->paginate(16);
                                return view('theme.search')
                                ->with('list_categories',$list_category)
                                ->with('data_customers',$data_customers);
                            else: 
                                $name_product = $rq->query_string;
                                $list_category=DB::table('category_theme')
                                ->whereNotIn('categoryID', [69])
                                ->where('status_category','=',0)
                                ->orderBy('categoryName', 'ASC')
                                ->get();
                                $data_customers=DB::table('category_theme')
                                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                ->join('theme','join_category_theme.id_theme','=','theme.id')
                                ->where('theme.title', 'like', '%'.$name_product.'%')
                                ->where('theme.status','=',0)
                                // ->orderBy('theme.price_promotion',$order)
                                ->groupBy('theme.slug')
                                ->orderByRaw('theme.order_short DESC')
                                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                                ->paginate(16);

                                foreach ($data_customers as $data_customer) {
                                    //check event discount
                                    $date_now = date("Y-m-d H:i:s");
                                    $discount_for_brand = Discount_for_brand::where('brand_id', '=', $data_customer->id_brand)
                                        ->where('start_event', '<', $date_now)
                                        ->where('end_event', '>', $date_now)
                                        ->first();
                                    if($discount_for_brand){
                                        $final_price = $data_customer->price_origin - $data_customer->price_origin*$discount_for_brand->percent/100;
                                        $data_customer->final_price = intval($final_price);
                                    } else{
                                        if(!empty($data_customer->start_event) && !empty($data_customer->end_event)){
                                            $date_start_event = $data_customer->start_event;
                                            $date_end_event = $data_customer->end_event;
                                            if(strtotime($date_now) < strtotime($date_end_event) && strtotime($date_now) > strtotime($date_start_event)){
                                                if($data_customer->price_promotion <= $data_customer->price_origin && $data_customer->price_promotion != 0 && $data_customer->price_origin != 0):
                                                    $final_price = $data_customer->price_promotion;
                                                    $data_customer->final_price = intval($final_price);
                                                else:
                                                    $final_price = $data_customer->price_origin;
                                                    $data_customer->final_price = intval($final_price);
                                                endif;
                                            } else{
                                                if(!empty($data_customer->price_origin) &&  $data_customer->price_origin > 0){
                                                    $final_price = $data_customer->price_origin;
                                                    $data_customer->final_price = intval($final_price);
                                                }
                                            }
                                        } 
                                    }
                                }
                                if($rq->ordersort == 'priced'){
                                    $data_customers->setCollection(
                                        $data_customers->sortByDesc(function ($value) {
                                            return $value->final_price;
                                        })
                                    );
                                } else{
                                    $data_customers->setCollection(
                                        $data_customers->sortBy(function ($value) {
                                            return $value->final_price;
                                        })
                                    );
                                }
                                //$data_customers = Helpers::arrayPaginator($sort, $rq);
                                
                                return view('theme.search')
                                ->with('list_categories',$list_category)
                                ->with('data_customers',$data_customers);
                            endif;
                        }
                        public function brand_detail($slug){
                            $data_customers=array();
                            $list_brand = DB::table('brand')
                            ->where('brandStatus','=',0)
                            ->orderBy('brandName', 'ASC')
                            ->get();
                            $detail_brand=DB::table('brand')
                            ->where('brand.brandSlug','=',$slug)
                            ->select('brand.*')
                            ->first();
                            $data_customers=DB::table('category_theme')
                            ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                            ->join('theme','join_category_theme.id_theme','=','theme.id')
                            ->join('brand','brand.brandID','=','theme.id_brand')
                            ->where('brand.brandSlug', '=', $slug)
                            ->where('theme.status','=',0)
                            ->groupBy('theme.slug')
                            ->orderByRaw('theme.order_short DESC')
                            ->select('theme.*', 'brand.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                            ->paginate(config('app.item_list_category_product'));
                            return view('brand.detail')
                            ->with('data_customers', $data_customers)
                            ->with('detail_brand', $detail_brand)
                            ->with('list_brand',$list_brand);
                        }
                        public function brandIndex(){
                            $data_customers=array();
                            $list_brand = DB::table('brand')
                            ->where('brandStatus','=',0)
                            ->orderBy('brandName', 'ASC')
                            ->get();
                            $data_customers=DB::table('category_theme')
                            ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                            ->join('theme','join_category_theme.id_theme','=','theme.id')
                            ->join('brand','brand.brandID','=','theme.id_brand')
                            ->where('theme.status','=',0)
                            ->groupBy('theme.slug')
                            ->orderByRaw('theme.order_short DESC')
                            ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                            ->paginate(config('app.item_list_category_product'));
                            return view('brand.index')
                            ->with('data_customers', $data_customers)
                            ->with('list_brand',$list_brand);
                        }
                        public function category(Request $rq, $slug){
                            $data_customers=array();
                            $categories=DB::table('category')
                            ->where('category.categorySlug','=',$slug)
                            ->select('category.*')
                            ->first();
                            $category_themes=DB::table('category_theme')
                            ->where('category_theme.categorySlug','=',$slug)
                            ->select('category_theme.*')
                            ->first();
                            $list_category=DB::table('category_theme')
                            ->whereNotIn('categoryID', [69])
                            ->where('status_category','=',0)
                            ->orderBy('categoryName', 'ASC')
                            ->get();

                            $list_size=DB::table('variable_theme')
                            ->where('variable_theme.variable_theme_parent','=','2')
                            ->select('variable_theme.variable_theme_name','variable_theme.variable_theme_slug', 'variable_theme.variable_themeID')
                            ->get();
                            $pages=DB::table('page')
                            ->where('page.slug','=',$slug)
                            ->where('page.template', '=', 0)
                            ->select('page.*')
                            ->first();
                            if($categories){
            //xử lý cho the loai tin tức
                                $id_category=$categories->categoryID;
                                $data_customers=DB::table('category')
                                ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                ->join('post','join_category_post.id_post','=','post.id')
                                ->where('category.categorySlug','=',$slug)
                                ->where('post.status','=',0)
                                ->orderByRaw('post.updated DESC')
                                ->select('post.*','category.categoryName','category.categorySlug','category.categoryDescription','category.categoryID','category.categoryDescription_en')
                                ->paginate(config('app.item_list_post'));
                                return view('tintuc.category')
                                ->with('id_category',$id_category)
                                ->with('categories',$categories)
                                ->with('data_customers',$data_customers);
                            }else if($category_themes){
            // xu ly the loại mau
                                $id_category=$category_themes->categoryID;
                                if(isset($rq->ordersort)){
                                    $query = 'SELECT theme.id, theme.id_brand, theme.title, theme.slug, theme.thubnail, theme.price_origin, theme.price_promotion, theme.start_event, theme.end_event, theme.item_new, theme.thubnail_alt, theme.store_status, theme.pro_views, category_theme.categorySlug FROM theme JOIN join_category_theme on join_category_theme.id_theme = theme.id JOIN category_theme on category_theme.categoryID = join_category_theme.id_category_theme where theme.status = 0 AND category_theme.categorySlug = "'.$slug.'" GROUP BY theme.id order by theme.updated DESC';
                                    $sql_query = DB::select($query);
                                    foreach ($sql_query as $data_customer) {
                    //check event discount
                                        $date_now = date("Y-m-d H:i:s");
                                        $discount_for_brand = Discount_for_brand::where('brand_id', '=', $data_customer->id_brand)
                                        ->where('start_event', '<', $date_now)
                                        ->where('end_event', '>', $date_now)
                                        ->first();
                                        if($discount_for_brand){
                                            $final_price = $data_customer->price_origin - $data_customer->price_origin*$discount_for_brand->percent/100;
                                            $data_customer->final_price = intval($final_price);
                                        } else{
                                            if(!empty($data_customer->start_event) && !empty($data_customer->end_event)){
                                                $date_start_event = $data_customer->start_event;
                                                $date_end_event = $data_customer->end_event;
                                                if(strtotime($date_now) < strtotime($date_end_event) && strtotime($date_now) > strtotime($date_start_event)){
                                                    if($data_customer->price_promotion <= $data_customer->price_origin && $data_customer->price_promotion != 0 && $data_customer->price_origin != 0):
                                                        $final_price = $data_customer->price_promotion;
                                                        $data_customer->final_price = intval($final_price);
                                                    else:
                                                        $final_price = $data_customer->price_origin;
                                                        $data_customer->final_price = intval($final_price);
                                                    endif;
                                                } else{
                                                    if(!empty($data_customer->price_origin) &&  $data_customer->price_origin > 0){
                                                        $final_price = $data_customer->price_origin;
                                                        $data_customer->final_price = intval($final_price);
                                                    }
                                                }
                                            } 
                                        }
                                    }
                                    if($rq->ordersort == 'priced'){
                                        $sort = collect($sql_query)->sortBy('final_price')->reverse()->toArray();
                                    } else{
                                        $sort = collect($sql_query)->sortByDesc('final_price')->reverse()->toArray();
                                    }
                                    $data_customers = Helpers::arrayPaginator($sort, $rq);
                                } else{
                                    $data_customers=DB::table('category_theme')
                                    ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                    ->join('theme','join_category_theme.id_theme','=','theme.id')
                                    ->where('category_theme.categorySlug', '=', $slug)
                                    ->where('theme.status','=',0)
                                    ->orderBy('theme.updated', 'DESC')
                                    ->groupBy('theme.slug')
                                    ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                                    ->paginate(config('app.item_list_category_product'));
                                }
                                    // dd($data_customers); 

                                return view('theme.category')
                                ->with('id_category',$id_category)
                                ->with('categories',$category_themes)
                                ->with('list_categories',$list_category)
                                ->with('list_size',$list_size)
                                ->with('data_customers', $data_customers);
                            }else if($pages){
            // xu ly trang
                                if($pages):
                                    $id_page=$pages->id;
                                    $data_page_news=DB::table('page')
                                    ->where('page.status','=',0)
                                    ->where('page.content','!=','')
                                    ->where('page.id','!=',$id_page)
                                    ->select('page.*')
                                    ->offset(0)
                                    ->limit(20)
                                    ->orderBy('page.updated','DESC')
                                    ->get();
                                    return view('page.index')
                                    ->with('id_page',$id_page)
                                    ->with('data_customers',$pages)
                                    ->with('data_customers_news',$data_page_news);
                                else:
                                    return view('errors.404');
                                endif;
                            }else{
                                return view('errors.404');
                            }
                        }

                        public function categoryAMP($slug){
                            $data_customers=array();
                            $categories=DB::table('category')
                            ->where('category.categorySlug','=',$slug)
                            ->select('category.*')
                            ->first();
                            $category_themes=DB::table('category_theme')
                            ->where('category_theme.categorySlug','=',$slug)
                            ->select('category_theme.*')
                            ->first();
                            $list_category=DB::table('category_theme')
                            ->where('status_category','=',0)
                            ->get();

                            $list_size=DB::table('variable_theme')
                            ->where('variable_theme.variable_theme_parent','=','2')
                            ->select('variable_theme.variable_theme_name','variable_theme.variable_theme_slug', 'variable_theme.variable_themeID')
                            ->get();
                            $pages=DB::table('page')
                            ->where('page.slug','=',$slug)
                            ->select('page.*')
                            ->first();
                            if($categories){
            //xử lý cho the loai tin tức
                                $id_category=$categories->categoryID;
                                $data_customers=DB::table('category')
                                ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                ->join('post','join_category_post.id_post','=','post.id')
                                ->where('category.categorySlug','=',$slug)
                                ->where('post.status','=',0)
                                ->orderByRaw('post.updated DESC')
                                ->select('post.*','category.categoryName','category.categorySlug','category.categoryDescription','category.categoryID','category.categoryDescription_en')
                                ->paginate(config('app.item_list_post'));
                                return view('tintucAMP.category')
                                ->with('id_category',$id_category)
                                ->with('categories',$categories)
                                ->with('data_customers',$data_customers);
                            }else if($category_themes){
            // xu ly the loại mau
                                $id_category=$category_themes->categoryID;
                                $data_customers=DB::table('category_theme')
                                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                ->join('theme','join_category_theme.id_theme','=','theme.id')
                                ->where('category_theme.categorySlug','=',$slug)
                                ->where('theme.status','=',0)
                                ->groupBy('theme.slug')
                                ->orderByRaw('theme.order_short DESC')
                                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                                ->paginate(config('app.item_list_category_product'));
            //config('app.item_list_product')
                                return view('themeAMP.category')
                                ->with('id_category',$id_category)
                                ->with('categories',$category_themes)
                                ->with('list_categories',$list_category)
                                ->with('list_size',$list_size)
                                ->with('data_customers',$data_customers);
                            }else if($pages){
            // xu ly trang
                                if($pages):
                                    $id_page=$pages->id;
                                    $data_page_news=DB::table('page')
                                    ->where('page.status','=',0)
                                    ->where('page.content','!=','')
                                    ->where('page.id','!=',$id_page)
                                    ->select('page.*')
                                    ->offset(0)
                                    ->limit(20)
                                    ->orderBy('page.updated','DESC')
                                    ->get();
                                    return view('pageAMP.index')
                                    ->with('id_page',$id_page)
                                    ->with('data_customers',$pages)
                                    ->with('data_customers_news',$data_page_news);
                                else:
                                    return view('errors.404');
                                endif;
                            }else{
                                return view('errors.404');
                            }
                        }

                        public function singleDetails($slug1,$slug2){

                            $data_customers=array();
                            $data_customers_news=DB::table('category')
                            ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                            ->join('post','join_category_post.id_post','=','post.id')
                            ->where('post.slug','=',$slug2)
                            ->where('category.categorySlug','=',$slug1)
                            ->select('post.*','category.categoryName','category.categorySlug','category.categoryParent','category.categoryID','category.seo_title as seo_title_category','category.seo_keyword as seo_keyword_category','category.seo_description as seo_description_category')
                            ->first();

                            if(isset($data_customers_news) && $data_customers_news):
            //check details tin tức news
                                $id_post=$data_customers_news->id;
                                $data_news_releteds=DB::table('category')
                                ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                ->join('post','join_category_post.id_post','=','post.id')
                                ->where('post.content','!=','')
                                ->where('post.id','!=',$id_post)
                                ->where('post.status','=',0)
                                ->where('category.categorySlug','=',$slug1)
                                ->select('post.*','category.categoryName','category.categorySlug','category.categoryParent','category.categoryID')
                                ->offset(0)
                                ->limit(config('app.item_releted_post'))
                                ->orderBy('post.updated','DESC')
                                ->get();
                                return view('tintuc.details')
                                ->with('id_category',$data_customers_news->categoryID)
                                ->with('child_category',$data_customers_news->categorySlug)
                                ->with('categories',$data_customers_news)
                                ->with('data_customers',$data_customers_news)
                                ->with('data_releated_news',$data_news_releteds);

                            else:
                                $data_customers_themes=DB::table('category_theme')
                                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                ->join('theme','join_category_theme.id_theme','=','theme.id')
                                ->where('theme.slug','=',$slug2)
                                ->where('category_theme.categorySlug','=',$slug1)
                                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryParent','category_theme.categoryID','category_theme.seo_title as seo_title_category','category_theme.category_stand_frame')
                                ->first();
                                if(isset($data_customers_themes) && $data_customers_themes):
                // check details theme mẫu
                                    $id_theme=$data_customers_themes->id;
                                    $data_theme_releteds=DB::table('category_theme')
                                    ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                    ->join('theme','join_category_theme.id_theme','=','theme.id')
                                    ->where('theme.content','!=','')
                                    ->where('theme.id','!=',$id_theme)
                                    ->where('theme.status','=',0)
                                    ->where('category_theme.categorySlug','=',$slug1)
                                    ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryParent','category_theme.categoryID','category_theme.category_stand_frame')
                                    ->offset(0)
                                    ->limit(config('app.item_releted_theme'))
                                    ->orderBy('theme.order_short','DESC')
                                    ->get();
                                    return view('theme.single')
                                    ->with('id_category',$data_customers_themes->categoryID)
                                    ->with('categories',$data_customers_themes)
                                    ->with('data_customers',$data_customers_themes)
                                    ->with('data_releated_news',$data_theme_releteds);
                                else:
                                    $data_parent_categories=DB::table('category')
                                    ->where('category.categorySlug','=',$slug2)
                                    ->where('category.status_category','=',0)
                                    ->select('category.*')
                                    ->first();
                                    if(isset($data_parent_categories) && $data_parent_categories):
                    //category
                                        $id_parent_category=$data_parent_categories->categoryParent;
                                        $data_child_categories=DB::table('category')
                                        ->where('category.categoryID','=',$id_parent_category)
                                        ->where('category.status_category','=',0)
                                        ->select('category.*')
                                        ->first();
                                        if(isset($data_child_categories) && $data_child_categories):
                                            $slug_parent_category=$data_child_categories->categorySlug;
                                            if($slug_parent_category==$slug1):
                                                $id_category=$data_parent_categories->categoryID;
                                                $slug_category=$data_parent_categories->categorySlug;
                                                $data_customers=DB::table('category')
                                                ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                                ->join('post','join_category_post.id_post','=','post.id')
                                                ->where('category.categoryID','=',$id_category)
                                                ->where('post.status','=',0)
                                                ->orderByRaw('post.updated DESC')
                                                ->select('post.*','category.categoryName','category.categorySlug','category.categoryDescription','category.categoryID')
                                                ->paginate(config('app.item_list_post'));
                                                return view('tintuc.category')
                                                ->with('id_category',$id_category)
                                                ->with('parent_category',$data_child_categories->categorySlug)
                                                ->with('categories',$data_parent_categories)
                                                ->with('data_customers',$data_customers);
                                            else:
                                                return view('errors.404');
                                            endif;
                                        else:
                                            return view('errors.404');
                                        endif;
                                    else:
                    //redrict theme kieu phong-khach-dep/noi-that-nha-dep-voi-nhung-mau-phong-khach-co-dien-long-lay-sang-trong-1-0-14907.html
                                        $slug_expot=explode("-",$slug2);
                                        $id_post_redirect=end($slug_expot);
                                        $id_post_redirect=(int)$id_post_redirect;
                                        $data_customers_sub_themes=DB::table('category_theme')
                                        ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                        ->join('theme','join_category_theme.id_theme','=','theme.id')
                                        ->where('category_theme.categorySlug','=',$slug1)
                                        ->where('theme.id','=',$id_post_redirect)
                                        ->where('theme.status','=',0)
                                        ->select('theme.*')
                                        ->first();
                                        if(isset($data_customers_sub_themes) && $data_customers_sub_themes):
                                            $newUrl=route('tintuc.details',array($slug1,$data_customers_sub_themes->slug));
                                            return redirect($newUrl, 301);
                                        else:
                        //redrict post examp gioi-thieu/cong-ty-co-phan-thiet-ke-kien-truc-xay-dung-ngoi-nha-xinh-1-7032.html
                                            $slug_expot=explode("-",$slug2);
                                            $id_post_redirect=end($slug_expot);
                                            $id_post_redirect=(int)$id_post_redirect;
                                            $data_customers_news_redirects=DB::table('category')
                                            ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                            ->join('post','join_category_post.id_post','=','post.id')
                                            ->where('post.id','=',$id_post_redirect)
                                            ->where('post.status','=',0)
                                            ->where('category.categorySlug','=',$slug1)
                                            ->select('post.*')
                                            ->first();
                                            if(isset($data_customers_news_redirects) && $data_customers_news_redirects):
                                                $newUrl=route('tintuc.details',array($slug1,$data_customers_news_redirects->slug));
                                                return redirect($newUrl, 301);
                                            else:
                                                return view('errors.404');
                                            endif;
                                        endif;
                                    endif;
                                endif;
                            endif;

                        }

                        public function singleDetailsAMP($slug1,$slug2){
                            $data_customers=array();
                            $data_customers_news=DB::table('category')
                            ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                            ->join('post','join_category_post.id_post','=','post.id')
                            ->where('post.slug','=',$slug2)
                            ->where('category.categorySlug','=',$slug1)
                            ->select('post.*','category.categoryName','category.categorySlug','category.categoryParent','category.categoryID','category.seo_title as seo_title_category','category.seo_keyword as seo_keyword_category','category.seo_description as seo_description_category')
                            ->first();
                            if(isset($data_customers_news) && $data_customers_news):
            //check details tin tức news
                                $id_post=$data_customers_news->id;
                                $data_news_releteds=DB::table('category')
                                ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                ->join('post','join_category_post.id_post','=','post.id')
                                ->where('post.content','!=','')
                                ->where('post.id','!=',$id_post)
                                ->where('post.status','=',0)
                                ->where('category.categorySlug','=',$slug1)
                                ->select('post.*','category.categoryName','category.categorySlug','category.categoryParent','category.categoryID')
                                ->offset(0)
                                ->limit(config('app.item_releted_post'))
                                ->orderBy('post.updated','DESC')
                                ->get();
                                return view('tintucAMP.details')
                                ->with('id_category',$data_customers_news->categoryID)
                                ->with('child_category',$data_customers_news->categorySlug)
                                ->with('data_customers',$data_customers_news)
                                ->with('data_releated_news',$data_news_releteds);
                            else:
                                $data_customers_themes=DB::table('category_theme')
                                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                ->join('theme','join_category_theme.id_theme','=','theme.id')
                                ->where('theme.slug','=',$slug2)
                                ->where('category_theme.categorySlug','=',$slug1)
                                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryParent','category_theme.categoryID','category_theme.seo_title as seo_title_category','category_theme.category_stand_frame')
                                ->first();
                                if(isset($data_customers_themes) && $data_customers_themes):
                // check details theme mẫu
                                    $id_theme=$data_customers_themes->id;
                                    $data_theme_releteds=DB::table('category_theme')
                                    ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                                    ->join('theme','join_category_theme.id_theme','=','theme.id')
                                    ->where('theme.content','!=','')
                                    ->where('theme.id','!=',$id_theme)
                                    ->where('theme.status','=',0)
                                    ->where('category_theme.categorySlug','=',$slug1)
                                    ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryParent','category_theme.categoryID','category_theme.category_stand_frame')
                                    ->offset(0)
                                    ->limit(config('app.item_releted_theme'))
                                    ->orderBy('theme.order_short','DESC')
                                    ->get();
                                    return view('themeAMP.single')
                                    ->with('id_category',$data_customers_themes->categoryID)
                                    ->with('data_customers',$data_customers_themes)
                                    ->with('data_releated_news',$data_theme_releteds);
                                else:
                                    $data_parent_categories=DB::table('category')
                                    ->where('category.categorySlug','=',$slug2)
                                    ->where('category.status_category','=',0)
                                    ->select('category.*')
                                    ->first();
                                    if(isset($data_parent_categories) && $data_parent_categories):
                    //category
                                        $id_parent_category=$data_parent_categories->categoryParent;
                                        $data_child_categories=DB::table('category')
                                        ->where('category.categoryID','=',$id_parent_category)
                                        ->where('category.status_category','=',0)
                                        ->select('category.*')
                                        ->first();
                                        if(isset($data_child_categories) && $data_child_categories):
                                            $slug_parent_category=$data_child_categories->categorySlug;
                                            if($slug_parent_category==$slug1):
                                                $id_category=$data_parent_categories->categoryID;
                                                $data_customers=DB::table('category')
                                                ->join('join_category_post','category.categoryID','=','join_category_post.id_category')
                                                ->join('post','join_category_post.id_post','=','post.id')
                                                ->where('category.categoryID','=',$id_category)
                                                ->where('post.status','=',0)
                                                ->orderByRaw('post.updated DESC')
                                                ->select('post.*','category.categoryName','category.categorySlug','category.categoryDescription','category.categoryID')
                                                ->paginate(config('app.item_list_post'));
                                                return view('tintucAMP.category')
                                                ->with('id_category',$id_category)
                                                ->with('parent_category',$data_child_categories->categorySlug)
                                                ->with('categories',$data_parent_categories)
                                                ->with('data_customers',$data_customers);
                                            else:
                                                return view('errors.404');
                                            endif;
                                        else:
                                            return view('errors.404');
                                        endif;
                                    else:
                                       return view('errors.404');
                                   endif;
                               endif;
                           endif;

                       }
                       public function Cart(){
                        return view('theme.cart');
                    }
                    public function PostCart(Request $request){
                        if(isset($request->update) && $request->update=='on'):
                            /**********************Begin*********************/
                            if(Cart::content()->count()>0):
                                $rowId="";
                            $id_cart=0;
                            foreach(Cart::content() as $cart_items):
                                $id_cart=$cart_items->id;
                                $rowId = Cart::search(array('id' => $id_cart));
                                $quantity=(int)$request->qty[$id_cart];
                                if($quantity>0):
                                    Cart::update($rowId[0], ['qty' => $quantity]);
                                endif;
                            endforeach;
                            return redirect()->route('cart');
                        endif;
                        /**********************End*********************/
                    elseif(isset($request->checkout) && $request->checkout=='true'):
                        /******************************Check Out********************************/
                        $this->validate($request, [
                            'full_name' => 'required',
                            'phone' => 'required',
                            'address' => 'required',
                            'slt_province' => 'required',
                            'slt_district' => 'required',
                            'slt_ward' => 'required'
                        ],[
                            'full_name.required' => 'Mời Bạn nhập vào họ tên của bạn',
                            'phone.required' => 'Mời bạn nhập số điện thoại',
                            'address.required' => 'Mời bạn nhập địa chỉ',
                            'slt_province.required' => 'Mời bạn chọn Tỉnh/Thành phố',
                            'slt_district.required' => 'Mời bạn chọn Quận/Huyện',
                            'slt_ward.required' => 'Mời bạn chọn Phường/Xã'
                        ]);
                        if(Cart::content()->count()>0):
                            $discount_code = $request->discount_code;
                        $checkcode = Discount_code::where('discount_code.code', '=', $discount_code)
                        ->where('discount_code.status', '=', 0)
                        ->first();
                        $code_true = "";
                        $discount = 0;
                        if($checkcode){
                            $id_combo = Helpers::get_option_minhnn('id-cate-combo');
                            $array_combo = explode(', ',$id_combo);
                            if(Cart::content()->count()>0){
                                foreach (Cart::content() as $cart_item) {
                                    $id_product = $cart_item->id;
                                    $cate = Join_Category_Theme::join('category_theme', 'category_theme.categoryID', '=', 'join_category_theme.id_category_theme')
                                    ->where('join_category_theme.id_theme', '=', $id_product)
                                    ->select('category_theme.categoryName', 'category_theme.categoryID')
                                    ->groupBy()
                                    ->get();
                                    if($cate){
                                        $html_cate = "";
                                        foreach ($cate as $item_cate) {
                                            if(in_array($item_cate->categoryID, $array_combo)){
                                                $result = -1;
                                                return redirect()->back()->withInput($request->input())->with('code_discount_error', 'Mã giảm giá không áp dụng cho gói combo.');
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                            $date_now = date("Y-m-d H:i:s");
                            if(strtotime($date_now) < strtotime($checkcode->expired)){
                                if($checkcode->apply_for_order > 0){
                                    if(Cart::total() < $checkcode->apply_for_order){
                                        $cart_total=Cart::total();
                                        $discount = 0;
                                        $code_true = "";
                                        $id_discount_code = 0;
                                    } else{
                                        if($checkcode->percent != 0){
                                            $cart_total = Cart::total()-(Cart::total()*$checkcode->percent/100);
                                            $discount = Cart::total()*$checkcode->percent/100;
                                        } else{
                                            $cart_total = Cart::total()-$checkcode->discount_money;
                                            $discount = $checkcode->discount_money;
                                            if($cart_total < 0){
                                                $cart_total = 0;
                                                $discount = Cart::total();
                                            }
                                        }
                                        $id_discount_code = $checkcode->id;
                                        $code_true = $discount_code;
                                    }
                                } else{
                                    if($checkcode->percent != 0){
                                        $cart_total = Cart::total()-(Cart::total()*$checkcode->percent/100);
                                        $discount = Cart::total()*$checkcode->percent/100;
                                    } else{
                                        $cart_total = Cart::total()-$checkcode->discount_money;
                                        $discount = $checkcode->discount_money;
                                        if($cart_total < 0){
                                            $cart_total = 0;
                                            $discount = Cart::total();
                                        }
                                    }
                                    $id_discount_code = $checkcode->id;
                                    $code_true = $discount_code;
                                }
                            } else{
                                $cart_total=Cart::total();
                                $discount = 0;
                                $code_true = "";
                                $id_discount_code = 0;
                            }
                        } else{
                            $cart_total=Cart::total();
                            $id_discount_code = 0;
                            $code_true = "";
                        }

                //$data=$request->all();
                        $email_admin=Helpers::get_option_minhnn('emailadmin');
                        $cc_email=Helpers::get_option_minhnn('toemail');
                        $name_admin_email=Helpers::get_option_minhnn('name-admin');
                        $subject_default=Helpers::get_option_minhnn('title-email-card');
                        if(Auth::check()){
                            $user_id = Auth::user()->id;
                        } else{
                            $user_id = 0;
                        }
                        $cart_content=Cart::content();
                        $data_content_cart=serialize($cart_content);

                        $type_shipping = '';
                        $shipping_method=$request->shipping_method;
                        $cart_province = $request->slt_province;
                        $date_now = date("Y-m-d H:i:s");
                        if($cart_province == 'Thành phố Hồ Chí Minh'){
                            if(strtotime($date_now) < strtotime(Helpers::get_option_minhnn('free-ship-end')) && strtotime($date_now) > strtotime(Helpers::get_option_minhnn('free-ship-start')) && Cart::total() > Helpers::get_option_minhnn('free-for-bill')):
                                $shipping_fee = 0;
                        else:
                            $shipping_fee = 20000;
                        endif;
                    }else{
                        if(strtotime($date_now) < strtotime(Helpers::get_option_minhnn('free-ship-end')) && strtotime($date_now) > strtotime(Helpers::get_option_minhnn('free-ship-start')) && Cart::total() > Helpers::get_option_minhnn('free-for-bill')):
                            $shipping_fee = 0;
                    else:
                        $shipping_fee = 30000;
                    endif;
                }
                if(Cart::total() > Helpers::get_option_minhnn('free-for-total-bill')):
                    $shipping_fee = 0;
            endif;

            $cart_district = $request->slt_district;
            $cart_ward = $request->slt_ward;
            $datetime_now=date('Y-m-d H:i:s');

            $discount_code = $code_true;
            $cart_code=Helpers::auto_code();

            $datetime_now=date('Y-m-d H:i:s');
            $email_customer = $request->email;
            $database = array(
                'cart_hoten' => $request->full_name,
                'cart_phone' => $request->phone,
                'cart_email' => $email_customer,
                'id_discount_code' => $id_discount_code,
                'cart_district' => $cart_district,
                'cart_province' => $cart_province,
                'cart_ward' => $cart_ward,
                'cart_address' => $request->address,
                'shipping_fee' => $shipping_fee,
                'cart_note' => $request->message,
                'cart_pay_method'=>$shipping_method,
                'type_shipping' => $type_shipping,
                'cart_total' => $cart_total,
                'cart_content' => $data_content_cart,
                'user_id' => $user_id,
                'cart_code' => $cart_code,
                'cart_status' => 1,
                'created' => $datetime_now,
                'updated' => $datetime_now
            );

            $respons =Addtocard::create($database);
                //insert in Addtocard_Detail
            foreach($cart_content as $key => $value){
                $data_addcard_detal = [
                    'product_id' => $value->id,
                    'card_id'   => $respons->id,
                    'admin_id'      => Theme::find($value->id)->admin->id,
                    'name'          => $value->name,
                    'quanlity'      => $value->qty,
                    'subtotal'      => $value->subtotal
                ];
                Addtocard_Detail::create($data_addcard_detal);
            }
            $id_insert= $respons->id;
            if($id_insert>0):
                $data = array(
                    'name'=> $database['cart_hoten'],
                    'phone'=> $database['cart_phone'],
                    'email'=> $database['cart_email'],
                    'address'=> $database['cart_address'],
                    'cart_district' => $database['cart_district'],
                    'cart_province' => $database['cart_province'],
                    'cart_ward' => $database['cart_ward'],
                    'note'=>$database['cart_note'],
                    'total'=>$cart_total,
                    'cart_pay_method'=>$database['cart_pay_method'],
                    'type_shipping' => $type_shipping,
                    'shipping_fee' => $shipping_fee,
                    'cart_code' => $cart_code,
                    'user_id' => $user_id,
                    'code_discount' => $code_true,
                    'discount' => $discount,
                    'email_admin' => $email_admin,
                    'cc_email' =>$cc_email,
                    'name_email_admin' => $name_admin_email,
                    'subject_default'=>$subject_default
                );
                $note_message_card=Helpers::get_option_minhnn('note-email-addtocard');
                $data_customer=[];
                if($database['cart_email'] != ''){
                    $data_customer = array(
                        'name'=>$database['cart_hoten'],
                        'phone'=>$database['cart_phone'],
                        'email'=>$database['cart_email'],
                        'address'=>$database['cart_address'],
                        'cart_district' => $database['cart_district'],
                        'cart_province' => $database['cart_province'],
                        'cart_ward' => $database['cart_ward'],
                        'note'=>$database['cart_note'],
                        'code_discount' => $code_true,
                        'discount' => $discount,
                        'shipping_fee' => $shipping_fee,
                        'total'=>$cart_total,
                        'cart_pay_method'=>$database['cart_pay_method'],
                        'cart_code' => $cart_code,
                        'subject_default'=>'Đơn hàng từ Siêu thị Miền Nam'
                    );
                }
                    //send mail in queue
                    // -- get user_id admin
                $info_cart_detail =DB::table('addtocard_detail')
                ->join('admins', 'admins.id', '=', 'addtocard_detail.admin_id')
                ->where('card_id', $id_insert)
                ->select('*')
                ->get();
                $data_mail = [
                    'data_admin' => $data,
                    'data_customer' => $data_customer,
                    'cart_content' => Cart::content(),
                    'info_cart_detail' => $info_cart_detail
                ];

                dispatch(new SendMailNewOrder($data_mail));
                Cart::destroy();
                return redirect()->route('completeOrder');
            else:
                return redirect()->route('cart')
                -> with('success_msg','Lỗi insert dữ liệu gửi mail');
            endif;
        else:
            return redirect()->route('cart')
            -> with('success_msg','Giỏ hàng Rỗng mời bạn đặt hàng');
        endif;
        /******************************End Check Out********************************/
    else:
        return view('errors.404');
    endif;
}
public function Shop(){
    $list_category=DB::table('category_theme')
    ->whereNotIn('categoryID', [69])
    ->where('status_category','=',0)
    ->orderBy('categoryName', 'ASC')
    ->get();
    $data_customers=DB::table('category_theme')
    ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
    ->join('theme','join_category_theme.id_theme','=','theme.id')
    ->where('theme.status','=',0)
    ->groupBy('theme.slug')
    ->orderByRaw('theme.order_short DESC')
    ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en','category_theme.categoryParent')
    ->paginate(24);
        //config('app.item_list_product')
    return view('theme.index')
    ->with('data_customers',$data_customers)
    ->with('list_categories', $list_category);
}
public function NotFound(){
    return view('errors.404');
}
public function pageDefault($slug){
    $data_customers=array();
    $data_customers=DB::table('page')
    ->where('page.status','=',0)
    ->where('page.slug','=',$slug)
    ->select('page.*')
    ->first();

    if($data_customers):
        $id_page=$data_customers->id;
        $data_customers_news=DB::table('page')
        ->where('page.status','=',0)
        ->where('page.content','!=','')
        ->where('page.id','!=',$id_page)
        ->select('page.*')
        ->offset(0)
        ->limit(20)
        ->orderBy('page.updated','DESC')
        ->get();
        return view('page.index')
        ->with('id_page',$id_page)
        ->with('data_customers',$data_customers)
        ->with('data_customers_news',$data_customers_news);
    else:
        return view('errors.404');
    endif;
}
public function MapList(){
    return view('page.map-list');
}
public function PageLienHe(){
    return view('page.lien_he');
}
public function postContactus(Request $request){
    $this->validate($request, [
        'your_name' => 'required',
        'your_email' => 'required|email',
        'your_mobile' => 'required',
        'your_message' => 'required',
            //'g-recaptcha-response' => 'required|captcha',
    ],[
        'your_name.required' => 'Mời Bạn nhập vào tên của bạn',
        'your_email.required' => 'Mời bạn nhập Email',
        'your_mobile.required' => 'Mời bạn nhập Số điện thoại',
        'your_message.required' => 'Mời bạn nhập nội dung',
    ]);
        //$data=$request->all();
    $email_admin=Helpers::get_option_minhnn('emailadmin');
    $cc_email=Helpers::get_option_minhnn('toemail');
    $name_admin_email=Helpers::get_option_minhnn('name-admin');
    $subject_default=Helpers::get_option_minhnn('title-email');
    $type_form = isset($request->contact_page) ? $request->contact_page : "";
    $data = array(
        'your_name'=>$request->your_name,
        'your_email'=>$request->your_email,
        'your_mobile'=>$request->your_mobile,
        'your_message'=>$request->your_message,
        'email_admin' => $email_admin,
        'cc_email' =>$cc_email,
        'name_email_admin' => $name_admin_email,
        'subject_default'=>$subject_default
    );
    $note_message_contact=Helpers::get_option_minhnn('note-email');
        //dd($data);
    Mail::send('email.contact',
        $data,
        function($message) use ($data) {
            $message->from($data['your_email'],$data['your_name']);
            $message->to($data['email_admin'])
            ->cc($data['cc_email'],$data['name_email_admin'])
            ->subject($data['subject_default']."- Người dùng:".$data['your_name']);
        }
    );
    if($type_form=='contact_page'):
        return redirect()->back()
        -> with('success_msg',$note_message_contact);
    else:
        return redirect()->route('lien-he')
        -> with('success_msg',$note_message_contact);
    endif;
    
        //return response()->json(array('msg' => 'Cảm ơn bạn đã liên hệ đến chúng tôi. Chúng tôi sẽ liên lạc lại với bạn sau!'));

}

}
