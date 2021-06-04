<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    protected $image_allowed = ['jpg', 'png', 'jpeg', 'gif', 'pjpeg'];
    
    protected $doc_allowed = ['csv', 'pdf', 'asf'];
    
    protected $media_allowed_old = ['x-ms-wma', 'x-ms-wmv', 'mpeg3', 'mpeg4'];
    
    protected $media_allowed = ['webm', 'mp4', 'ogv', 'ogg', '.mov', '.avi'];
    
    protected $audio_allowed = ['mp3', 'wav', 'x-pn-wav', 'x-wav', 'mpeg'];


    public function getHTMLForMedia ($file, $path) {
        $aux = explode('/', $file->tipo);
        $type = end($aux);
        
        $html = "El sistema no soporta elementos de tipo <strong>{$type}</strong>";
        
        if(in_array($type, $this->image_allowed)) {

            return "<img class='img-responsive' style='width: 100%' src='{$path}' alt='Opemedios - {$file->nombre}' />";

        } elseif(in_array($type, $this->doc_allowed)) {

            return "<div id='lightbox' class='uk-box-shadow-medium uk-text-center lightbox pdf' uk-lightbox>
                <embed src='{$path}' class='embed-responsive-item'></embed>
            </div>";

        } elseif(in_array($type, $this->media_allowed_old)) {

            return "<div class='embed-responsive embed-responsive-16by9'>
                <object class='embed-responsive-item' data='{$path}' type='{$file->tipo}'>
                       <param name='src' value='{$path}'>
                       <param name='autostart' value='0'>
                       <param name='volume' value='0'>
                       <param name='showcontrols' value='1'>
                       <param name='showdisplay' value='1'>
                       <param name='showstatusbar' value='1'>
                       <param name='playcount' value='1'>
                </object>
            </div>";

        } elseif(in_array($type, $this->media_allowed)) {

            return "<div id='lightbox' class='uk-box-shadow-small uk-text-center lightbox video' uk-lightbox>
                <embed src='{$path}' class='embed-responsive-item'></embed>
            </div>";

        } elseif(in_array($type, $this->audio_allowed)) {

            return "<div id='lightbox' class='uk-box-shadow-small uk-text-center lightbox video' uk-lightbox>
                <embed src='{$path}' class='embed-responsive-item'></embed>
            </div>";
        }

        return "<a href='{$path}' download='{$file->nombre}'>Descargar Archivo</a>";
    }

    public function template(File $file) {

        $template = 'components.media-audio';
        if(in_array($file->extension(), $this->image_allowed)) {
            return view('components.media-image', compact('file'))->render();
        } 
        // elseif(in_array($file->extension(), $this->doc_allowed)) {
        //     return view('components.media-document', compact('file'))->render();
        // }

        return view($template, compact('file'))->render();
    }
}
