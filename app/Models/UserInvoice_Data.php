<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class UserInvoice_Data extends Model
{
    use HasFactory, HasCompositeKey;

    /**
     * fillable
     *
     * @var array
     */

    protected $primaryKey = ['User_ID', 'Invoice'];
}
