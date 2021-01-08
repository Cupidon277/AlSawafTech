<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    //
    protected $guarded = ['id'];
    //
    // -------------------------------------------------------------------------
    // eloquent relationships
    //
    function orders()
    {
       return $this->hasMany(\App\Models\Order::class, 'CustomerId');
    }
    //
    // </end eloquent relationships
    // -------------------------------------------------------------------------

    /**
      * Returns this customer's full name
      *
      * @return string
    */
    function getName()
    {
        return $this->FirstName . ' ' . $this->LastName;
    }
}
