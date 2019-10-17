<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable=[
        'name',
        'description',
        'user_id',
        'days',
        'company_id'
    ];
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function user(){
        return $this->belongsToMany(User::class);
    }
}
