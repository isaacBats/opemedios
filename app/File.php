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
        
namespace App;

use App\Http\Controllers\MediaController;
use App\News;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['name', 'path_filename', 'public', 'filesystem', 'original_name', 'folder_id', 'type', 'news_id', 'main_file', 'file_from_news'];

    /**
     * Extract the file extension from a file path.
     *
     * @param  string  $this->path_filename
     * @return string
     */
    public function extension() {
        return pathinfo($this->path_filename, PATHINFO_EXTENSION);
    }

    public function getHTML() {
        $mediaController = new MediaController();

        return $mediaController->template($this);
    }

    public function news() {
        if(!is_null($this->news_id)) {
            return $this->belongsTo(News::class);
        }

        return false;
    }
}
