<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ShopCustomField;
use App\Model\ShopCustomFieldDetail;

class CustomFieldController extends Controller
{
    public $data;
    public $module;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->data['title_head'] = 'Field tùy chỉnh của sản phẩm';
        $this->module = 'admin.custom_field';
    }

    public function index()
    {
        $this->data['custom_fields'] = ShopCustomField::orderByDesc('id')->paginate(20);

        return view($this->module .'.index', $this->data);
    }
    public function create($value='')
    {
        // code...
    }
    public function edit($value='')
    {
        // code...
    }
    public function postEdit($value='')
    {
        // code...
    }
    public function deleteList($value='')
    {
        // code...
    }
}
