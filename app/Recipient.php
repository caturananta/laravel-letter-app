<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recipient';
    public $timestamps = false;

    public function letter()
    {
        return $this->belongsTo('App\Letter');
    }
}
