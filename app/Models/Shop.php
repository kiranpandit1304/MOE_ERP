<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
  protected $guarded = array();
  protected $with = ['user'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
  
  public function seller_package(){
    return $this->belongsTo(SellerPackage::class);
  }
  public function followers(){
    return $this->hasMany(FollowSeller::class);
  }
  public function city(){
    return $this->belongsTo(City::class);
  }
  public function district(){
    return $this->belongsTo(District::class);
  }
  public function products(){
    return $this->hasMany(Product::class,'user_id','user_id');
  }
}
