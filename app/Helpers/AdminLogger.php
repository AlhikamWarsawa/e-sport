<?php

namespace App\Helpers;

use App\Models\AdminActivityLog;
use Illuminate\Support\Facades\Auth;

class AdminLogger
{
    public static function log(string $action, array $data = []): void
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return;
        }

        AdminActivityLog::create([
            'admin_id'  => $admin->id,
            'action'    => $action,
            'data'      => $data,
            'created_at' => now()->addHours(7),
        ]);
    }
}
