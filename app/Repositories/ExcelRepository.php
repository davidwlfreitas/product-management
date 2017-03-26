<?php

namespace App\Repositories;

use Excel;
use App\Repositories\ExcelRepositoryInterface;
use Carbon;

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
     * ProductRepositoryInterface repository instance.
     *
     * @var $productRepository
     */
    private $productRepository;

    /**
     * Create a new instance of ProductRepositoryInterface.
     *
     * @param App\Repositories\ProductRepositoryInterface $productRepo
     *
     * @return void
     */
    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepository = $productRepo;
    }

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

    /**
     * Read a uploaded report excel with a goal to return
     * the information configured with the Product model pattern.
     *
     * @param array $excel
     *
     * @return array $inserts of Products
     */
    public function readDataExcelAsAProduct($excel)
    {
        $inserts = [];
        $category = "";

        if(!empty($excel))
        {
            foreach ($excel as $key => $data)
            {
                $category = $this->productRepository->getExcelCategoryValue($category, $data);

                if(!empty($data) && !$this->isEmptyArray($data))
                {
                    $inserts[] = $this->productRepository->fillArrayInsertProduct($category,
                                        $data, $this->productRepository->verifyProductColumns($data));
                }
            }
        }

        return array_filter($inserts);
    }

    /**
     * Save a uploaded report excel data in the Product table.
     *
     * @param array $insertProducts
     *
     * @return void
     */
    public function saveDataExcelInProduct($insertProducts)
    {
        if(!empty($insertProducts))
        {
            foreach ($insertProducts as $key => $query)
            {
                $query = $this->changeQueryDates($query);
                $this->productRepository->updateOrCreate(['lm' => $query['lm']], $query);
            }
        }
    }

    /**
     * Change the query dates, such as created_at, updated_at
     * and deleted_at for to save in the Product table.
     *
     * @param array $query
     *
     * @return $query changed
     */
    private function changeQueryDates($query)
    {
        $countRows = $this->productRepository->findByField('lm', $query['lm'])->count();
        if($countRows > 0)
        {
            $query['deleted_at'] = $query['updated_at'] = null;
        }
        else
        {
            $query['created_at'] = Carbon\Carbon::now()->format('Y-m-d H:i:s');
        }

        return $query;
    }

    /**
     * Verify if an Array is empty or not where
     * if exists at least one value that is not null and
     * is not empty will return false.
     *
     * @param array $array
     *
     * @return boolean
     */
    private function isEmptyArray($array)
    {
        if(is_array($array) && sizeof($array) > 0)
        {
            foreach($array as $key => $value)
            {
                if(!is_null($value) && !empty($value))
                {
                    return false;
                }
            }
            return true;
        }
    }
}
