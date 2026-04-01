<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

class ProductDataImportExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:process {action : The action to perform (import/export)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automates import/export of products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        if($action === 'import'){
            $this->importProducts();
        }else if($action === 'export'){
           $this->exportProducts();
        }else{
            $this->error('Invalid action. Use "import" or "export".');
        }

        
    }

    public function importProducts()
    {
        $filePath = storage_path('app/products/import.csv');

        if (!file_exists($filePath)) {
            $this->error('File not found: ' . $filePath);
            return;
        }

        $file = fopen($filePath, 'r');

        if (!$file) {
            $this->error('Unable to open file: ' . $filePath);
            return;
        }

        $header = fgetcsv($file);
        if (!$header) {
            $this->error('CSV file is empty or invalid.');
            fclose($file);
            return;
        }

        $rowNumber = 1;

        while ($row = fgetcsv($file)) {
            $rowNumber++;

            if (count($row) === 1 && trim($row[0]) === '') {
                continue;
            }

            // Pad missing columns with empty strings
            $row = array_pad($row, count($header), '');

            if (count($row) !== count($header)) {
                $this->error("Row {$rowNumber} column count does not match header count, skipping.");
                continue;
            }

            $productData = array_combine($header, $row);

            DB::table('products')->insert([
                'product_name' => $productData['product_name'],
                'description' => $productData['description'],
                'brand' => $productData['brand'],
                'price' => $productData['price'],
                'cost_price' => $productData['cost_price'],
                'quantity' => $productData['quantity'],
                'alert_stock' => $productData['alert_stock'],
                'created_at' => !empty($productData['created_at']) ? $productData['created_at'] : now(),
                'updated_at' => !empty($productData['updated_at']) ? $productData['updated_at'] : now(),
            ]);
        }

        fclose($file);

        $this->info('File imported successfully');
    }

    public function exportProducts()
    {
        $products = DB::table('products')->get();

        $filePath = storage_path('app/products/export.csv');

        $file = fopen($filePath, 'w');

        fputcsv($file, ['id','product_name','description','brand','price','cost_price','quantity','alert_stock','created_at','updated_at']);

        foreach($products as $product){
            fputcsv($file, [
                $product->id,
                $product->product_name,
                $product->description,
                $product->brand,
                $product->price,
                $product->cost_price,
                $product->quantity,
                $product->alert_stock,
                $product->created_at,
                $product->updated_at,
            ]);
        }

        fclose($file);
        $this->info("File exported successfully");
    }
}
