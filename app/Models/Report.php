<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'content',
        'user_id',
        'group_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function report_files(){
        return $this->hasMany(ReportFile::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
