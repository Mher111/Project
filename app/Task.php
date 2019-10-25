<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable=[
        'name',
        'user_id',
        'days',
        'hours',
        'project_id',
        'company_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function comments(){
        return $this->morphToMany(Comments::class,'commentable');
    }

}
