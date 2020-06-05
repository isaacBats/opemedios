<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    protected $image_allowed = ['jpg', 'png', 'jpeg', 'gif', 'pjpeg'];
    
    protected $doc_allowed = ['csv', 'pdf', 'asf'];
    
    protected $media_allowed_old = ['x-ms-wma', 'x-ms-wmv', 'mpeg3', 'mpeg4'];
    
    protected $media_allowed = ['webm', 'mp4', 'ogv', 'ogg'];
    
    protected $audio_allowed = ['mp3', 'wav', 'x-pn-wav', 'x-wav'];


    public function getHTMLForMedia ($file, $path) {
        
        $aux = explode('/', $file->tipo);
        $type = end($aux);
        
        $html = "El sistema no soporta elementos de tipo <strong>{$type}</strong>";
        
        if(in_array($type, $this->image_allowed)) {

            return "<img class='media img-responsive' style='width: 100%' src='{$path}' alt='Opemedios - {$file->nombre}' />";

        } elseif(in_array($type, $this->doc_allowed)) {

            return "<div class='embed-responsive'>
                <iframe class='embed-responsive-item' src='{$path}'></iframe>
            </div>";

        } elseif(in_array($type, $this->media_allowed_old)) {

            return "<div class='embed-responsive'>
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

            return "<div class='embed-responsive'>
                <video class='embed-responsive-item' controls>
                  <source
                    src='{$path}'
                    type='{$file->tipo}' />
                  Your browser doesn't support HTML5 video tag.
                </video>
            </div>";

        } elseif(in_array($type, $this->audio_allowed)) {

            return "<div class='embed-responsive'>
                <audio controls='controls'>
                  <source src='{$path}' type='{$file->tipo}' />
                  Your browser does not support the <code>audio</code> element.
                </audio>
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
