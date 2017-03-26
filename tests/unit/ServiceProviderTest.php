<?php

use Mockery as m;

/**
 * This file was created to make tests on the
 * service provider management of the
 * ProductManagement application using Mockery.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class ServiceProviderTest extends TestCase
{
    /**
     * Calls Mockery::close
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test register method of the repositories
     * application services.
     *
     * @return void
     */
    public function testShouldRegister()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */
        $sp = m::mock(
            'App\Providers\RepositoriesServiceProvider'.
            '[registerFileRepository, registerExcelRepository, registerProductRepository]',
            ['something']
        );
        $sp->shouldAllowMockingProtectedMethods();

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */
        $sp->shouldReceive(
            'registerFileRepository',
            'registerExcelRepository',
            'registerProductRepository'
        )
        ->once();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
        $sp->register();
    }

    /**
     * Test RegisterFileRepository method of the
     * repositories application services.
     *
     * @return void
     */
    public function testShouldRegisterFileRepository()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */
        $test = $this;
        $app = m::mock('ProductManagementApp');
        $sp = m::mock('App\Providers\RepositoriesServiceProvider'.
                      '[registerFileRepository]', [$app]);
        $sp->shouldAllowMockingProtectedMethods();

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */
        $sp->shouldReceive('registerFileRepository')
            ->once();

        $app->shouldReceive('bind')
            ->andReturnUsing(
                // Make sure that the name is 'App\Repositories\FileRepositoryInterface'
                // and that the closure passed returns the correct
                // kind of object.
                function ($name, $closure) use ($test, $app) {
                    $test->assertEquals('App\Repositories\FileRepositoryInterface', $name);
                    $test->assertInstanceOf('App\Repositories\FileRepository', $closure($app));
                }
            );

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
        $sp->registerFileRepository();
    }

    /**
     * Test testShouldRegisterExcelRepository method of the
     * repositories application services.
     *
     * @return void
     */
    public function testShouldRegisterExcelRepository()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */
        $test = $this;
        $app = m::mock('ProductManagementApp');
        $sp = m::mock('App\Providers\RepositoriesServiceProvider'.
                      '[registerExcelRepository]', [$app]);
        $sp->shouldAllowMockingProtectedMethods();

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */
        $sp->shouldReceive('registerExcelRepository')
            ->once();

        $app->shouldReceive('bind')
            ->andReturnUsing(
                // Make sure that the name is 'pp\Repositories\ExcelRepositoryInterface'
                // and that the closure passed returns the correct
                // kind of object.
                function ($name, $closure) use ($test, $app) {
                    $test->assertEquals('App\Repositories\ExcelRepositoryInterface', $name);
                    $test->assertInstanceOf('App\Repositories\ExcelRepository', $closure($app));
                }
            );

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
        $sp->registerExcelRepository();
    }

    /**
     * Test testShouldRegisterProductRepository method of the
     * repositories application services.
     *
     * @return void
     */
    public function testShouldRegisterProductRepository()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */
        $test = $this;
        $app = m::mock('ProductManagementApp');
        $sp = m::mock('App\Providers\RepositoriesServiceProvider'.
                      '[registerProductRepository]', [$app]);
        $sp->shouldAllowMockingProtectedMethods();

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */
        $sp->shouldReceive('registerProductRepository')
            ->once();

        $app->shouldReceive('bind')
            ->andReturnUsing(
                // Make sure that the name is 'pp\Repositories\ProductRepositoryInterface'
                // and that the closure passed returns the correct
                // kind of object.
                function ($name, $closure) use ($test, $app) {
                    $test->assertEquals('App\Repositories\ProductRepositoryInterface', $name);
                    $test->assertInstanceOf('App\Repositories\ProductRepository', $closure($app));
                }
            );

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
        $sp->registerProductRepository();
    }
}
