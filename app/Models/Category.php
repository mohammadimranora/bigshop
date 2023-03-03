<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id'
    ];


    /**
     * category's parent
     * @return use Illuminate\Database\Eloquent\Collection
     */
    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    /**
     * category's childs
     * @return use Illuminate\Database\Eloquent\Collection
     */
    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }
}
