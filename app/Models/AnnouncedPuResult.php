<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncedPuResult extends Model
{
    use HasFactory;
    public $timestamps = false; // i dont want created_at and updated_at

    protected $fillable = [
        'polling_unit_uniqueid',
        'party_abbreviation',
        'party_score',
        'entered_by_user',
        'date_entered',
        'user_ip_address'
    ];
}
