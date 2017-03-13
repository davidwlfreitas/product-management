<?php

namespace App\Repositories;

/**
 * A interface service that abstracts all ExcelRepository
 * management related methods.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
interface ExcelRepositoryInterface
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
    public function createReportExcel($nameReport, $nameSheet, $data);

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
    public function createSheetExcel($excel, $data, $nameSheet);

    /**
     * Load a uploaded report excel with a goal to import
     * all the information to the database.
     *
     * @param String $path
     *
     * @return array $excel
     */
    public function loadReportExcel($path);

    /**
     * Fill all the data in excel format and returns a
     * array ordered.
     *
     * @param Object Sheet from Excel $sheet
     * @param array $excel
     *
     * @return return type
     */
    public function fillDataExcel($sheet, $excel);

}
