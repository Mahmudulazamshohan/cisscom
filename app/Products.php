<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'manufacturer',
        'model',
        'year',
        'country'];
    protected $appends = ['edit'];
    public function getEditAttribute(){
        return false;
    }

}
