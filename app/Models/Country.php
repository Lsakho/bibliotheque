<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $primaryKey = 'iso';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['name', 'description'];
    protected $hidden = ['created_at', 'updated_at'];
    public function people()
    {
        return $this->hasMany(People::class);
    }
    public function authors()
    {
        return $this->hasMany(Author::class);
    }
}
