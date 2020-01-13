<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{

    const ENCOURS = 1;
    const LIVRER = 2;
    const  ANNULER = 3;
    //public $timestamps = false;
    protected $fillable = ['name', 'deliveryDate', 'status'];
    protected $dates = ['issueDate', 'deliveryDate'];

    public function products()
    {
        return $this->belongsToMany('App\Product', 'articles');
    }

    public function getTotalAttribute()
    {
        return $this->attributes['total'] == $this->total();
    }

    public function total()
    {
        $total = 0;

        foreach ($this->products as $product) {
            $total += $product->total;
        }

        return $total;
    }
}
