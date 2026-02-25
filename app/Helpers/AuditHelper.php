<?php

// app/Helpers/AuditHelper.php
namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuditHelper
{
    public static function log(
        string $action,
        string $model,
        ?int $modelId,
        ?string $description = null
    ) {
        AuditLog::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role ?? null,
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}