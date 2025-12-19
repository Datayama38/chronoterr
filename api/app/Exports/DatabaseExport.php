<?php 
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\Sheets\EventsSheet;
use App\Exports\Sheets\ImagesSheet;
use App\Exports\Sheets\ThematicsSheet;
use App\Exports\Sheets\ThemesSheet;
use App\Exports\Sheets\RelationshipsSheet;
use App\Exports\Sheets\UsersSheet;

class DatabaseExport implements WithMultipleSheets
{
  use Exportable;
    
  public function sheets(): array
    {
      $sheets = [
        //new EventsSheet(),
        //new ImagesSheet(),
        //new ThematicsSheet(),
        //new ThemesSheet(),
        //new RelationshipsSheet(),
        new UsersSheet(),
      ];
      return $sheets;
    }
}