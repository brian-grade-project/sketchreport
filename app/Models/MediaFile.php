<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size'
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
