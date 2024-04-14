<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ProductsImport implements ToModel, WithBatchInserts, SkipsEmptyRows
{
    public function model(array $row)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $store_id = $company->stores[0]->id;
        $category_id = $company->categories[0]->id;
        $now = date("Y-m-d H:i:s");
        $units = Unit::where('company_id', $company_id)->count();
        if ($units != 0) {
            $unitID = Unit::where('company_id', $company_id)->first()->id;
            return new Product([
                'company_id' => $company_id,
                'store_id' => $store_id,
                'category_id' => $category_id,
                'product_name' => $row[0],
                'wholesale_price' => $row[1],
                'sector_price' => $row[2],
                'first_balance' => $row[3],
                'purchasing_price' => $row[4],
                'code_universal' => $row[5],
                'min_balance' => 2,
                'unit_id' => $unitID,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

        } else {
            return new Product([
                'company_id' => $company_id,
                'store_id' => $store_id,
                'category_id' => $category_id,
                'product_name' => $row[0],
                'wholesale_price' => $row[1],
                'sector_price' => $row[2],
                'first_balance' => $row[3],
                'purchasing_price' => $row[4],
                'code_universal' => $row[5],
                'min_balance' => $row[6],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

    }

    public function batchSize(): int
    {
        return 1600;
    }
}
