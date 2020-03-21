<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    protected $fillable = [
        'user_id', 'description', 'date'
    ];

    /**
     * Get the output of a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of payments method.
     */
    public function payments()
    {
        return $this->morphToMany(Payment::class, 'paymentable');
    }
}