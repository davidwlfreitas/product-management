<?php

namespace App\Repositories;

/**
 * A interface service that abstracts all FileRepository
 * management related methods.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
interface FileRepositoryInterface
{
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
    public function exportExcel($type);

    /**
     * Import files with three differents Excel formats.
     *
     * This method is responsible for import files with this three
     * following excel formats:
     *        1) .XLS
     *        2) .XLSX
     *        3) .CSV
     *
     * @param String ImportExcelFile instance
     *
     * @return void
     */
    public function importExcel($path);

}
