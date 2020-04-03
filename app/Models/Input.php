<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    protected $fillable = [
        'user_id',  'description', 'import' ,'date'
    ];

    /**
     * Get all of payments method.
     */
    public function payments()
    {
        return $this->morphToMany(Payment::class, 'paymentable');
    }

    public function getImportAsFloatAttribute()
    {
        return (float) str_replace(',', '.', $this->import);
    }
}
