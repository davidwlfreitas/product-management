<?php

namespace App\Http\Traits;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Repositories\ProductRepository;

/**
 * This trait was created to support mock tests on the
 * ProductManagement application.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
trait MakeProductTrait
{
    /**
     * Create fake instance of Product and save it in database
     *
     * @param array $productFields
     *
     * @return Product
     */
    public function makeProduct($productFields = [])
    {
        $theme = $this->fakeProductData($productFields);
        return $theme;
    }

    /**
     * Get fake instance of Product
     *
     * @param array $productFields
     *
     * @return Product
     */
    public function fakeProduct($productFields = [])
    {
        return new Product($this->fakeProductData($productFields));
    }

    /**
     * Get fake data of Product
     *
     * @param array $postFields
     *
     * @return array
     */
    public function fakeProductData($productFields = [])
    {
        $fake = Faker::create();
        return $productFields;
    }
}
