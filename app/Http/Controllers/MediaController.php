<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function getHTMLForMedia ($file, $path) {
        $img_allowed = ['jpg', 'png', 'jpeg', 'gif', 'pjpeg'];
        $doc_allowed = ['csv', 'pdf'];
        $media_allowed_old = ['x-ms-wma', 'x-ms-wmv', 'mpeg3', 'mpeg4', 'mpeg'];
        $media_allowed = ['webm', 'mp4', 'ogv', 'ogg'];
        $audio_allowed = ['mp3', 'wav', 'x-pn-wav', 'x-wav'];
        $aux = explode('/', $file->tipo);
        $type = end($aux);
        
        $html = "El sistema no soporta elementos de tipo <strong>{$type}</strong>";
        
        if(in_array($type, $img_allowed)) {

            return "<img class='media img-responsive' style='width: 100%' src='{$path}' alt='Opemedios - {$file->nombre}' />";

        } elseif(in_array($type, $doc_allowed)) {

            return "<div>
                <iframe style='width: 100%;' src='{$path}'></iframe>
            </div>";

        } elseif(in_array($type, $media_allowed_old)) {

            return "<div>
                <object style='width: 100%;' data='{$path}' type='{$file->tipo}'>
                       <param name='src' value='{$path}'>
                       <param name='autostart' value='0'>
                       <param name='volume' value='0'>
                       <param name='showcontrols' value='1'>
                       <param name='showdisplay' value='1'>
                       <param name='showstatusbar' value='1'>
                       <param name='playcount' value='1'>
                </object>
            </div>";

        } elseif(in_array($type, $media_allowed)) {

            return "<div>
                <video style='width: 100%;' controls>
                  <source src='{$path}' type='{$file->tipo}' />
                  Your browser doesn't support HTML5 video tag.
                </video> 
            </div>";

        } elseif(in_array($type, $audio_allowed)) {

            return "<div>
                <video style='width: 100%;' controls>
                  <source src='{$path}' type='{$file->tipo}' />
                  Your browser doesn't support HTML5 video tag.
                </video> 
            </div>";
        }

        return "<a href='{$path}' download='{$file->nombre}'>Descargar Archivo</a>";
    }
}
