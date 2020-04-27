# **Product Management** #

This project is a template solution for import/export excel files with different formats, such as .xls, .xlsx and .csv. All the project works based on a products base, but you free for create your own model and after that just change some parts of the code and feel free to change all the views in your own.

### Getting Started

1) Clone Repo

`git clone git@github.com:davidwlfreitas/product-management.git`

2) Run composer install

Run `composer install` command to install required dependencies. Once everything is installed, you are ready to use ProductManagement template.

### **Configuration**

1) If your prefer put your own models, feel free to change to run your own migrations, but if you prefer using the original models just run the migrations.

```php

php artisan migrate

```
2) If you prefer change the product model, follow this steps above:

2.1. Put the name of your new model in the file ***FileRepository.php*** on the method ***exportExcel($type)***, and change the name of your download files in the parameter **'products_report'**.

```php
...
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
public function exportExcel($type)
{
    $data = Product::withTrashed()->get()->toArray();
    return $this->excelRepository
                ->createReportExcel('products_report','mySheet',$data)
                ->download($type);
}

...
```

2.2. Put your own columns to be insert in your new table in the job called ***ProductRepository.php*** in the function fillArrayInsertProduct().

```php
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
```

## **Running the tests**

For tests just run vendor/bin/phpunit

## **Built With**

* [Laravel Excel](http://www.maatwebsite.nl/laravel-excel/docs)
* [InfyOm](http://labs.infyom.com/laravelgenerator/)

## **Contributing guidelines**

Support follows PSR-1 and PSR-4 PHP coding standards, and semantic versioning.

Please report any issue you find in the issues page.
Pull requests are welcome.

## **Authors**

* **David Freitas** - [davidwlfreitas](https://github.com/davidwlfreitas)

## **Documentation**

* Add PHPDoc blocks for all classes, methods, and functions
* Omit the `@return` tag if the method does not return anything
* Add a blank line before `@param`, `@return` and `@throws`

## **License**

Product Management is free software distributed under the terms of the MIT license.
