<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OAuthClient extends Model {
protected $table="oauth_clients";
protected $primaryKey="id";
public $timestamps=false;
}
