<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Multimedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'multimedias';

    protected $fillable = [
        'user_id',
        'report_id',
        'path',
        'thumbnail',
        'type',
        'text',
        'media_date',
        'metadata'
    ];

    protected $casts = [
        'media_date' => 'date',
        'metadata' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    public function getMetadataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setMetadataAttribute($value)
    {
        $this->attributes['metadata'] = json_encode($value);
    }
}
