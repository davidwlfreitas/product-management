<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\ExcelRepositoryInterface;

/**
 * This class was created to allow the application import
 * files through a Job instance based on Queue concepts.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class ImportExcelFile extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * ImportExcelFile job instance
     *
     * @var $excel
     */
    protected $excel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($excelFile)
    {
        $this->excel = $excelFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ExcelRepositoryInterface $excelRepository)
    {
        $insertProducts = $excelRepository->readDataExcelAsAProduct($this->excel);
        $excelRepository->saveDataExcelInProduct($insertProducts);
    }
}
