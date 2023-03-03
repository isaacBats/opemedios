<?php

namespace App\Models;

/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2020
  * @version 1.0.0
  * @package App\
  * Type: Model
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

use Illuminate\Database\Eloquent\Model;

class Cover extends Model
{
    protected $fillable = ['cover_type','title','author','date_cover','source_id','content','image'];

    protected $dates = ['date_cover'];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function image()
    {
        return $this->belongsTo(File::class);
    }
}
