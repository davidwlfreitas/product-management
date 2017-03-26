<?php

namespace App\Repositories;

/**
 * A interface service that abstracts all ProductRepository
 * management related methods.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
interface ProductRepositoryInterface
{
    /**
     * Fill insert with columns data with Product Model Pattern
     * based in the array of file excel uploaded.
     *
     * @param String $category
     * @param array $data
     * @param boolean $isAProductColumn
     *
     * @return array $insertProduct
     */
    public function fillArrayInsertProduct($category, $data, $isAProductColumn);

    /**
     * Verify if data contains columns of the product model
     * to avoid that the title's columns of the sheet to be
     * insert on the product table.
     *
     * @param array $data
     *
     * @return boolean $isAProductColumn
     */
    public function verifyProductColumns($data);

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
    public function getExcelCategoryValue($category, $data);
}
