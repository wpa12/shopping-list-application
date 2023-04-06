<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ListModel extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'lists';

    protected $fillable = [
        'name',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $visilbe = [
        'id',
        'name',
        'user_id',
        'created_at',
        'deleted_at',
    ];


    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
