<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
  protected $guarded = array();

  protected $with = ['user', 'user.shop'];

  public function user(){
  	return $this->belongsTo(User::class);
  }

  public function payments(){
  	return $this->hasMany(Payment::class);
  }

  public function seller_package(){
    return $this->belongsTo(SellerPackage::class);
  }
  public function city(){
    return $this->hasOne(City::class);
  }
  public function district(){
    return $this->hasOne(District::class);
  }
}
