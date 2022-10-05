<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ThemeInfo extends Model
{
    public $timestamps = true;
    protected $table = 'theme_info';
    protected $guarded =[];

    public function replacePlace($name)
    {
        $name = str_replace('Huyện', '', $name);
        $name = str_replace('Quận', '', $name);
        $name = str_replace('Thành phố', '', $name);
        return $name;
    }

    // get province
    public function getPlace($value='')
    {
        $district = \App\Model\District::find($this->district_id);
        $province = \App\Model\Province::find($this->province_id);

        return ($district ? $this->replacePlace($district->name) .', ': ''). $this->replacePlace($province->name) ?? '';
    }

    public function admin(){
        return $this->belongsTo('App\Model\Admin', 'admin_id', 'id');
    }

    public function rate() {
        return $this->hasMany('App\Model\Rating_Product', 'pro_id', 'id');
    }
}
