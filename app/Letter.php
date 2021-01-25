<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'letter';

    /**
     * Relation table
     */
    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function priority()
    {
        return $this->belongsTo('App\Priority');
    }

    public function recipient()
    {
        return $this->belongsTo('App\Recipient');
    }
}
