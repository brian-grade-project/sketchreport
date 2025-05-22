<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'report_date',
        'user_id'
    ];

    protected $casts = [
        'report_date' => 'date'
    ];

    public function getReportDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function multimedias(): HasMany
    {
        return $this->hasMany(Multimedia::class, 'report_id');
    }

    public function media_files()
    {
        return $this->hasMany(MediaFile::class);
    }
}