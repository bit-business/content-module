<?php

namespace NadzorServera\Skijasi\Module\Content\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = null;

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('skijasi.database.prefix');
        $this->table = $prefix.'contents';
        parent::__construct($attributes);
    }

    protected $guarded = [];
}
