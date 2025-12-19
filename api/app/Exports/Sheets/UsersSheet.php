<?php 
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\User;

class UsersSheet implements FromQuery, WithTitle, WithHeadings, WithMapping, ShouldAutoSize
{
   
  public function query()
  {
    return  User::query();    
  }

  public function title(): string
    {
        return 'Utilisateurs';
    }

  public function map($data): array
  {
    $map = [
      $data->id,
      $data->firstname,
      $data->name,
      $data->email,
      $data->organization,
      $data->role->name
    ];
    
    return $map;
  }

  public function headings(): array
  {
    $headings = [
      'id',
      'prenom',
      'nom',
      'mail',
      'organisme',
      'role', 
    ]; 
    return $headings;
  }
}

