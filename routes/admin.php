<?php 

// Route xử lý cho admin
Route::namespace('Admin')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@login')->name('admin.login');
    Route::get('/logout', 'LoginController@logout')->name('admin.logout');
    Route::get('/404', array(
     'as' => 'adminError',
     'uses' => 'AdminController@error'));
    Route::group(['middleware' => ['auth:admin']], function () {
      Route::get('/', 'HomeController@index')->name('admin.dashboard');
         //các route của quản trị viên sẽ được viết trong group này, còn chức năng của user sẽ viết ngoài route
      Route::group(['middleware' => 'checkAdminPermission'], function () {
            //Setting
        Route::get('/theme-option', 'AdminController@getThemeOption')->name('admin.themeOption');
        Route::post('/theme-option', 'AdminController@postThemeOption')->name('admin.postThemeOption');
        Route::get('/menu', 'AdminController@getMenu')->name('admin.menu');

            //Page
        Route::get('/list-pages', 'PageController@listPage')->name('admin.pages');
        Route::get('/page/create', 'PageController@createPage')->name('admin.createPage');
        Route::get('/edit-page/{id}', 'PageController@pageDetail')->name('admin.pageDetail');
        Route::post('/page/post', 'PageController@postPageDetail')->name('admin.postPageDetail');

            //Post
        Route::get('/list-post', 'PostController@listPost')->name('admin.posts');
        Route::get('/search-post', 'PostController@searchPost')->name('admin.searchPost');
        Route::get('/post/create', 'PostController@createPost')->name('admin.createPost');
        Route::get('/edit-post/{id}', 'PostController@postDetail')->name('admin.postDetail');
        Route::post('/post/post', 'PostController@postPostDetail')->name('admin.postPostDetail');

            //Category Post
        Route::get('/list-category-post', 'CategoryController@listCategoryPost')->name('admin.listCategoryPost');
        Route::get('/category-post/create', 'CategoryController@createCategoryPost')->name('admin.createCategoryPost');
        Route::get('/category-post/{id}', 'CategoryController@categoryPostDetail')->name('admin.categoryPostDetail');
        Route::post('/category-post/post', 'CategoryController@postCategoryPostDetail')->name('admin.postCategoryPostDetail');
        
        

        //project
        Route::get('/list-project', 'ProjectController@list')->name('admin.project');
        Route::get('/project/create', 'ProjectController@create')->name('admin.project.create');
        Route::get('/edit-project/{id}', 'ProjectController@detail')->name('admin.project.detail');
        Route::post('/project/post', 'ProjectController@post')->name('admin.project.post');

        //nha dau t investor
        Route::group(['prefix' => 'investor'], function () {
            Route::get('list', 'InvestorController@index')->name('admin.investor.index');
            Route::get('create', 'InvestorController@create')->name('admin.investor.create');
            Route::get('{id}', 'InvestorController@edit')->name('admin.investor.edit');
            Route::post('post', 'InvestorController@post')->name('admin.investor.post');
        });

            //Category project
        Route::get('/list-category-project', 'CategoryProjectController@list')->name('admin.project.category');
        Route::get('/category-project/create', 'CategoryProjectController@create')->name('admin.project.category.create');
        Route::get('/category-project/{id}', 'CategoryProjectController@detail')->name('admin.project.category.edit');
        Route::post('/category-project/post', 'CategoryProjectController@post')->name('admin.project.category.post');
        Route::get('/category-project/delete/{id}', 'CategoryProjectController@delete_id')->name('admin.project.category.delete_id');
        Route::post('/category-project/delete', 'CategoryProjectController@delete')->name('admin.project.category.delete');

        //Slider Home
        Route::group(['prefix' => 'slider'], function () {
            Route::get('/create', 'SliderController@createSlider')->name('admin.createSlider');
            Route::get('/{id}', 'SliderController@sliderDetail')->name('admin.sliderDetail');
            Route::post('/post', 'SliderController@postSliderDetail')->name('admin.postSliderDetail');
            Route::post('/insert', 'SliderController@insertSlider')->name('admin.slider.insert');
            Route::post('/edit', 'SliderController@editSlider')->name('admin.slider.insert');
            Route::post('/delete', 'SliderController@deleteSlider')->name('admin.slider.delete');
        });
        Route::get('/list-slider', 'SliderController@listSlider')->name('admin.slider');

        // custom_field
        Route::group(['prefix' => 'custom_field'], function () {
            Route::get('/', 'CustomFieldController@index')->name('admin.custom_field.index');
            Route::get('/create', 'CustomFieldController@create')->name('admin.custom_field.create');
            
            Route::post('/create', 'CustomFieldController@postEdit')->name('admin.custom_field.create');
            Route::get('/edit/{id}', 'CustomFieldController@edit')->name('admin.custom_field.edit');
            Route::post('/edit/{id}', 'CustomFieldController@postEdit')->name('admin.custom_field.post');
            Route::post('/delete', 'CustomFieldController@deleteList')->name('admin.custom_field.delete');
        });

        

        //sponders
        Route::get('/list-sponser', 'SponserController@listSponser')->name('admin.sponser');
        Route::get('/sponser/create', 'SponserController@createSponser')->name('admin.createSponser');
        Route::get('/sponser/{id}', 'SponserController@SponserDetail')->name('admin.sponserDetail');
        Route::post('/sponser/post', 'SponserController@postSponserDetail')->name('admin.postSponserDetail');

            //Discount Code
        Route::get('/list-discount-code', 'DiscountCodeController@listDiscountCode')->name('admin.discountCode');
        Route::get('/discount-code/create', 'DiscountCodeController@createDiscountCode')->name('admin.createDiscountCode');
        Route::get('/discount-code/{id}', 'DiscountCodeController@discountCodeDetail')->name('admin.discountCodeDetail');
        Route::post('/discount-code/post', 'DiscountCodeController@postDiscountCodeDetail')->name('admin.postDiscountCodeDetail');

            //Video Page
        Route::get('/list-video', 'VideoController@listVideo')->name('admin.listVideo');
        Route::get('/video/create', 'VideoController@createVideo')->name('admin.createVideo');
        Route::get('/video/{id}', 'VideoController@videoDetail')->name('admin.videoDetail');
        Route::post('/video/post', 'VideoController@postVideoDetail')->name('admin.postVideoDetail');

        //xử lý users admin
        Route::get('/list-user-admin', 'AdminUserController@listUserAdmin')->name('admin.listUserAdmin');
        Route::get('/user-admin/{id}', 'AdminUserController@userAdminDetail')->name('admin.userAdminDetail');
        Route::post('/user-admin/{id}', 'AdminUserController@postUserAdminDetail')->name('admin.postUserAdminDetail');
        Route::get('/add-user-admin', 'AdminUserController@addUserAdmin')->name('admin.addUserAdmin');
        Route::post('/add-user-admin', 'AdminUserController@postAddUserAdmin')->name('admin.postAddUserAdmin');
        Route::get('/delete-user-admin/{id}', 'AdminUserController@deleteUserAdmin')->name('admin.delUserAdmin');

        //xử lý users
        Route::get('/list-users', 'AdminController@listUsers')->name('admin.listUsers');
        Route::get('/user/{id}', 'AdminController@userDetail')->name('admin.userDetail');
        Route::post('/users/{id}', 'AdminController@postUserDetail')->name('admin.postUserDetail');
        Route::get('/add-users', 'AdminController@addUsers')->name('admin.addUsers');
        Route::post('/add-users', 'AdminController@postAddUsers')->name('admin.postAddUsers');
        Route::get('/delete-user/{id}', 'AdminController@deleteUser')->name('admin.delUser');

        //Brand
        Route::get('/list-brand', 'BrandController@index')->name('admin.brand');
        Route::get('/brand/create', 'BrandController@create')->name('admin.brand.create');
        Route::get('/brand/{id}', 'BrandController@edit')->name('admin.brand.edit');
        Route::post('/brand/post', 'BrandController@post')->name('admin.brand.post');

        Route::group(['prefix' => 'element'], function () {
            Route::get('/', 'ElementController@index')->name('admin_element.index');
            Route::get('create', 'ElementController@create')->name('admin_element.create');
            Route::get('{id}', 'ElementController@edit')->name('admin_element.edit');
            Route::post('post', 'ElementController@post')->name('admin_element.post');
        });

        //Orders
        Route::get('/list-order', 'OrderController@listOrder')->name('admin.listOrder');
        Route::get('/search-order', 'OrderController@searchOrder')->name('admin.searchOrder');
        Route::get('/order/{id}', 'OrderController@orderDetail')->name('admin.orderDetail');
        Route::post('/order/post', 'OrderController@postOrderDetail')->name('admin.postOrderDetail');

        //export excel
        Route::get('/export_customer', array('as' => 'admin.exportCustomer', 'uses' => 'AdminController@exportCustomer'));
        Route::get('/export_orders', array('as' => 'admin.exportOrders', 'uses' => 'AdminController@exportOrder'));
        Route::get('/export_products', array('as' => 'admin.exportProducts', 'uses' => 'AdminController@exportProduct'));
        //import data
        Route::get('/product_import', array('as' => 'admin_product.import', 'uses' => 'ProductController@import'));
        Route::post('/product_import', array('as' => 'admin_product.import_process', 'uses' => 'ProductController@importProcess'));

        //Combo
        Route::get('/list-combo', 'ComboController@listCombo')->name('admin.listCombo');
        Route::get('/search-combo', 'ComboController@searchCombo')->name('admin.searchCombo');
        Route::get('/combo/create', 'ComboController@createCombo')->name('admin.createCombo');
        Route::get('/combo/{id}', 'ComboController@comboDetail')->name('admin.comboDetail');
        Route::post('/combo/post', 'ComboController@postComboDetail')->name('admin.postComboDetail');

        //Category Product
        Route::get('/category-product', 'ProductCategoryController@index')->name('admin.listCategoryProduct');
        Route::get('/category-product/create', 'ProductCategoryController@create')->name('admin.product.category.create');
        Route::get('/category-product/{id}', 'ProductCategoryController@edit')->name('admin.categoryProductDetail');
        Route::post('/category-product/post', 'ProductCategoryController@post')->name('admin.postCategoryProductDetail');
        Route::get('/category-checklist/{id}', 'ProductCategoryController@getCategoryCheckList');

        //Variable Product
        Route::get('/list-variable-product', 'VariableProductController@listVariableProduct')->name('admin.listVariableProduct');
        Route::get('/search-variable-product', 'VariableProductController@searchVariableProduct')->name('admin.searchVariableProduct');
        Route::get('/variable-product/create', 'VariableProductController@createVariableProduct')->name('admin.createVariableProduct');
        Route::get('/variable-product/{id}', 'VariableProductController@variableProductDetail')->name('admin.variableProductDetail');
        Route::post('/variable-product/post', 'VariableProductController@postVariableProductDetail')->name('admin.postVariableProductDetail');

        //process variation
        Route::get('/add-new-variation', 'ProductVariationController@add')->name('admin.product.variation.add');
        Route::get('/product-variation-edit/{id?}', 'ProductVariationController@edit')->name('admin.product.variation.edit');
        Route::post('/post-new-variation', 'ProductVariationController@post')->name('admin.product.variation.post');
        Route::post('/delete-product-variation', 'ProductVariationController@delete')->name('admin.product.variation.delete');

        //xử lý đánh giá sản phẩm
        Route::get('/list-rating', 'AdminController@listRating')->name('admin.listRating');
        Route::get('/rating/{id}', 'AdminController@ratingDetail')->name('admin.ratingDetail');
        Route::post('rating', 'AdminController@postRating')->name('admin.postRating');
    }); //end checkAdminPermission

      //change password
      Route::get('/change-password', 'AdminController@changePassword')->name('admin.changePassword');
      Route::post('/change-password', 'AdminController@postChangePassword')->name('admin.postChangePassword');
      Route::get('/check-password', 'AjaxController@checkPassword')->name('admin.checkPassword');

      //ajax delete
      Route::post('/delete-id', 'AjaxController@ajax_delete')->name('admin.ajax_delete');

      //ajax process
      Route::post('/ajax/process_theme_fast', 'AjaxController@processThemeFast')->name('admin.ajax.processThemeFast');
      Route::post('/ajax/process_new_item', 'AjaxController@update_new_item_status')->name('admin.ajax.process_new_item');
      Route::post('/ajax/process_flash_sale', 'AjaxController@update_process_flash_sale')->name('admin.ajax.process_flash_sale');
      Route::post('/ajax/process_sale_top_week', 'AjaxController@update_process_sale_top_week')->name('admin.ajax.process_sale_top_week');
      Route::post('/ajax/process_propose', 'AjaxController@update_process_propose')->name('admin.ajax.process_propose');
      Route::post('/ajax/process_store_status', 'AjaxController@updateStoreStatus')->name('admin.ajax.process_store_status');
      Route::post('/ajax/load_variable', 'AjaxController@loadVariable')->name('admin.ajax.load_variable');

       //Product
      Route::get('/list-products', 'ProductController@listProduct')->name('admin.listProduct');
      Route::get('/search-products', 'ProductController@searchProduct')->name('admin.searchProduct');
      Route::get('/product/create', 'ProductController@createProduct')->name('admin.createProduct');
      Route::get('/product/{id}', 'ProductController@productDetail')->name('admin.productDetail');
      Route::post('/product/post', 'ProductController@postProductDetail')->name('admin.postProductDetail');

      Route::get('media-manager/fm-button', 'FileManagerController@fmButton')
        ->name('fm.fm-button');

        //email template
        Route::group(['prefix' => 'email-template'], function () {
            Route::get('/', 'EmailTemplateController@index')->name('admin.email_template');
            Route::get('edit/{id}', 'EmailTemplateController@edit')->name('admin.email_template.edit');
            Route::get('add', 'EmailTemplateController@create')->name('admin.email_template.create');
            Route::post('post', 'EmailTemplateController@post')->name('admin.email_template.post');
        });
  });
});