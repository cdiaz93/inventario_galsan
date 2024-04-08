<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemporaryUse extends Model
{
    //

    protected $table = "temporary_use";

    protected $fillable = [
        "id_user",
        "name_user",
        "id_inventory"
    ];
}
