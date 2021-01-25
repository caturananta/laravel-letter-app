<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'priority';

    public function letter()
    {
        return $this->hasMany('App\Letter');
    }
}
