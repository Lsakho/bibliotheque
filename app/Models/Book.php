<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $primaryKey = 'isbn';
    public $incrementing = false;
    // protected $keyType = 'string';
    protected $fillable = ['title', 'year', 'summary','etat','status'];
    protected $hidden = ['created_at', 'updated_at'];
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
    public function people()
    {
        return $this->belongsToMany(People::class);
    }
    public function image()
    {
        return $this->morphMany(Image::class, 'imageable'); 
    }

}
