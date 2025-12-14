<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Note extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['id', 'title', 'body', 'archived', 'owner_id'];

    protected $casts = [
        'archived' => 'boolean',
    ];

    protected $appends = ['createdAt', 'ownerId'];

    protected $hidden = ['created_at', 'updated_at', 'owner_id'];


    public function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'];
    }


    public function getOwnerIdAttribute()
    {
        return $this->attributes['owner_id'];
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = 'note-' . Str::random(16);
            }
        });
    }
}