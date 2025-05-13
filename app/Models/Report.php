<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'report_date',
        'user_id'
    ];

    public function multimedias(): HasMany
    {
        return $this->hasMany(Multimedia::class, 'report_id');
    }

    public function media_files()
    {
        return $this->hasMany(MediaFile::class);
    }
}
