<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'national_id',
        'user_id',
        'skills',
        'job_role',
        'employment_status',
    ];

    protected $hidden = [
        'national_id', // hide from accidental exposure
    ];

    // protected $casts = [
    //     'national_id' => 'encrypted',
    // ];


    public function employmentHistories()
    {
        return $this->hasMany(EmploymentHistory::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
