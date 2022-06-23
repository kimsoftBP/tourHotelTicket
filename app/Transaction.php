<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table="transaction";
    protected $primaryKey="id";
    protected $fillable = [
        'checkoutid','transaction_code','merchant_code', 'transaction_id', 'merchang_code','amount','timestamp', 'vat_amount','id','tip_amount','currency', 'status','payment_type','entry_mode','installments_count','internal_id','updated_at',
    ];
}
