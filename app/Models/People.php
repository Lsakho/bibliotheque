<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;
    protected $fillable = ['firstname', 'lastname','birthdate','address','zip','city','phone','email'];
    protected $hidden = ['created_at', 'updated_at'];
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
    public function countries()
    {
        return $this->belongsto(Country::class);
    }
}
