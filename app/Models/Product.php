<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static FindOrFail($id, string[] $array)
 */
class Product extends Model
{
    protected $table = "products";
    protected $fillable = [
        'company_id','store_id','category_id','product_name','wholesale_price','sector_price','first_balance','purchasing_price',
        'product_model','product_pic','code_universal','description','min_balance','unit_id','sub_category_id','color','viewed'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }

    public function unit(){
        return $this->belongsTo('\App\Models\Unit','unit_id','id');
    }
    public function store(){
        return $this->belongsTo('\App\Models\Store','store_id','id');
    }

    public function category(){
        return $this->belongsTo('\App\Models\Category','category_id','id');
    }
    public function subcategory(){
        return $this->belongsTo('\App\Models\SubCategory','sub_category_id','id');
    }

    public function buy_bill_elements(){
        return $this->hasMany('\App\Models\BuyBillElement','product_id','id');
    }

    public function buy_bill_return(){
        return $this->hasMany('\App\Models\BuyBillReturn','product_id','id');
    }

    public function sale_bill_elements(){
        return $this->hasMany('\App\Models\SaleBillElement','product_id','id');
    }

    public function sale_bill_return(){
        return $this->hasMany('\App\Models\SaleBillReturn','product_id','id');
    }

    public function gifts(){
        return $this->hasMany('\App\Models\Gift','product_id','id');
    }

    public function quotation_elements(){
        return $this->hasMany('\App\Models\QuotationElement','product_id','id');
    }


}
