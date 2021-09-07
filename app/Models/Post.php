<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable =['user_id','author_id','category_id','post_title','post_description','post_content','post_image','post_slug','post_status','created_at','updated_at','published_at'];
    protected $table ='posts';
    public $timestamps = false;
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
