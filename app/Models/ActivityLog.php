<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'role',
        'action',
        'description',
        'ip_address',
        'entity_type',
        'entity_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, string $description, ?string $entityType = null, ?int $entityId = null): self
    {
        $user = Auth::user();

        return self::create([
            'user_id'     => $user?->id,
            'user_name'   => $user?->name ?? 'Guest Visitor',
            'role'        => $user?->role ?? ($user?->roles?->first()?->name ?? 'Public'),
            'action'      => $action,
            'description' => $description,
            'ip_address'  => Request::ip() ?? '127.0.0.1',
            'entity_type' => $entityType,
            'entity_id'   => $entityId,
        ]);
    }
}
