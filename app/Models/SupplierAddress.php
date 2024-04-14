<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SupplierAddress extends Model
{
    protected $table = "supplier_address";
    protected $fillable = [
        'supplier_id','supplier_address','company_id'
    ];

    public function supplier(){
        return $this->belongsTo('\App\Models\Supplier','supplier_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
