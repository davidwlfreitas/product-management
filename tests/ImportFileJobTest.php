<?php

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
   * Product fakeinstance.
   *
   * @var $productFake
   */
    protected $productFake;

    /**
     * Test setUp Configurations.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->localFile = __DIR__ . '/files/produtos.xls';
        $this->productFake = array('id' => 1,
                                  'category' => 'Ferramentas',
                                  'lm' => 1001,
                                  'name' => 'Furadeira X',
                                  'free_shipping' => 0,
                                  'description' => 'Furadeira eficiente X',
                                  'price' => 100);
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
              ->expectsJobs(App\Jobs\ImportExcelFile::class)
              ->see('Sua requisição já está na nossa fila de processamento e
           em breve será processada.')
              ->seeInDatabase('products', $this->productFake);
    }
}
