<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'list_id',
        'price',
        'purchased',
        'created_at',
        'deleted_at'
    ];

    protected $visible = [
        'id',
        'name',
        'price',
        'purchased',
        'list_id',
        'created_at',
        'deleted_at'
    ];

    public function list() {
        return $this->belongsTo(ListModel::class);
    }
}
