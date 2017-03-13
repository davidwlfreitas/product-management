<?php

use Mockery as m;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * This file was created to make tests on the
 * ProductController of the
 * ProductManagement application.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class ProductControllerTest extends TestCase
{
  /**
   * ProductRepository repository instance.
   *
   * @var $productRepository
   */
    private $productRepository;

    /**
     * ProductController instance.
     *
     * @var $productController
     */
    private $productController;

    /**
     * Request fake instance.
     *
     * @var $request
     */
    private $request;

    /**
     * CreateProductRequest fake instance.
     *
     * @var $createProductRequest
     */
    private $createProductRequest;

    /**
     * UpdateProductRequest fake instance.
     *
     * @var $updateProductRequest
     */
    private $updateProductRequest;

    /**
     * @var tearDown Mockery
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test setUp Configurations.
     *
     * @return void
     */
    public function setUp()
    {
      parent::setup();
      $this->request = m::mock('Illuminate\Http\Request');
      $this->productRepository = m::mock('App\Repositories\ProductRepository');
      $this->createProductRequest = m::mock('App\Http\Request\CreateProductRequest');
      $this->updateProductRequest = m::mock('App\Http\Requests\UpdateProductRequest');
      $this->productController = new App\Http\Controllers\ProductController($this->productRepository);
    }

    /**
     * Test a product show index
     *
     * @return assert
     */
     public function testIndex()
     {
       $this->productRepository->shouldReceive('pushCriteria')->once()
                               ->with(new RequestCriteria($this->request));
       $this->productRepository->shouldReceive('all')->once()->andReturn(array());
       $response = $this->productController->index($this->request);
       $this->assertEqual(array(), $response);
     }

     /**
      * Test a product store
      *
      * @return assert
      */
      public function testStore()
      {
        $input = $this->request->all();
        $this->productRepository->shouldReceive('create')->once()
                                ->with($input)
                                ->andReturn(array());
        $response = $this->productController->store($this->createProductRequest);
        $this->assertEqual(array(), $response);
      }

      /**
       * Test a product show
       *
       * @return assert
       */
       public function testShow()
       {
         $id = 1;
         $this->productRepository->shouldReceive('findWithoutFail')->once()
                                 ->with($id)
                                 ->andReturn(array());
         $response = $this->productController->show($id);
         $this->assertEqual(array(), $response);
       }

       /**
        * Test a product update
        *
        * @return assert
        */
        public function testUpdate()
        {
          $id = 1;
          $this->productRepository->shouldReceive('findWithoutFail')->once()
                                  ->with($id)
                                  ->andReturn(array());
          $this->productRepository->shouldReceive('update')->once()
                                  ->with($this->updateProductRequest->all(), $id)
                                  ->andReturn(array());
          $response = $this->productController->update($id, $this->updateProductRequest);
          $this->assertEqual(array(), $response);
        }

        /**
         * Test a product destroy
         *
         * @return assert
         */
         public function testDestroy()
         {
           $id = 1;
           $this->productRepository->shouldReceive('findWithoutFail')->once()
                                   ->with($id)
                                   ->andReturn(array());
           $this->productRepository->shouldReceive('delete')->once()
                                   ->with($id)
                                   ->andReturn(array());
           $response = $this->productController->destroy($id);
           $this->assertEqual(array(), $response);
         }
}
