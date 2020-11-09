<?php

namespace App\Exports;

use App\Company;
use App\News;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewsExport implements FromCollection, WithHeadings
{
    use Exportable; 

    protected $filter;

    public function __construct(array $filter) {
        $this->filter = $filter;
    }
    
    public function headings(): array
    {
        $data = array();
        $last = News::all()->last();
        $data[] = 'ID Noticia';
        $data[] = 'Tema';

        foreach ($last->metas() as $meta) {
            if($meta['label'] == 'Hora' || 
               $meta['label'] == 'Duración' || 
               $meta['label'] == 'Tipo de página' ||
               $meta['label'] == 'Número de página' ||
               $meta['label'] == 'Tamaño de página' ||
               $meta['label'] == 'URL' ||
               $meta['label'] == 'Creador' 
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
        $company = Company::findOrFail($this->filter['company_id']);
        $assignedNews = $company->assignedNews()
            ->select('news_id')
            ->when($this->filter['theme_id'] != 'default', function($q) {
                return $q->where('theme_id', $this->filter['theme_id']);
            })->get();
        $query = News::query();
        $query->whereIn('id', $assignedNews)
            ->whereDate('news_date', '>=', $this->filter['fstart'])
            ->whereDate('news_date', '<=', $this->filter['fend']);
        $query->when($this->filter['sector_id'] != 'default', function ($q) {
            return $q->where('sector_id', $this->filter['sector_id']);
        })->when($this->filter['genre_id'] != 'default', function ($q) {
                return $q->where('genre_id', $this->filter['genre_id']);
        })->when($this->filter['trend'] != 'default', function ($q) {
            return $q->where('trend', $this->filter['trend']);
        })->when($this->filter['mean_id'] != 'default', function ($q) {
            return $q->where('mean_id', $this->filter['mean_id']);
        });
        $rows = $query->get();
        foreach ($rows as $note) {
            $data['ID Noticia'] = "OPE-{$note->id}";
            $data['Tema'] = $note->assignedNews()->where('news_id', $note->id)->first()->theme->name;
            foreach ($note->metas() as $meta) {
                if($meta['label'] == 'Hora' || 
                   $meta['label'] == 'Duración' || 
                   $meta['label'] == 'Tipo de página' ||
                   $meta['label'] == 'Número de página' ||
                   $meta['label'] == 'Tamaño de página' ||
                   $meta['label'] == 'URL' ||
                   $meta['label'] == 'Creador'
               ) {
                    continue;
                }

                if($meta['label'] == 'Síntesis') {
                    $meta['value'] = Str::limit($meta['value'], 150, '...');
                }

                if($meta['label'] == 'Fecha') {
                    $meta['value'] = Carbon::parse($note->news_date)->format('Y-m-d');
                }

                $data[$meta['label']] = $meta['value'];
            }

            $collection->push($data);

        }

        return $collection;
    }
}
