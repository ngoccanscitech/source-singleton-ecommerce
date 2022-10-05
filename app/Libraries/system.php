<?php
use App\Model\Setting;
use App\Model\ShopCurrency;
use App\Libraries\Helpers;

if (!function_exists('setting_option')) {
    function setting_option($variable = '')
    {
        if (Cache::has('theme_option')) 
            $data = Cache::get('theme_option');
        else{
            $data = Setting::get();
            Cache::forever('theme_option', $data);
        }
        if($data){
            $option = $data->where('name', $variable)->first();
            // dd($option);
            if($option){
                $content = $option->content;
                if($option->type == 'editor' || $option->type == 'text')
                    $content = htmlspecialchars_decode($content);
                return $content;
            }
        }
    }
}

if (!function_exists('get_template')) {
    function get_template()
    {
        return Helpers::getTemplatePath();
    }
}

if (!function_exists('render_price')) {
    function render_price(float $money, $currency = null, $rate = null, $space_between_symbol = false, $useSymbol = true)
    {
        return ShopCurrency::render($money, $currency, $rate, $space_between_symbol, $useSymbol);
    }
}
if (!function_exists('render_option_name')) {
    function render_option_name($att)
    {
        if($att){
            $att_array = explode('__', $att);
            if(isset($att_array[0]))
                return $att_array[0];
        }
    }
}
if (!function_exists('render_option_price')) {
    function render_option_price($att)
    {
        if($att){
            $att_array = explode('__', $att);
            if(isset($att_array[2]))
                return render_price($att_array[2]);
            elseif(isset($att_array[1]))
                return render_price($att_array[1]);
        }
    }
}
if (!function_exists('auto_code')) {
    function auto_code($code = 'Order', $cart_id = 0){
        $number_start = 5000;
        // $strtime_conver=strtotime(date('d-m-Y H:i:s'));
        // $strtime=substr($strtime_conver,-4);
        // $rand=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $string_rand = $code . '-' . ($number_start + $cart_id);
        return $string_rand;
    }
}
?>