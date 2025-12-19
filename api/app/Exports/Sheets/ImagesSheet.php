<?php 
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Image;

class ImagesSheet implements FromQuery, WithTitle, WithHeadings, WithMapping, ShouldAutoSize
{
   
  public function query()
  {
    return  Image::query();    
  }

  public function title(): string
    {
        return 'Images';
    }

  public function map($data): array
  {
    $map = [
      $data->id,
      $data->filename,
      $data->legend_fr,
      $data->legend_en,
      $data->copyright,
      Date::dateTimeToExcel($data->created_at),
      Date::dateTimeToExcel($data->updated_at),
    ];
    
    return $map;
  }

  public function headings(): array
  {
    $headings = [
      'id',
      'filename',
      'legend_fr',
      'legend_en',
      'copyright',
      'created_at',
      'updated_at',
    ];
    return $headings;
  }
}

