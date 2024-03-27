<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class District extends Model
{
    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $district_translation = $this->hasMany(DistrictTranslation::class)->where('lang', $lang)->first();
        return $district_translation != null ? $district_translation->$field : $this->$field;
    }

    public function district_translations(){
       return $this->hasMany(DistrictTranslation::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function shops(){
        return $this->hasMany(Shop::class);
    }
}
