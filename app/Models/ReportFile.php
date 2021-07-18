<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_url',
        'report_id'
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }
}
