<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = [
        'employment_history_id',
        'employee_id',
        'reason',
        'status',
        'admin_comment',
    ];

    public function employmentHistory()
    {
        return $this->belongsTo(EmploymentHistory::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
