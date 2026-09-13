<?php

namespace App\Http\Controllers\SchoolOwner;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolOwnerController extends Controller
{
    // ── Dashboard ──────────────────────────────────────────
    public function dashboard()
    {
        $schools   = School::where('owner_id', auth()->id())->get();
        $schoolIds = $schools->pluck('id');

        $pending = $schools->where('status', 'pending')->count();
        $active  = $schools->where('status', 'approved')->count();

        $enquiriesTotal = Enquiry::whereIn('school_id', $schoolIds)->count();
        $enquiriesNew   = Enquiry::whereIn('school_id', $schoolIds)
                            ->where('status', 'new')->count();
        $enquiriesToday = Enquiry::whereIn('school_id', $schoolIds)
                            ->whereDate('created_at', today())->count();

        return view('school-owner.dashboard', compact(
            'schools', 'pending', 'active',
            'enquiriesTotal', 'enquiriesNew', 'enquiriesToday'
        ));
    }

    // ── My Schools List ────────────────────────────────────
public function index()
{
    $schools = School::where('owner_id', auth()->id())
                     ->latest()
                     ->paginate(10);

    $stats = [
        'total'    => School::where('owner_id', auth()->id())->count(),
        'approved' => School::where('owner_id', auth()->id())->where('status', 'approved')->count(),
        'pending'  => School::where('owner_id', auth()->id())->where('status', 'pending')->count(),
        'rejected' => School::where('owner_id', auth()->id())->where('status', 'rejected')->count(),
    ];

    return view('school-owner.schools.index', compact('schools', 'stats'));
}
    // ── Create Form ────────────────────────────────────────
    public function create()
    {
        return view('school-owner.schools.create');
    }

    // ── Store New School ───────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'state'      => 'nullable|string|max:100',
            'district'   => 'nullable|string|max:100',
            'city'       => 'nullable|string|max:100',
            'address'    => 'required|string|max:500',
            'image_url'  => 'nullable|url|max:1000',
            'image_file' => 'nullable|image|max:4096',
            'board'      => 'required|string',
            'medium'     => 'required|string',
            'phone'      => 'required|string|max:50',
            'email'      => 'required|email|max:255',
        ]);

        $bannerPath = null;
        $imageUrl   = $request->image_url;

        $gallery = [];
        if ($request->hasFile('gallery_main_file')) {
            $gallery['main'] = $request->file('gallery_main_file')->store('schools/gallery', 'public');
            $bannerPath = $gallery['main'];
        } elseif ($request->filled('gallery_main_url')) {
            $gallery['main'] = $request->gallery_main_url;
            $imageUrl = $request->gallery_main_url;
        } elseif ($request->hasFile('image_file')) {
            $bannerPath = $request->file('image_file')->store('schools', 'public');
            $gallery['main'] = $bannerPath;
        }

        if ($request->hasFile('gallery_classroom_file')) {
            $gallery['classroom'] = $request->file('gallery_classroom_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_classroom_url')) {
            $gallery['classroom'] = $request->gallery_classroom_url;
        }

        if ($request->hasFile('gallery_activity_file')) {
            $gallery['activity'] = $request->file('gallery_activity_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_activity_url')) {
            $gallery['activity'] = $request->gallery_activity_url;
        }

        if ($request->hasFile('gallery_lab_file')) {
            $gallery['laboratory'] = $request->file('gallery_lab_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_lab_url')) {
            $gallery['laboratory'] = $request->gallery_lab_url;
        }

        if ($request->hasFile('gallery_facilities_file')) {
            $gallery['facilities'] = $request->file('gallery_facilities_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_facilities_url')) {
            $gallery['facilities'] = $request->gallery_facilities_url;
        }

        if ($request->hasFile('gallery_campus_file')) {
            $gallery['campus'] = $request->file('gallery_campus_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_campus_url')) {
            $gallery['campus'] = $request->gallery_campus_url;
        }

        $prospectusPath = null;
        if ($request->hasFile('prospectus_file')) {
            $prospectusPath = $request->file('prospectus_file')->store('schools/prospectus', 'public');
        } elseif ($request->filled('prospectus_url')) {
            $prospectusPath = $request->prospectus_url;
        }

        $state    = $request->state ?: 'Bihar';
        $district = $request->district ?: 'Patna';
        $city     = $request->city ?: $district;

        School::create([
            'name'             => $request->name,
            'slug'             => Str::slug($request->name) . '-' . strtolower(Str::random(5)),
            'state'            => $state,
            'district'         => $district,
            'city'             => $city,
            'address'          => $request->address,
            'image_url'        => $imageUrl,
            'banner_image'     => $bannerPath,
            'gallery_images'   => $gallery,
            'prospectus_path'  => $prospectusPath,
            'description'      => $request->description,
            'board'            => $request->board,
            'medium'           => $request->medium,
            'school_type'      => $request->school_type ?? 'Co-Ed',
            'class_from'       => $request->class_from ?? 1,
            'class_to'         => $request->class_to ?? 12,
            'established_year' => $request->established_year,
            'total_students'   => $request->total_students,
            'principal_name'   => $request->principal_name,
            'affiliation_no'   => $request->affiliation_no,
            'admission_status' => $request->admission_status ?? 'open',
            'seats_available'  => $request->seats_available,
            'admission_fee'    => $request->admission_fee,
            'fee_min'          => $request->fee_min,
            'fee_max'          => $request->fee_max,
            'transport_fee'    => $request->transport_fee,
            'facilities'       => $request->facilities ?? [],
            'phone'            => $request->phone,
            'email'            => $request->email,
            'website'          => $request->website,
            'owner_id'         => auth()->id(),
            'status'           => 'pending',
            'is_claimed'       => true,
            'is_active'        => false,
        ]);

        return redirect()->route('school-owner.schools.index')
                         ->with('success', '✅ School submitted to SchoolMapr! It will go live after admin review.');
    }

    // ── Edit Form ──────────────────────────────────────────
    public function edit($id)
    {
        $school = School::where('id', $id)
                        ->where('owner_id', auth()->id())
                        ->firstOrFail();

        return view('school-owner.schools.edit', compact('school'));
    }

    // ── Update School ──────────────────────────────────────
    public function update(Request $request, $id)
    {
        $school = School::where('id', $id)
                        ->where('owner_id', auth()->id())
                        ->firstOrFail();

        $request->validate([
            'name'       => 'required|string|max:255',
            'state'      => 'nullable|string|max:100',
            'district'   => 'nullable|string|max:100',
            'city'       => 'nullable|string|max:100',
            'address'    => 'required|string|max:500',
            'image_url'  => 'nullable|url|max:1000',
            'image_file' => 'nullable|image|max:4096',
            'board'      => 'required|string',
            'medium'     => 'required|string',
            'phone'      => 'required|string|max:50',
            'email'      => 'required|email|max:255',
        ]);

        $bannerPath = $school->banner_image;
        $imageUrl   = $request->filled('image_url') ? $request->image_url : $school->image_url;

        $gallery = is_array($school->gallery_images) ? $school->gallery_images : [];

        if ($request->hasFile('gallery_main_file')) {
            $gallery['main'] = $request->file('gallery_main_file')->store('schools/gallery', 'public');
            $bannerPath = $gallery['main'];
        } elseif ($request->filled('gallery_main_url')) {
            $gallery['main'] = $request->gallery_main_url;
            $imageUrl = $request->gallery_main_url;
        } elseif ($request->hasFile('image_file')) {
            $bannerPath = $request->file('image_file')->store('schools', 'public');
            $gallery['main'] = $bannerPath;
        }

        if ($request->hasFile('gallery_classroom_file')) {
            $gallery['classroom'] = $request->file('gallery_classroom_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_classroom_url')) {
            $gallery['classroom'] = $request->gallery_classroom_url;
        }

        if ($request->hasFile('gallery_activity_file')) {
            $gallery['activity'] = $request->file('gallery_activity_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_activity_url')) {
            $gallery['activity'] = $request->gallery_activity_url;
        }

        if ($request->hasFile('gallery_lab_file')) {
            $gallery['laboratory'] = $request->file('gallery_lab_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_lab_url')) {
            $gallery['laboratory'] = $request->gallery_lab_url;
        }

        if ($request->hasFile('gallery_facilities_file')) {
            $gallery['facilities'] = $request->file('gallery_facilities_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_facilities_url')) {
            $gallery['facilities'] = $request->gallery_facilities_url;
        }

        if ($request->hasFile('gallery_campus_file')) {
            $gallery['campus'] = $request->file('gallery_campus_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_campus_url')) {
            $gallery['campus'] = $request->gallery_campus_url;
        }

        $prospectusPath = $school->prospectus_path;
        if ($request->hasFile('prospectus_file')) {
            $prospectusPath = $request->file('prospectus_file')->store('schools/prospectus', 'public');
        } elseif ($request->filled('prospectus_url')) {
            $prospectusPath = $request->prospectus_url;
        }

        $state    = $request->state ?: ($school->state ?: 'Bihar');
        $district = $request->district ?: ($school->district ?: 'Patna');
        $city     = $request->city ?: $district;

        $school->update([
            'name'             => $request->name,
            'state'            => $state,
            'district'         => $district,
            'city'             => $city,
            'address'          => $request->address,
            'image_url'        => $imageUrl,
            'banner_image'     => $bannerPath,
            'gallery_images'   => $gallery,
            'prospectus_path'  => $prospectusPath,
            'description'      => $request->description,
            'board'            => $request->board,
            'medium'           => $request->medium,
            'school_type'      => $request->school_type ?? 'Co-Ed',
            'class_from'       => $request->class_from,
            'class_to'         => $request->class_to,
            'established_year' => $request->established_year,
            'total_students'   => $request->total_students,
            'principal_name'   => $request->principal_name,
            'affiliation_no'   => $request->affiliation_no,
            'admission_status' => $request->admission_status ?? 'open',
            'seats_available'  => $request->seats_available,
            'admission_fee'    => $request->admission_fee,
            'fee_min'          => $request->fee_min,
            'fee_max'          => $request->fee_max,
            'transport_fee'    => $request->transport_fee,
            'facilities'       => $request->facilities ?? [],
            'phone'            => $request->phone,
            'email'            => $request->email,
            'website'          => $request->website,
            'status'           => 'pending',
        ]);

        return redirect()->route('school-owner.schools.index')
                         ->with('success', '✅ School updated! Changes will go live after admin review.');
    }

    // ── Delete School ──────────────────────────────────────
    public function destroy($id)
    {
        $school = School::where('id', $id)
                        ->where('owner_id', auth()->id())
                        ->firstOrFail();

        $school->delete();

        return redirect()->route('school-owner.schools.index')
                         ->with('success', '🗑️ School deleted successfully!');
    }

    // ── Enquiries List ─────────────────────────────────────
    public function enquiries(Request $request)
    {
        $schoolIds = School::where('owner_id', auth()->id())->pluck('id');

        $query = Enquiry::whereIn('school_id', $schoolIds)->with('school')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by school
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        $enquiries = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => Enquiry::whereIn('school_id', $schoolIds)->count(),
            'new'       => Enquiry::whereIn('school_id', $schoolIds)->where('status','new')->count(),
            'contacted' => Enquiry::whereIn('school_id', $schoolIds)->where('status','contacted')->count(),
            'replied'   => Enquiry::whereIn('school_id', $schoolIds)->where('status','replied')->count(),
            'closed'    => Enquiry::whereIn('school_id', $schoolIds)->where('status','closed')->count(),
            'today'     => Enquiry::whereIn('school_id', $schoolIds)->whereDate('created_at', today())->count(),
        ];

        $mySchools = School::where('owner_id', auth()->id())->get(['id','name']);

        return view('school-owner.enquiries.index', compact('enquiries', 'stats', 'mySchools'));
    }

    // ── Single Enquiry Detail ──────────────────────────────
    public function enquiryShow($id)
    {
        $schoolIds = School::where('owner_id', auth()->id())->pluck('id');

        $enquiry = Enquiry::whereIn('school_id', $schoolIds)
                          ->with('school')
                          ->findOrFail($id);

        return view('school-owner.enquiries.show', compact('enquiry'));
    }

    // ── Update Enquiry Status (AJAX) ───────────────────────
    public function enquiryUpdateStatus(Request $request, $id)
    {
        $schoolIds = School::where('owner_id', auth()->id())->pluck('id');

        $enquiry = Enquiry::whereIn('school_id', $schoolIds)->findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,contacted,replied,closed',
        ]);

        $enquiry->update(['status' => $request->status]);

        return response()->json(['success' => true, 'status' => $enquiry->status]);
    }

    // ── Campus Payment Ledger ───────────────────────────────
    public function payments()
    {
        $schools   = School::where('owner_id', auth()->id())->get();
        $schoolIds = $schools->pluck('id');

        $payments = \App\Models\Payment::whereIn('school_id', $schoolIds)
                        ->with(['user', 'school', 'admission'])
                        ->latest()
                        ->paginate(15);

        $totalRevenue = \App\Models\Payment::whereIn('school_id', $schoolIds)
                        ->where('status', 'success')
                        ->sum('amount');

        return view('school-owner.payments.index', compact('payments', 'totalRevenue', 'schools'));
    }
}