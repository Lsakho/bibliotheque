<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'city', 'birthdate'];
    protected $hidden = ['created_at', 'updated_at'];
    
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
    public function countries()
    {
        return $this->belongsTo(Country::class);
    }
    public function image()
    {
        return $this->morphMany(Image::class, 'imageable'); 
    }

}
