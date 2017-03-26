<?php

namespace App\Repositories;

use App\Jobs\ImportExcelFile;
use App\Models\Product;
use App\Repositories\ExcelRepositoryInterface;

/**
 * A service that abstracts all file interactions that happens
 * in ProductManagement using FileRepositoryInterface.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class FileRepository implements FileRepositoryInterface
{
    /**
     * ExcelRepositoryInterface repository instance.
     *
     * @var $excelRepository
     */
    private $excelRepository;

    /**
     * Create a new instance of ExcelRepositoryInterface.
     *
     * @param App\Repositories\ExcelRepositoryInterface $excelRepo
     *
     * @return void
     */
    public function __construct(ExcelRepositoryInterface $excelRepo)
    {
        $this->excelRepository = $excelRepo;
    }

    /**
     * Export files to three differents Excel formats.
     *
     * This method is responsible to export files in this three
     * following excel formats:
     *        1) .XLS
     *        2) .XLSX
     *        3) .CSV
     *
     * @param String $type
     *
     * @return void
     */
    public function exportExcel($type)
    {
        $data = Product::withTrashed()->get()->toArray();
        return $this->excelRepository
                    ->createReportExcel('products_report','mySheet',$data)
                    ->download($type);
    }

    /**
     * Import files with three differents Excel formats.
     *
     * This method is responsible for import files with this three
     * following excel formats:
     *        1) .XLS
     *        2) .XLSX
     *        3) .CSV
     *
     * @param String $path
     *
     * @return return ImportExcelFile instance
     */
    public function importExcel($path)
    {
        $excel = $this->excelRepository->loadReportExcel($path);
        $jobImport = new ImportExcelFile($excel, $this->excelRepository);
        return $jobImport;
    }
}
