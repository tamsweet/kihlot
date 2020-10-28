<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundPolicy extends Model
{
    protected $table = 'refund_policies';

    protected $fillable = [ 'name', 'amount', 'days', 'detail', 'status'];
}
