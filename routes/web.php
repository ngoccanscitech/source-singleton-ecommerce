<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::localized(function () {
    Route::get('/', '\App\Http\Controllers\PageController@index')->name('index');

    Route::group(['prefix' => 'customer'], function() {
        Route::get('/register', 'CustomerController@registerCustomer')->name('registerCustomer');
        Route::post('/register', 'CustomerController@createCustomer')->name('postRegisterCustomer');
        Route::get('/register-success', 'CustomerController@createCustomerSuccess')->name('user.register.success');
        Route::get('/login', 'CustomerController@showLoginForm')->name('user.login');
        Route::post('/login', 'CustomerController@postLogin')->name('loginCustomerAction');
        Route::post('/logout', 'Customer\CustomerLoginController@logout')->name('CustomerLogout');

        Route::post('/nap-tai-khoan', 'PaymentController@checkout')->name('customer.vnpay');
    });

    //user forget password
    Route::get('forget-password', 'CustomerController@forgetPassword')->name('forgetPassword');
    Route::post('forget-password', 'CustomerController@actionForgetPassword')->name('actionForgetPassword');
    Route::get('forget-password-step-2', 'CustomerController@forgetPassword_step2')->name('forgetPassword_step2');
    Route::post('forget-password-step-2', 'CustomerController@actionForgetPassword_step2')->name('actionForgetPassword_step2');
    Route::get('forget-password-step-3', 'CustomerController@forgetPassword_step3')->name('forgetPassword_step3');
    Route::post('forget-password-step-3', 'CustomerController@actionForgetPassword_step3')->name('actionForgetPassword_step3');
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'customer'], function() {
            Route::get('/', 'CustomerController@index')->name('customer.dashboard');
            Route::get('/thong-tin', array('as' => 'customer.profile', 'uses' => 'CustomerController@profile'));
            Route::post('/thong-tin', array('as' => 'customer.updateprofile', 'uses' => 'CustomerController@updateProfile'));

            Route::get('/quan-ly-tin-dang', array('as' => 'customer.post', 'uses' => 'CustomerController@myPost'));
            Route::get('/refused', array('as' => 'customer.refused', 'uses' => 'CustomerController@refused'));

            Route::get('/payment-point', array('as' => 'customer.payment.point', 'uses' => 'PaymentController@paymentPoint'));

            
            Route::get('/my-orders', array('as' => 'customer.my-orders', 'uses' => 'CustomerController@myOrder'));
            Route::get('/my-orders-detail/{id_cart}', array('as' => 'customer.myordersdetail', 'uses' => 'CustomerController@myOrderDetail'));
            Route::get('/my-reviews', array('as' => 'customer.reviews', 'uses' => 'CustomerController@myReviews'));

            Route::get('/change-pass', array('as' => 'customer.changePassword', 'uses' => 'CustomerController@changePassword'));
            Route::post('/change-pass', array('as' => 'customer.post.ChangePassword', 'uses' => 'CustomerController@postChangePassword'));
            Route::post('/post-reviews', array('as' => 'customer.post_reviews', 'uses' => 'CustomerController@postReviews'));
            Route::get('/logout', array('as' => 'customer.logout', 'uses' => 'CustomerController@logoutCustomer'));
        });
    });

    Route::group(['prefix' => 'cart'], function() {
        Route::get('/', 'CartController@cart')->name('cart');
        Route::get('/remove', 'CartController@removeCarts')->name('carts.remove');
        Route::post('/update', 'CartController@updateCarts')->name('carts.update');
        Route::get('/checkout', 'CartController@checkout')->name('cart.checkout');
        Route::get('/checkout-confirm', 'CartController@checkoutConfirm')->name('cart.checkout.get.confirm');
        Route::post('/checkout-confirm', 'CartController@checkoutConfirm')->name('cart.checkout.confirm');

        Route::get('/quick-buy-checkout-confirm', 'CartController@quickBuyConfirm')->name('quick_buy.get.confirm');
        Route::post('/quick-buy-checkout-confirm', 'CartController@quickBuyConfirm')->name('quick_buy.checkout.confirm');

        Route::get('/check-payment/{cart_id}', 'CartController@checkPayment')->name('cart.check_payment');

        Route::post('ajax/add', 'CartController@addCart')->name('cart.ajax.add');
        Route::post('ajax/remove', 'CartController@removeCart')->name('cart.ajax.remove');

        Route::post('ajax/get-shipping-cost', 'CartController@shipping')->name('cart.ajax.shipping');

        Route::get('checkout/success', 'CartController@success')->name('cart.checkout.success');
        Route::get('view/{id}', 'CartController@view')->name('cart.view');

        Route::post('shipping-usps', 'USPSController@index')->name('cart.usps');
        Route::post('shipping-cost', 'USPSController@shippingCost')->name('cart.usps.cost');
        
    });

    Route::group(['prefix' => 'payment'], function() {
        Route::get('stripe', 'PayPalTestController@test');
        Route::post('stripe', 'PayPalTestController@testPost');

        Route::get('{cart_id}', 'PayPalTestController@paymentOrder')->name('payment.order');
    });

    Route::get('stamps-success', 'CartController@getStamps')->name('cart.stamps');
    Route::get('stamps-from', 'CartController@stampsForm')->name('cart.stamps.form');

    // Route::get('payment', 'PayPalTestController@index');
    Route::post('checkout-process', 'CartController@checkoutProcess')->name('cart_checkout.process');
    Route::post('checkout-charge', 'PayPalTestController@charge')->name('cart.checkout.charge');
    Route::get('payment-success/{id?}', 'PayPalTestController@paymentStrip_success');
    Route::get('paymentsuccess', 'PayPalTestController@payment_success');
    Route::get('paymenterror', 'PayPalTestController@payment_error');
    //request payment
    Route::get('request-payment-success/{id}', 'CartController@requestPaymentSuccess')->name('request_payment_success');
    Route::post('send-request-payment-success', 'CartController@post_requestPaymentSuccess')->name('request_payment_success.post');

    // Route::get('/contact-submit', array('as' => 'contact.submit', 'uses' => 'CustomerController@contactSend'));

    Route::post('/dang-ky-nhan-tin', array('as' => 'subscription', 'uses' => 'CustomerController@subscription'));


    Route::get('/wishlist', array('as' => 'customer.wishlist', 'uses' => 'CustomerController@wishlist'));
    Route::post('add-to-wishlist', 'ProductController@wishlist')->name('product.wishlist');
    
    Route::get('news.html', 'NewsController@index')->name('news');
    Route::get('blog-left-sidebar.html', 'NewsController@index')->name('news');
    
    //category
    Route::get('sale', 'ProductController@allProducts')->name('shop.sale');
    Route::get('shop', 'ProductController@allProducts')->name('shop');
    Route::get('{slug}.html', 'ProductController@categoryDetail')->name('shop.detail');
    Route::post('quick-view', 'ProductController@quickView')->name('shop.quickView');
    Route::get('buy-now/{id}', 'ProductController@buyNow')->name('shop.buyNow');
    Route::post('buy-now', 'ProductController@getBuyNow')->name('shop.buyNow.post');


    //news
    Route::get('news/{slug}-{id}.html', '\App\Http\Controllers\NewsController@newsDetail')
        ->where(['slug' => '[a-zA-Z0-9$-_.+!]+', 'id' => '[0-9]+'])
        ->name('news.single');

    Route::get('news/{slug}.html', '\App\Http\Controllers\NewsController@categoryDetail')
        ->where(['slug' => '[a-zA-Z0-9$-_.+!]+'])
        ->name('news.category');


    //contact
    Route::post('/get-contact-form/{type}', array('as' => 'contact.get', 'uses' => 'ContactController@getContact'));
    Route::get('contact.html', 'ContactController@index')->name('contact');
    Route::post('contact.html', 'ContactController@submit')->name('contact.submit');
    Route::post('ajax/contact', 'ContactController@sendContact')->name('contact.send');


    //search
    Route::post('/input/search-text/{type}', 'AjaxController@inputSearchText');

    Route::get('/search', '\App\Http\Controllers\SearchController@index')->name('search');
    Route::post('search-select', 'AjaxController@searchSelect');

    //page
    Route::get('{slug}', 'PageController@page')->name('page');
    
    //project
    Route::get('du-an/{slug}-{id}.html', '\App\Http\Controllers\ProjectController@detail')
        ->where(['slug' => '[a-zA-Z0-9$-_.+!]+', 'id' => '[0-9]+'])
        ->name('project.detail');

    Route::get('du-an/{slug}.html', '\App\Http\Controllers\ProjectController@category')
        ->where(['slug' => '[a-zA-Z0-9$-_.+!]+'])
        ->name('project.category');
    //end project

    Route::group(['prefix' => 'ajax'], function() {
        Route::post('change-attr', 'ProductController@changeAttr')->name('ajax.attr.change');

    });
    
});
