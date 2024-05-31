<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
      public function voucher()
      {
          return $this->belongsTo(Voucher::class);
      }

      public function accountingTree()
      {
          return $this->belongsTo(accounting_tree::class);
      }
}
