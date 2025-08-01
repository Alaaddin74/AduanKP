<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get the tickets associated with the category.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
