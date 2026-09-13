<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolCrudController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.schools');
    }

    public function show(School $schoolsManage)
    {
        return redirect()->route('admin.schools.manage', $schoolsManage->id);
    }

    public function create()
    {
        return view('admin.schools-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'state'                => 'nullable|string|max:100',
            'district'             => 'nullable|string|max:100',
            'city'                 => 'nullable|string|max:100',
            'address'              => 'required|string|max:500',
            'image_url'            => 'nullable|url|max:1000',
            'image_file'           => 'nullable|image|max:4096',
            'board'                => 'required|in:CBSE,ICSE,State Board,IB,IGCSE',
            'medium'               => 'required|string|max:50',
            'class_from'           => 'required|integer|min:1|max:12',
            'class_to'             => 'required|integer|min:1|max:12',
            'fee_min'              => 'nullable|numeric|min:0',
            'fee_max'              => 'nullable|numeric|min:0',
            'phone'                => 'nullable|string|max:50',
            'email'                => 'nullable|email|max:100',
            'website'              => 'nullable|url|max:255',
            'description'          => 'nullable|string',
            'status'               => 'required|in:approved,inactive,pending,rejected',
            'admission_status'     => 'required|in:open,closed,coming_soon',
            'admission_open_date'  => 'nullable|date',
            'admission_close_date' => 'nullable|date',
            'seats_available'      => 'nullable|integer|min:0',
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

        if ($request->hasFile('gallery_lab_file')) {
            $gallery['laboratory'] = $request->file('gallery_lab_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_lab_url')) {
            $gallery['laboratory'] = $request->gallery_lab_url;
        }

        if ($request->hasFile('gallery_activity_file')) {
            $gallery['activity'] = $request->file('gallery_activity_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_activity_url')) {
            $gallery['activity'] = $request->gallery_activity_url;
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
            'name'                 => $request->name,
            'slug'                 => Str::slug($request->name).'-'.strtolower(Str::random(5)),
            'state'                => $state,
            'district'             => $district,
            'city'                 => $city,
            'address'              => $request->address,
            'image_url'            => $imageUrl,
            'banner_image'         => $bannerPath,
            'gallery_images'       => $gallery,
            'prospectus_path'      => $prospectusPath,
            'description'          => $request->description,
            'board'                => $request->board,
            'medium'               => $request->medium,
            'school_type'          => $request->school_type ?? 'Co-Ed',
            'class_from'           => $request->class_from,
            'class_to'             => $request->class_to,
            'established_year'     => $request->established_year,
            'total_students'       => $request->total_students,
            'principal_name'       => $request->principal_name,
            'affiliation_no'       => $request->affiliation_no,
            'fee_min'              => $request->fee_min,
            'fee_max'              => $request->fee_max,
            'admission_fee'        => $request->admission_fee,
            'transport_fee'        => $request->transport_fee,
            'facilities'           => $request->facilities ?? [],
            'phone'                => $request->phone,
            'email'                => $request->email,
            'website'              => $request->website,
            'status'               => $request->status,
            'is_active'            => $request->status === 'approved',
            'is_verified'          => $request->boolean('is_verified'),
            'is_featured'          => $request->boolean('is_featured'),
            'admission_status'     => $request->admission_status,
            'admission_open_date'  => $request->admission_open_date,
            'admission_close_date' => $request->admission_close_date,
            'seats_available'      => $request->seats_available,
        ]);

        return redirect()->route('admin.schools')
                         ->with('success', '✅ School added successfully to SchoolMapr!');
    }

    public function edit(School $schoolsManage)
    {
        return view('admin.schools-edit', ['school' => $schoolsManage]);
    }

    public function update(Request $request, School $schoolsManage)
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'state'                => 'nullable|string|max:100',
            'district'             => 'nullable|string|max:100',
            'city'                 => 'nullable|string|max:100',
            'address'              => 'required|string|max:500',
            'image_url'            => 'nullable|url|max:1000',
            'image_file'           => 'nullable|image|max:4096',
            'board'                => 'required|in:CBSE,ICSE,State Board,IB,IGCSE',
            'medium'               => 'required|string|max:50',
            'class_from'           => 'required|integer|min:1|max:12',
            'class_to'             => 'required|integer|min:1|max:12',
            'fee_min'              => 'nullable|numeric|min:0',
            'fee_max'              => 'nullable|numeric|min:0',
            'phone'                => 'nullable|string|max:50',
            'email'                => 'nullable|email|max:100',
            'website'              => 'nullable|url|max:255',
            'description'          => 'nullable|string',
            'status'               => 'required|in:approved,inactive,pending,rejected',
            'admission_status'     => 'required|in:open,closed,coming_soon',
            'admission_open_date'  => 'nullable|date',
            'admission_close_date' => 'nullable|date',
            'seats_available'      => 'nullable|integer|min:0',
        ]);

        $bannerPath = $schoolsManage->banner_image;
        $imageUrl   = $request->filled('image_url') ? $request->image_url : $schoolsManage->image_url;

        $gallery = is_array($schoolsManage->gallery_images) ? $schoolsManage->gallery_images : [];

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

        if ($request->hasFile('gallery_lab_file')) {
            $gallery['laboratory'] = $request->file('gallery_lab_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_lab_url')) {
            $gallery['laboratory'] = $request->gallery_lab_url;
        }

        if ($request->hasFile('gallery_activity_file')) {
            $gallery['activity'] = $request->file('gallery_activity_file')->store('schools/gallery', 'public');
        } elseif ($request->filled('gallery_activity_url')) {
            $gallery['activity'] = $request->gallery_activity_url;
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

        $prospectusPath = $schoolsManage->prospectus_path;
        if ($request->hasFile('prospectus_file')) {
            $prospectusPath = $request->file('prospectus_file')->store('schools/prospectus', 'public');
        } elseif ($request->filled('prospectus_url')) {
            $prospectusPath = $request->prospectus_url;
        }

        $state    = $request->state ?: ($schoolsManage->state ?: 'Bihar');
        $district = $request->district ?: ($schoolsManage->district ?: 'Patna');
        $city     = $request->city ?: $district;

        $schoolsManage->update([
            'name'                 => $request->name,
            'state'                => $state,
            'district'             => $district,
            'city'                 => $city,
            'address'              => $request->address,
            'image_url'            => $imageUrl,
            'banner_image'         => $bannerPath,
            'gallery_images'       => $gallery,
            'prospectus_path'      => $prospectusPath,
            'description'          => $request->description,
            'board'                => $request->board,
            'medium'               => $request->medium,
            'school_type'          => $request->school_type ?? $schoolsManage->school_type,
            'class_from'           => $request->class_from,
            'class_to'             => $request->class_to,
            'established_year'     => $request->established_year,
            'total_students'       => $request->total_students,
            'principal_name'       => $request->principal_name,
            'affiliation_no'       => $request->affiliation_no,
            'fee_min'              => $request->fee_min,
            'fee_max'              => $request->fee_max,
            'admission_fee'        => $request->admission_fee,
            'transport_fee'        => $request->transport_fee,
            'facilities'           => $request->facilities ?? [],
            'phone'                => $request->phone,
            'email'                => $request->email,
            'website'              => $request->website,
            'status'               => $request->status,
            'is_active'            => $request->status === 'approved',
            'is_verified'          => $request->boolean('is_verified'),
            'is_featured'          => $request->boolean('is_featured'),
            'admission_status'     => $request->admission_status,
            'admission_open_date'  => $request->admission_open_date,
            'admission_close_date' => $request->admission_close_date,
            'seats_available'      => $request->seats_available,
        ]);

        return redirect()->route('admin.schools')
                         ->with('success', '✅ School details and images updated successfully!');
    }

    public function destroy(School $schoolsManage)
    {
        $schoolsManage->delete();
        return redirect()->route('admin.schools')
                         ->with('success', '🗑️ School deleted successfully.');
    }
}