<?php

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Traits\MakeProductTrait;
use App\Http\Traits\ApiTestTrait;
use Faker\Factory as Faker;
use \Mockery as M;

class ProductRepositoryTest extends TestCase
{
    use MakeProductTrait, DatabaseTransactions, ApiTestTrait;

    /**
     * @var ProductRepository
     */
    protected $productRepo;
    protected $productFake;

    public function setUp()
    {
        parent::setUp();
        $this->localFile = __DIR__ . '/files/produtos.xls';
        $this->productRepo = $this->mock(App\Repositories\productRepository::class);
        $this->productFake = array('id' => 1,
                                  'category' => 'Ferramentas',
                                  'lm' => 1001,
                                  'name' => 'Furadeira X',
                                  'free_shipping' => 0,
                                  'description' => 'Furadeira eficiente X',
                                  'price' => 100);
    }

    /**
     * @var Create Mockery
     */
    public function mock($class)
    {
      $mock = M::mock($class);
      $this->app->instance($class, $mock);
      return $mock;
    }

    /**
     * @var tearDown Mockery
     */
    public function tearDown()
    {
        M::close();
    }

    /**
     * test ImportFile
     *
     * @return void
     */
    public function testImportFile()
    {
        $this->visit('/home')
              ->attach($this->localFile, 'arquivo')
              ->press('btnSubmit')
              ->expectsJobs(App\Jobs\ImportExcelFile::class)
              ->see('Sua requisição já está na nossa fila de processamento e
           em breve será processada.');
              // ->seeInDatabase('products', $this->productFake);
    }

    /**
     * @test create
     */
    public function testCreateProduct()
    {
        $product = $this->makeProduct($this->productFake);
        $mockCreateRequest = $this->mock(App\Http\Requests\CreateProductRequest::class);
        $mockCreateRequest->shouldReceive('all')
                          ->andReturn($product);

        $this->productRepo->shouldReceive('store')
                          ->with($mockCreateRequest)
                          ->andReturn('Product saved successfully.');
        $this->productRepo->shouldReceive('create')
                          ->with($this->productFake)
                          ->andReturn('products.create');

        $ProductController = new ProductController($this->productRepo);
        $ProductController->store($mockCreateRequest);
    }

    /**
     * @test show
     */
    public function testShowProduct()
    {
        $product = $this->makeProduct($this->productFake);
        $this->productRepo->shouldReceive('show')
                          ->with($product['id'])
                          ->andReturn('products.show');
        $this->productRepo->shouldReceive('findWithoutFail')
                          ->with($product['id'])
                          ->andReturn($product);

        $this->assertSessionMissing('Product not found');

        $ProductController = new ProductController($this->productRepo);
        $response = $ProductController->show($product['id']);
    }

    /**
     * @test edit
     */
    public function testEditProduct()
    {
        $product = $this->makeProduct($this->productFake);
        $this->productRepo->shouldReceive('edit')
                          ->with($product['id'])
                          ->andReturn('products.edit');
        $this->productRepo->shouldReceive('findWithoutFail')
                          ->with($product['id'])
                          ->andReturn($product);

        $this->assertSessionMissing('Product not found');

        $ProductController = new ProductController($this->productRepo);
        $ProductController->edit($product['id']);
    }

    /**
     * @test delete
     */
    public function testDeleteProduct()
    {
        $product = $this->makeProduct($this->productFake);
        $this->productRepo->shouldReceive('destroy')
                          ->with($product['id'])
                          ->andReturn('products.index');
        $this->productRepo->shouldReceive('findWithoutFail')
                          ->with($product['id'])
                          ->andReturn($product);
        $this->productRepo->shouldReceive('delete')
                          ->with($product['id'])
                          ->andReturn(true);

        $ProductController = new ProductController($this->productRepo);
        $ProductController->destroy($product['id']);
    }
}
