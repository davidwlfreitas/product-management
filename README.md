# Product Management

This project is a template solution for import/export excel files with different formats, such as .xls, .xlsx and .csv. All the project works based on a products base, but you free for create your own model and after that just change some parts of the code and feel free to change all the views in your own.

### Getting Started

1) Clone Repo

You can clone a repo from: [ProductManagement](https://bitbucket.org/davidwlfreitas/product-management)

2) Run composer install

Run `composer install` command to install required dependencies. Once everything is installed, you are ready to use ProductManagement template.

### Configuration

1) If your prefer put your own models, feel free to change to run your own migrations, but if you prefer using the original models just run the migrations.

```
php artisan migrate

```
2) If you prefer change the product model, follow this steps above:

2.1) Put the name of your new model in the file FileRepository.phpunit on the method exportExcel($type), and change the name of your download files in the parameter 'products_report'.

```
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

2.2) Put your own fillabes to be insert in your new table in the job called ImportExcelFile.php on the function handle().

```
// Prepare insert with row's data.
if(!$isFillabe){
  $insert[] = ['category' => $category,
               'lm' => $data[0],
               'name' => $data[1],
               'free_shipping' => $data[2],
               'description' => $data[3],
               'price' => $data[4]];
}
```

2.3) Change the name of your new table create or run what you want in the job called ImportExcelFile.php on the function handle().

```
// Set data on the Products' table.
if(!empty($insert)){
  foreach ($insert as $key => $value) {
    $countProducts = DB::table('products')->where('lm', $value['lm'])->count();
    if($countProducts > 0){
        // Update Products
        $value['deleted_at'] = $value['updated_at'] = null;
        DB::table('products')->where('lm', $value['lm'])->update($value);
    }else{
        // Insert new Products
        $value['created_at'] = Carbon\Carbon::now()->format('Y-m-d H:i:s');
        DB::table('products')->insert($value);
    }
  }
}
```

## Running the tests

For tests just run vendor/bin/phpunit

## Built With

* [Laravel Excel](http://www.maatwebsite.nl/laravel-excel/docs) - The web framework used

## Contributing guidelines

Support follows PSR-1 and PSR-4 PHP coding standards, and semantic versioning.

Please report any issue you find in the issues page.
Pull requests are welcome.

## Authors

* **David Freitas** - [davidwlfreitas](https://bitbucket.org/davidwlfreitas)

## Documentation

* Add PHPDoc blocks for all classes, methods, and functions
* Omit the @return tag if the method does not return anything
* Add a blank line before @param, @return and @throws

## License

Product Management is free software distributed under the terms of the MIT license.
