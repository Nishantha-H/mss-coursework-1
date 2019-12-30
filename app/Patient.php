<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model {
protected $table="patients";
protected $primaryKey="patient_id";
//public $timestamps=false;
}
