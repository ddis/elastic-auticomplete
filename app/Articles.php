<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Articles
 * @package App
 *
 * @property $created_at
 * @property $updated_at
 */
class Articles extends Model
{
    protected $table = 'articles';
    protected $dates  = ['created_at', 'updated_at'];
}
