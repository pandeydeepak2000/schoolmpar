<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'city', 'state', 'district', 'address', 'description',
        'image_url', 'banner_image', 'gallery_images', 'prospectus_path', 'latitude', 'longitude',
        'board', 'medium', 'school_type', 'class_from', 'class_to',
        'established_year', 'total_students', 'principal_name', 'affiliation_no',
        'admission_status', 'seats_available', 'admission_fee',
        'fee_min', 'fee_max', 'transport_fee', 'facilities',
        'phone', 'email', 'website',
        'owner_id', 'status', 'is_active', 'is_claimed',
        'is_verified', 'is_featured',
    ];

    public function getProspectusUrlAttribute(): ?string
    {
        if (!$this->prospectus_path) {
            return null;
        }
        if (str_starts_with($this->prospectus_path, 'http://') || str_starts_with($this->prospectus_path, 'https://')) {
            return $this->prospectus_path;
        }
        return asset('storage/' . $this->prospectus_path);
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        $g = is_array($this->gallery_images) ? $this->gallery_images : [];
        if (!empty($g['main'])) {
            return $this->resolveMediaUrl($g['main']);
        }
        if ($this->banner_image) {
            return $this->resolveMediaUrl($this->banner_image);
        }
        if ($this->image_url) {
            return $this->resolveMediaUrl($this->image_url);
        }
        return 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=1200&q=80';
    }

    public function getGalleryListAttribute(): array
    {
        $g = is_array($this->gallery_images) ? $this->gallery_images : [];

        return [
            'main'       => $this->resolveMediaUrl($g['main'] ?? null) ?: $this->featured_image_url,
            'classroom'  => $this->resolveMediaUrl($g['classroom'] ?? null) ?: 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=1200&q=80',
            'activity'   => $this->resolveMediaUrl($g['activity'] ?? null) ?: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1200&q=80',
            'laboratory' => $this->resolveMediaUrl($g['laboratory'] ?? null) ?: 'https://images.unsplash.com/photo-1513258496099-48168024aec0?auto=format&fit=crop&w=1200&q=80',
            'facilities' => $this->resolveMediaUrl($g['facilities'] ?? null) ?: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1200&q=80',
            'campus'     => $this->resolveMediaUrl($g['campus'] ?? null) ?: 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1200&q=80',
        ];
    }

    public function resolveMediaUrl(?string $val): ?string
    {
        if (!$val) return null;
        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }
        return asset('storage/' . $val);
    }

    protected $casts = [
        'facilities'           => 'array',
        'gallery_images'       => 'array',
        'is_verified'          => 'boolean',
        'is_featured'          => 'boolean',
        'is_active'            => 'boolean',
        'is_claimed'           => 'boolean',
        'admission_open_date'  => 'date',
        'admission_close_date' => 'date',
    ];

    // ── Relations ───────────────────────────────────────

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    public function savedByUsers()
    {
        return $this->hasMany(SavedSchool::class);
    }

    public function visitBookings()
    {
        return $this->hasMany(VisitBooking::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // ── Scoped relations (count ke liye useful) ─────────

    public function pendingVisits()
    {
        return $this->hasMany(VisitBooking::class)->where('status', 'pending');
    }

    public function pendingAdmissions()
    {
        return $this->hasMany(Admission::class)->where('status', 'pending');
    }
}