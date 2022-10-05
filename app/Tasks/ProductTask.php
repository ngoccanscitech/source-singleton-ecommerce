<?php

namespace App\Tasks;

use App\Constants\BaseConstants;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use InApps\IAModules\Helpers\LogHelper;

use App\Imports\ProductImport;
use App\Model\ShopProduct;

class ProductTask
{
    /**
     * @param $name
     * @return string
     */

    public function getData($url_excel)
    {
        try {
            $array = Excel::toArray(new ProductImport, base_path($url_excel));

            $k = 0;
            // Log::debug($array); die;
            foreach ($array[0] as $item) {
                
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item['han_dung'])->format('Y-m-d');
                $item['han_dung'] = $date;
                Log::debug('Count process on row: ' . $k);

                $status = 1;

                $product_slug = Str::slug($item['ten_hang_hoa']);

                $product = ShopProduct::updateOrCreate(
                    [
                        'sku' => $item['ma_hang_hoa']
                    ],
                    [
                        'name' => $item['ten_hang_hoa'],
                        'slug' => $product_slug,
                        'unit'  => $item['don_vi'],
                        'price' => $item['gia_ban'],
                        'stock' => $item['so_luong'],
                        'status' => $status,
                        'expiry' => $item['han_dung'],
                    ]
                );
                //categories
                $k++;
            }
            
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            // LogHelper::error('Task error', ['message' => $e->getMessage()]);
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
