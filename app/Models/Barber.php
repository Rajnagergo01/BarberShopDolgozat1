<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;

class Barber extends Model
{
    protected $table = "barbers";
    protected $fillable = ["barber_name"];

    public function appointment() {
        return $this->hasMany(Appointment::class);
    }
}
