<?php

namespace App\Exports;

use App\AssignedNews;
use App\News;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromQuery, WithMapping
{
    use Exportable;
    
    private $companyId;

    public function __construct($companyId){
        $this->companyId = $companyId;
    }

    public function query()
    {
        $notesIds = AssignedNews::where('company_id', $this->companyId)->pluck('news_id');
        return News::whereIn('id', $notesIds);
    }

    public function map($note): array {
        
        $trend = $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa');

        return [
            $note->id,
            $note->title,
            $note->synthesis,
            $note->author,
            $note->authorType->description,
            $note->sector->description,
            $note->genre->description,
            $note->source->name,
            $note->section->name,
            $note->mean->name,
            Date::dateTimeToExcel($note->news_date),
            $note->cost,
            $trend
        ];
    }
}
