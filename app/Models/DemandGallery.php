<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemandGallery extends BaseModel
{
    protected $fillable = ['id', 'demand_id', 'img'];

    public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }

}
