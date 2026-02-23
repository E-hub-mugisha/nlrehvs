<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentHistory extends Model
{
    protected $fillable = [
        'employee_id',
        'company_name',
        'start_date',
        'end_date',
        'exit_reason',
        'employer_feedback',
        'employer_id'
    ];

    // Relationship
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}
