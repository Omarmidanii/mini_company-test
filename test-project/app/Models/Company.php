<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "email",
        "address",
    ];
    public function department(){ 
        return $this->hasMany(Department::class);
    } 
}
