<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model {
  protected $fillable = ['name','price','stock','exp_date','category_id','image_path'];
  public function category(){ return $this->belongsTo(Category::class); }
}
