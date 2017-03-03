<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Jobs\ImportExcelFile;
use Excel;
use Session;
use App\Models\Product;

class FilesController extends Controller
{
    public function exportExcel($type)
    {
        $data = Product::withTrashed()->get()->toArray();
        return Excel::create('products_report', function($excel) use ($data) {
          $excel->sheet('mySheet', function($sheet) use ($data){
            $sheet->fromArray($data);
          });
        })->download($type);
    }

    public function importExcel()
    {
        if(Input::hasFile('arquivo'))
        {
          $path = Input::file('arquivo')->getRealPath();

          $excel = [];
          Excel::load($path, function($reader) use (&$excel) {
              $objExcel = $reader->getExcel();
              $sheet = $objExcel->getSheet(0);
              $highestRow = $sheet->getHighestRow();
              $highestColumn = $sheet->getHighestColumn();

              //  Loop through each row of the worksheet in turn
              for ($row = 1; $row <= $highestRow; $row++)
              {
                  //  Read a row of data into an array
                  $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                      NULL, TRUE, FALSE);

                  $excel[] = $rowData[0];
              }
          });

          $jobImport = (new ImportExcelFile($excel));

          $this->dispatch($jobImport);

          /* If you use a QueueDriver like a database or something different of sync
           this massage can be useful */
           Session::flash('message', "Sua requisição já está na nossa fila de processamento e
           em breve será processada.");

          return back();

        }
    }
}
