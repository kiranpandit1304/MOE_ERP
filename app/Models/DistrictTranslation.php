<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistrictTranslation extends Model
{
  protected $fillable = ['name', 'lang', 'district_id'];

  public function district(){
    return $this->belongsTo(District::class);
  }
}
