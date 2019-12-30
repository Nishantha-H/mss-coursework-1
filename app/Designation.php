<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model {
protected $table="users_designations";
protected $primaryKey="designation_id";
public $timestamps=false;
}
