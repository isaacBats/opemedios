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
        $company = Company::findOrFail($this->filter['company_id']);
        $assignedNews = $company->assignedNews()->select('news_id')->get();
        $rows = News::whereIn('id', $assignedNews)
            ->whereDate('news_date', '>=', $this->filter['fstart'])
            ->whereDate('news_date', '<=', $this->filter['fend'])
            ->get();
        foreach ($rows as $note) {
            $data['ID Noticia'] = "OPE-{$note->id}";
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
