<?php

namespace App;

use App\AssignedNews;
use App\AuthorType;
use App\File;
use App\Genre;
use App\Means;
use App\NewsletterThemeNews;
use App\Section;
use App\Sector;
use App\Source;
use App\TypePage;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ListReport extends Model
{
    protected $table = 'list_reports';
}