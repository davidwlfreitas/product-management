<?php

namespace App\Repositories;

use App\Models\Product;
use InfyOm\Generator\Common\BaseRepository;
use App\Repositories\ProductRepositoryInterface;

/**
 * A service that abstracts all product interactions that happens
 * in ProductManagement using App\Models\Product.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
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

    /**
     * Fill insert with columns data with Product Model Pattern
     * based in the array of file excel uploaded.
     *
     * @param array $data
     * @param boolean $isAProductColumn
     *
     * @return array $insertProduct
     */
    public function fillArrayInsertProduct($category, $data, $isAProductColumn)
    {
        $insertProduct = [];
        if(!$isAProductColumn)
        {
          $insertProduct = ['category' => $category,
                            'lm' => $data[0], 'name' => $data[1],
                            'free_shipping' => $data[2], 'description' => $data[3],
                            'price' => $data[4]];
        }

        return $insertProduct;
    }

    /**
     * Verify if data contains columns of the product model
     * to avoid that the title's columns of the sheet to be
     * insert on the product table.
     *
     * @param array $data
     *
     * @return boolean $isAProductColumn
     */
    public function verifyProductColumns($data)
    {
        $isAProductColumn = false;
        $productColumns = ['category','lm','name','free_shipping','description','price'];

        foreach ($data as $key => $value)
        {
            if(!empty($value) && !is_null($value))
            {
                if(in_array($value,$productColumns))
                {
                    $isAProductColumn = true;
                    break;
                }
            }
        }

        return $isAProductColumn;
    }

    /**
     * Get the category's value of the excel file uploaded.
     *
     * The only reason of this function exists is just because
     * the model of the used Excel has the value of the category
     * below of the Category Column and this bring
     * some difficulties during the excel file reading.
     *
     * @param array $data
     * @param String $category
     *
     * @return String $category
     */
    public function getExcelCategoryValue($category, $data)
    {
        foreach ($data as $key => $value)
        {
            if(!empty($value))
            {
                if($value == "category" )
                {
                    $category = next($data);
                    break;
                }
            }
        }

        return $category;
    }
}
