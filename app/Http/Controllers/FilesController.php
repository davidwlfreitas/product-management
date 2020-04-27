<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Repositories\FileRepositoryInterface;
use App\Http\Controllers\Controller;
use Session;

/**
 * This class was created to allow the application import
 * or export files through a FileRepository interface.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class FilesController extends Controller
{
    /**
     * FileRepositoryInterface repository instance.
     *
     * @var $fileRepository
     */
    private $fileRepository;

    /**
     * Create a new instance of FileRepositoryInterface.
     *
     * @param App\Repositories\ProductRepository $fileRepo
     *
     * @return void
     */
    public function __construct(FileRepositoryInterface $fileRepo)
    {
        $this->fileRepository = $fileRepo;
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
          $this->fileRepository->exportExcel($type);
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
     * @return return back
     */
    public function importExcel()
    {
        if(Input::hasFile('arquivo'))
        {
            $path = Input::file('arquivo')->getRealPath();

            $this->dispatch($this->fileRepository->importExcel($path));

            Session::flash('message', "Your request is already in our processing queue and
             will be processed soon.");

            return back();
        }
    }
}
