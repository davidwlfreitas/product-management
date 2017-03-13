<?php

namespace App\Repositories;

use App\Models\Product;
use InfyOm\Generator\Common\BaseRepository;

/**
 * A service that abstracts all product interactions that happens
 * in ProductManagement using App\Models\Product.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class ProductRepository extends BaseRepository
{
    /**
     * Product model instance.
     *
     * @var $fieldSearchable
     */
    protected $fieldSearchable = [
        'category',
        'lm',
        'name',
        'free_shipping',
        'description',
        'price'
    ];

    /**
     * Configure the Model
     *
     * @return Product::class
     **/
    public function model()
    {
        return Product::class;
    }
}
