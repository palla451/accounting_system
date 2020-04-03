<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the inputs that are assigned this tag.
     */
    public function inputs()
    {
        return $this->morphedByMany(Input::class, 'paymentable');
    }

    /**
     * Get all of the outputs that are assigned this tag.
     */
    public function outputs()
    {
        return $this->morphedByMany(Output::class, 'paymentable');
    }
}
