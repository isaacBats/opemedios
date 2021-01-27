<?php

namespace App\Exports;

use App\Company;
use App\News;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;


class NewsExport implements FromView
{
    use Exportable; 

    protected $filter;

    public function __construct(array $filter) {
        $this->filter = $filter;
    }

    /**
    * @return \Illuminate\Contracts\View\View
    */
    public function view(): View
    {
        $last = News::all()->last();
        $collection = collect();
        $filterData = [ 'start' => $this->filter['fstart'], 'end' => $this->filter['fend'], 'today' => Carbon::parse(Carbon::today())->formatLocalized('%A %d de %B %Y')];
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
            $data['Link'] = route('front.detail.news', ['qry' => \Illuminate\Support\Facades\Crypt::encryptString("{$note->id}-{$note->title}-{$company->id}")]);

            $collection->push($data);
        }
        return view('clients.report.report', compact('last', 'collection', 'company', 'filterData'));
    }
}
