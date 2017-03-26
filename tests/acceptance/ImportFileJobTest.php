<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Product;
/**
 * This file was created to make tests on the
 * job ImportExcelFile of the
 * ProductManagement application.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class ImportFileJobTest extends TestCase
{
    /**
     * Path of a local file
     *
     * @var string $localFile
     */
     protected $localFile;

    /**
     * Test setUp Configurations.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->localFile = __DIR__ . '/files/produtos.xls';
    }

    /**
     * Test testImportFileJob
     *
     * @return void
     */
    public function testImportFileJob()
    {
        $this->visit('/home')
              ->attach($this->localFile, 'arquivo')
              ->press('btnSubmit')
              ->see('Sua requisição já está na nossa fila de processamento e
            em breve será processada.');
    }
}
