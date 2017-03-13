<?php

namespace App\Repositories;

use Excel;

/**
 * A service that abstracts all excel interactions that happens
 * in ProductManagement using /maatwebsite/excel.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class ExcelRepository implements ExcelRepositoryInterface
{
    /**
     * Create a Excel Report that will be download through the
     * ProductManagement apllication.
     *
     * @param String $nameReport
     * @param String $nameSheet
     * @param Array $data
     *
     * @return return Excel Report for download
     */
    public function createReportExcel($nameReport, $nameSheet, $data)
    {
        return Excel::create($nameReport, function($excel) use ($data,$nameSheet) {
            $this->createSheetExcel($excel, $data, $nameSheet);
        });
    }

    /**
     * Create a Excel Sheet that will be support the
     * report excel's creation.
     *
     * @param /maatwebsite/excel $excel
     * @param Array $data
     * @param String $nameSheet
     *
     * @return array sheet
     */
    public function createSheetExcel($excel, $data, $nameSheet)
    {
        return $excel->sheet($nameSheet, function($sheet) use ($data){
          $sheet->fromArray($data);
        });
    }

    /**
     * Load a uploaded report excel with a goal to import
     * all the information to the database.
     *
     * @param String $path
     *
     * @return array $excel
     */
    public function loadReportExcel($path)
    {
        $excel = [];
        Excel::load($path, function($reader) use (&$excel) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $excel = $this->fillDataExcel($sheet, $excel);
        });

        return $excel;
    }

    /**
     * Fill all the data in excel format and returns a
     * array ordered.
     *
     * @param Object Sheet from Excel $sheet
     * @param array $excel
     *
     * @return return type
     */
    public function fillDataExcel($sheet, $excel)
    {
        for ($row = 1; $row <= $sheet->getHighestRow(); $row++)
        {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $sheet->getHighestColumn() . $row,
                NULL, TRUE, FALSE);

            $excel[] = $rowData[0];
        }

        return $excel;
    }
}
