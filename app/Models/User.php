<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class User extends Model
{
    use HasFactory;

    protected $table = 'users'; // テーブル名

    protected $primaryKey = 'id'; // 主キー
    public $incrementing = false; // UUID は自動インクリメントしない
    protected $keyType = 'string'; // 主キーを文字列として扱う

    public $timestamps = true; // created_at, updated_at を自動管理

    protected $fillable = [
        'cognito_sub',
        'email',
        'username',
        'first_name',
        'last_name',
        'phone_number',
        'status',
    ];

    protected $casts = [
        'id' => 'string', // UUIDを文字列として扱う
        'cognito_sub' => 'string', // UUIDを文字列として扱う
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid(); // UUID を自動生成
            }
        });
    }
}
