<?php
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

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'company', 'comment', 'logo', 'active', 'coverage', 'means_id'];

    public function mean()
    {
        return $this->belongsTo(Means::class, 'means_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', "%{$name}%");
        }
    }

    public function scopeCompany($query, $company)
    {
        if ($company) {
            return $query->where('company', 'like', "%{$company}%");
        }
    }
}
