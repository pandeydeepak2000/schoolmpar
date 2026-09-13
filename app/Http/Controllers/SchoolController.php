<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SavedSchool;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    // ── Home Page — School Listing ──────────────────────────────
    public function index(Request $request)
    {
        $query = School::whereIn('status', ['approved', 'active'])->where('is_active', true);

        if ($request->q) {
            $qTerm = trim($request->q);
            $query->where(function ($q) use ($qTerm) {
                $q->where('name', 'like', '%' . $qTerm . '%')
                  ->orWhere('address', 'like', '%' . $qTerm . '%')
                  ->orWhere('city', 'like', '%' . $qTerm . '%')
                  ->orWhere('district', 'like', '%' . $qTerm . '%')
                  ->orWhere('board', 'like', '%' . $qTerm . '%')
                  ->orWhere('facilities', 'like', '%' . $qTerm . '%');

                if (strtolower($qTerm) === 'open' || strtolower($qTerm) === 'admission open') {
                    $q->orWhere('admission_status', 'open');
                }
                if (strtolower($qTerm) === 'verified') {
                    $q->orWhere('is_verified', true);
                }
                if (strtolower($qTerm) === 'girls') {
                    $q->orWhere('school_type', 'Girls');
                }
                if (strtolower($qTerm) === 'boys') {
                    $q->orWhere('school_type', 'Boys');
                }
                if (strtolower($qTerm) === 'co-ed' || strtolower($qTerm) === 'coed') {
                    $q->orWhere('school_type', 'Co-Ed');
                }
            });
        }

        // Locality filter
        if ($request->locality) {
            $loc = trim($request->locality);
            $query->where(function($q) use ($loc) {
                $q->where('city', 'like', '%'.$loc.'%')
                  ->orWhere('address', 'like', '%'.$loc.'%')
                  ->orWhere('district', 'like', '%'.$loc.'%');
            });
        }

        if ($request->state)       $query->where('state', $request->state);
        if ($request->district)    $query->where(function($q) use ($request) {
            $q->where('district', $request->district)->orWhere('city', $request->district);
        });
        if ($request->city)        $query->where('city', $request->city);
        if ($request->board)       $query->where('board', $request->board);
        if ($request->medium)      $query->where('medium', $request->medium);
        if ($request->school_type) $query->where('school_type', $request->school_type);
        if ($request->featured)    $query->where('is_featured', true);
        if ($request->verified)    $query->where('is_verified', true);
        if ($request->admission)   $query->where('admission_status', $request->admission);

        // Grade / Class filter
        if ($request->grade) {
            $g = (int)$request->grade;
            $query->where('class_from', '<=', $g)->where('class_to', '>=', $g);
        }
        if ($request->class_from)  $query->where('class_to', '>=', (int)$request->class_from);
        if ($request->class_to)    $query->where('class_from', '<=', (int)$request->class_to);

        // Budget tier filter
        if ($request->budget) {
            match ($request->budget) {
                'under_40k'  => $query->where(function($q) { $q->where('fee_min', '<=', 40000)->orWhereNull('fee_min'); }),
                '40k_70k'   => $query->where('fee_min', '<=', 75000)->where('fee_max', '>=', 35000),
                '70k_100k'  => $query->where('fee_min', '<=', 105000)->where('fee_max', '>=', 65000),
                'above_100k' => $query->where('fee_max', '>=', 90000),
                default      => null,
            };
        }

        if ($request->fee_min)     $query->where('fee_min', '>=', $request->fee_min);
        if ($request->fee_max)     $query->where('fee_max', '<=', $request->fee_max);

        // Facility filters
        if ($request->facility) {
            $facs = is_array($request->facility) ? $request->facility : explode(',', $request->facility);
            foreach ($facs as $fac) {
                $fac = trim($fac);
                if (!empty($fac)) {
                    $query->where('facilities', 'like', '%'.$fac.'%');
                }
            }
        }

        // Min rating filter
        if ($request->rating) {
            $r = (float)$request->rating;
            $query->where('rating', '>=', $r);
        }

        $sort = $request->sort ?? 'featured';
        match ($sort) {
            'fee_asc'  => $query->orderBy('fee_min', 'asc'),
            'fee_desc' => $query->orderBy('fee_min', 'desc'),
            'rating'   => $query->orderBy('rating', 'desc'),
            'newest'   => $query->latest(),
            default    => $query->orderBy('is_featured', 'desc')
                                ->orderBy('is_verified', 'desc')
                                ->latest(),
        };

        // All matched schools for interactive Map View
        $allMatchedForMap = (clone $query)->get(['id', 'name', 'slug', 'city', 'address', 'latitude', 'longitude', 'fee_min', 'fee_max', 'board', 'rating', 'admission_status', 'image_url', 'banner_image', 'gallery_images']);
        $mapSchools = $allMatchedForMap->map(function ($s) {
            return [
                'id'               => $s->id,
                'name'             => $s->name,
                'slug'             => $s->slug,
                'city'             => $s->city ?? 'Patna',
                'address'          => $s->address ?? '',
                'lat'              => (float)($s->latitude ?? 25.5941),
                'lng'              => (float)($s->longitude ?? 85.1376),
                'fee_min'          => (int)($s->fee_min ?? 0),
                'fee_max'          => (int)($s->fee_max ?? 0),
                'board'            => $s->board ?? 'CBSE',
                'rating'           => number_format((float)($s->rating ?? 4.5), 1),
                'admission_status' => $s->admission_status ?? 'open',
                'image'            => $s->featured_image_url,
                'url'              => route('school.show', $s->slug),
            ];
        });

        $schools = $query->paginate(12)->withQueryString();

        $savedIds = collect();
        if (auth()->check()) {
            $savedIds = SavedSchool::where('user_id', auth()->id())
                                   ->pluck('school_id');
        }

        // Facet Counts
        $totalApprovedCount = School::whereIn('status', ['approved', 'active'])->where('is_active', true)->count();
        $cbseCount = School::whereIn('status', ['approved', 'active'])->where('is_active', true)->where('board', 'CBSE')->count();
        $icseCount = School::whereIn('status', ['approved', 'active'])->where('is_active', true)->where('board', 'ICSE')->count();
        $openCount = School::whereIn('status', ['approved', 'active'])->where('is_active', true)->where('admission_status', 'open')->count();
        $verifiedCount = School::whereIn('status', ['approved', 'active'])->where('is_active', true)->where('is_verified', true)->count();

        $patnaLocalities = [
            'Kankarbagh', 'Boring Road', 'Bailey Road', 'Danapur', 'Rajendra Nagar',
            'Saguna More', 'Patliputra', 'Ashiana Nagar', 'Gandhi Maidan', 'Kurji',
            'Kumhrar', 'Gola Road', 'Raja Bazar', 'Anisabad', 'Khagaul', 'BSEB Colony'
        ];

        return view('schools.index', compact(
            'schools', 'savedIds', 'mapSchools', 'totalApprovedCount',
            'cbseCount', 'icseCount', 'openCount', 'verifiedCount', 'patnaLocalities'
        ));
    }

    // ── School Detail Page ──────────────────────────────────────
    public function show($slug)
    {
        $school = School::where('slug', $slug)
                        ->whereIn('status', ['approved', 'active'])
                        ->where('is_active', true)
                        ->firstOrFail();

        $isSaved = false;
        if (auth()->check()) {
            $isSaved = SavedSchool::where('user_id', auth()->id())
                                  ->where('school_id', $school->id)
                                  ->exists();
        }

        return view('schools.show', compact('school', 'isSaved'));
    }

    // ── Official Printable School Summary Sheet ────────────────────────
    public function printSummary($slug)
    {
        if (!auth()->check()) {
            return redirect()->guest(route('login'))
                             ->with('error', '🔒 Please sign in to view and print the verified school fee structure & summary.');
        }

        $school = School::where('slug', $slug)
                        ->whereIn('status', ['approved', 'active'])
                        ->where('is_active', true)
                        ->firstOrFail();

        return view('schools.print-summary', compact('school'));
    }

    // ── School JSON — For Compare Page ─────────────────────────
    public function json($slug)
    {
        $school = School::where('slug', $slug)
                        ->whereIn('status', ['approved', 'active'])
                        ->where('is_active', true)
                        ->firstOrFail();

        return response()->json($this->schoolComparePayload($school));
    }

    // ── School JSON by ID — Compare Page ke liye ───────────────
    public function jsonById($id)
    {
        $school = School::where('id', $id)
                        ->whereIn('status', ['approved', 'active'])
                        ->where('is_active', true)
                        ->firstOrFail();

        return response()->json($this->schoolComparePayload($school));
    }

    // ── Shared Compare Payload ─────────────────────────────────
    private function schoolComparePayload(School $school): array
    {
        return [
            'id'               => $school->id,
            'name'             => $school->name,
            'slug'             => $school->slug,
            'board'            => $school->board,
            'medium'           => $school->medium,
            'city'             => $school->city ?? $school->district ?? 'Patna',
            'district'         => $school->district ?? $school->city ?? 'Patna',
            'state'            => $school->state ?? 'Bihar',
            'address'          => $school->address,
            'image_url'        => $school->featured_image_url,
            'class_from'       => $school->class_from,
            'class_to'         => $school->class_to,
            'fee_min'          => $school->fee_min,
            'fee_max'          => $school->fee_max,
            'is_verified'      => $school->is_verified,
            'is_featured'      => $school->is_featured,
            'admission_status' => $school->admission_status ?? 'open',
            'phone'            => $school->phone,
            'email'            => $school->email,
            'facilities'       => $school->facilities,
            'school_type'      => $school->school_type ?? 'Co-Ed',
            'principal_name'   => $school->principal_name,
            'affiliation_no'   => $school->affiliation_no,
            'total_students'   => $school->total_students,
            'seats_available'  => $school->seats_available,
            'transport_fee'    => $school->transport_fee,
            'admission_fee'    => $school->admission_fee,
        ];
    }

    // ── Toggle Save / Unsave ────────────────────────────────────
    public function toggleSave(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json([
                'error'    => 'Login karo pehle!',
                'redirect' => route('login'),
            ], 401);
        }

        $school   = School::findOrFail($id);
        $userId   = auth()->id();
        $existing = SavedSchool::where('user_id', $userId)
                               ->where('school_id', $school->id)
                               ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['saved' => false, 'message' => '💔 School removed!']);
        }

        SavedSchool::create(['user_id' => $userId, 'school_id' => $school->id]);

        return response()->json(['saved' => true, 'message' => '❤️ School saved successfully!']);
    }
}