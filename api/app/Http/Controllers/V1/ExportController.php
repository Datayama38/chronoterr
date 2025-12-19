<?php
namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\RestController;
use App\Exports\DatabaseExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends RestController
{
  public function export(Request $request): BinaryFileResponse
    {
        // Validation simple directement dans le controller
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:xlsx,csv,ods'],
        ]);

        $type = $validated['type'];
        $fileName = 'database.' . $type;
        // Déterminer le format pour Maatwebsite
        $writerType = match($type) {
            'csv' => ExcelType::CSV,
            'ods' => ExcelType::ODS,
            default => ExcelType::XLSX,
        };

    return Excel::download(new DatabaseExport, $fileName, $writerType);
    }
}