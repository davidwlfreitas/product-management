<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Requests;
use DB;
use App\Models\Product;
use Carbon;

class ImportExcelFile extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $excel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($excel)
    {
        $this->excel = $excel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $insert = [];
        $category = "category";
        $isFillabe = true;
        $fillable = ['lm','name','free_shipping','description','price'];
        if(!empty($this->excel)){
          foreach ($this->excel as $key => $data) {

              // Prepare insert with row's data.
              if(!$isFillabe){
                $insert[] = ['category' => $category,
                             'lm' => $data[0],
                             'name' => $data[1],
                             'free_shipping' => $data[2],
                             'description' => $data[3],
                             'price' => $data[4]];
              }

              foreach ($data as $key => $value) {
                if(!empty($value) && $isFillabe){

                  // Set category's value
                  if($value == "category" ){
                    $category = next($data);
                    break;
                  }

                  // Avoid insert the title's row of the sheet.
                  if(array_search($value,$fillable)){
                    $isFillabe = false;
                    break;
                  }
                }
              }

          }
        }

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

    }
}
