<?php

namespace App\Exports;

use App\News;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewsExport implements FromCollection, WithHeadings
{
    

    public function headings(): array
    {
        $data = array();
        $last = News::all()->last();
        
        foreach ($last->metas() as $meta) {
            if($meta['label'] == 'Hora' || 
               $meta['label'] == 'Duración' || 
               $meta['label'] == 'Tipo de página' ||
               $meta['label'] == 'Número de página' ||
               $meta['label'] == 'Tamaño de página' ||
               $meta['label'] == 'URL' 
           ) {
                continue;
            }

            $data[] = $meta['label'];
        }

        return $data;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        $collection = collect();
        foreach (News::all() as $note) {
            foreach ($note->metas() as $meta) {
                if($meta['label'] == 'Hora' || 
                   $meta['label'] == 'Duración' || 
                   $meta['label'] == 'Tipo de página' ||
                   $meta['label'] == 'Número de página' ||
                   $meta['label'] == 'Tamaño de página' ||
                   $meta['label'] == 'URL' 
               ) {
                    continue;
                }

                if($meta['label'] == 'Síntesis') {
                    $meta['value'] = Str::limit($meta['value'], 150, '...');
                }
                $data[$meta['label']] = $meta['value'];
            }

            $collection->push($data);

        }

        return $collection;
    }
}
