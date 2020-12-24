<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model {
    protected $table = 'session';
    protected $fillable = ['userID', 'name', 'description', 'start', 'duration', 'created', 'updated'];
    // protected $hidden = ['id'];
    public $timestamps = false;
}