<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Enquiry;
use App\Models\Admission;
use App\Models\VisitBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SchoolManageController extends Controller
{
    // ─────────────────────────────────────────
    // All Schools List (with filters)
    // ─────────────────────────────────────────
    public function index(Request $request)
    {
        $query = School::with('owner')
            ->withCount(['admissions', 'visitBookings']);

        // Search: name ya city
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }

        // Alphabet filter
        if ($request->filled('letter')) {
            $query->where('name', 'like', $request->letter . '%');
        }

        // Board filter
        if ($request->filled('board')) {
            $query->where('board', $request->board);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', 'approved')->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('status', 'inactive')->orWhere('is_active', false);
            } else {
                $query->where('status', $request->status);
            }
        }

        // City filter
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Owner filter
       if ($request->filled('owner')) {
    $request->owner === 'has'
        ? $query->whereNotNull('owner_id')
        : $query->whereNull('owner_id');
}

        $schools = $query->latest()->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total'    => School::count(),
            'approved' => School::where('status', 'approved')->count(),
            'pending'  => School::where('status', 'pending')->count(),
            'no_owner' => School::whereNull('owner_id')->count(),
        ];

        // Filter dropdown data
        $cities = School::distinct()->orderBy('city')->pluck('city')->filter()->values();

        return view('admin.schools', compact('schools', 'stats', 'cities'));
    }

    // ─────────────────────────────────────────
    // Manage Single School Page — 360° Parent Dossier
    // ─────────────────────────────────────────
    public function manage($id)
    {
        $school = School::with('owner')->findOrFail($id);

        $admissions = Admission::with('user')
            ->where('school_id', $id)
            ->latest()
            ->paginate(10, ['*'], 'adm_page');

        $visits = VisitBooking::with('user')
            ->where('school_id', $id)
            ->latest()
            ->paginate(10, ['*'], 'vis_page');

        $enquiries = Enquiry::where('school_id', $id)
            ->latest()
            ->paginate(10, ['*'], 'enq_page');

        $payments = \App\Models\Payment::with(['user', 'admission'])
            ->where('school_id', $id)
            ->latest()
            ->paginate(10, ['*'], 'pay_page');

        $stats = [
            'total_admissions'    => Admission::where('school_id', $id)->count(),
            'pending_admissions'  => Admission::where('school_id', $id)->where('status', 'pending')->count(),
            'total_visits'        => VisitBooking::where('school_id', $id)->count(),
            'today_visits'        => VisitBooking::where('school_id', $id)->whereDate('visit_date', today())->count(),
            'total_enquiries'     => Enquiry::where('school_id', $id)->count(),
            'total_collections'   => \App\Models\Payment::where('school_id', $id)->where('status', 'successful')->sum('amount'),
        ];

        return view('admin.manage-school', compact('school', 'admissions', 'visits', 'enquiries', 'payments', 'stats'));
    }

    public function exportParents($id)
    {
        $school = School::findOrFail($id);
        $admissions = Admission::where('school_id', $id)->get();
        $visits     = VisitBooking::where('school_id', $id)->get();
        $enquiries  = Enquiry::where('school_id', $id)->get();

        $filename = "parents-dossier-" . $school->slug . "-" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Parent Name', 'Mobile / Phone', 'Email / Student', 'Interest Type', 'Class', 'Status', 'Date'];

        $callback = function() use($admissions, $visits, $enquiries, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($admissions as $adm) {
                fputcsv($file, [$adm->parent_name, $adm->parent_phone, 'Student: '.$adm->student_name, 'Admission Application', $adm->class_applying, $adm->status, $adm->created_at->format('Y-m-d H:i')]);
            }
            foreach ($visits as $vis) {
                fputcsv($file, [$vis->visitor_name, $vis->visitor_phone, 'Visit Booking', 'Campus Visit Tour', '—', $vis->status, $vis->created_at->format('Y-m-d H:i')]);
            }
            foreach ($enquiries as $enq) {
                fputcsv($file, [$enq->parent_name, $enq->mobile, $enq->message, 'General Enquiry / Prospectus', $enq->child_class, $enq->status, $enq->created_at->format('Y-m-d H:i')]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ─────────────────────────────────────────
    // School Approve
    // ─────────────────────────────────────────
    public function approve($id)
    {
        School::findOrFail($id)->update([
            'status'      => 'approved',
            'is_active'   => true,
            'is_verified' => true,
        ]);
        return back()->with('success', '✅ School approved & live!');
    }

    // ─────────────────────────────────────────
    // School Reject
    // ─────────────────────────────────────────
    public function reject($id)
    {
        School::findOrFail($id)->update([
            'status'    => 'rejected',
            'is_active' => false,
        ]);
        return back()->with('success', '❌ School rejected.');
    }

    // ─────────────────────────────────────────
    // Toggle Active / Inactive
    // ─────────────────────────────────────────
    public function toggle($id)
    {
        $school = School::findOrFail($id);

        $newStatus   = ($school->status === 'approved') ? 'inactive' : 'approved';
        $newIsActive = ($newStatus === 'approved');

        $school->update([
            'status'    => $newStatus,
            'is_active' => $newIsActive,
        ]);

        return back()->with('success', 'School status updated to ' . ucfirst($newStatus) . '.');
    }

    // ─────────────────────────────────────────
    // Enquiry Status Update
    // ─────────────────────────────────────────
    public function updateEnquiry($id)
    {
        Enquiry::findOrFail($id)->update([
            'status' => request('status'),
        ]);
        return back()->with('success', '✅ Enquiry status updated.');
    }

    // ─────────────────────────────────────────
    // Send Official Brochure / Admission Packet to Parent Email
    // ─────────────────────────────────────────
    public function sendBrochure(Request $request, $id)
    {
        $enquiry = Enquiry::with(['school.owner', 'user'])->findOrFail($id);
        $school  = $enquiry->school;

        $request->validate([
            'email'         => 'required|email|max:255',
            'message'       => 'nullable|string|max:1000',
            'brochure_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:15360',
        ]);

        $uploadedFilePath = null;
        $uploadedFileName = null;

        if ($request->hasFile('brochure_file')) {
            $file = $request->file('brochure_file');
            $path = $file->store('schools/prospectus', 'public');
            $uploadedFilePath = storage_path('app/public/' . $path);
            $uploadedFileName = $file->getClientOriginalName();

            // If school doesn't have a saved prospectus yet, save this uploaded file as official prospectus
            if (!$school->prospectus_path) {
                $school->update(['prospectus_path' => $path]);
            }
        }

        try {
            \App\Services\DynamicMailConfig::apply();

            \Illuminate\Support\Facades\Mail::to($request->email)->send(
                new \App\Mail\SchoolBrochureMail(
                    school: $school,
                    parentName: $enquiry->parent_name ?: 'Parent',
                    customMessage: $request->message,
                    uploadedFilePath: $uploadedFilePath,
                    uploadedFileName: $uploadedFileName
                )
            );

            $enquiry->update(['status' => 'contacted']);

            return back()->with('success', "✅ School Brochure and admission packet emailed successfully with attachment to {$request->email}!");
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Admin send brochure mail error: ' . $e->getMessage());
            return back()->with('error', '❌ Could not send brochure email: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────
    // Assign Owner to School
    // ─────────────────────────────────────────
    public function assignOwner(Request $request, $id)
    {
        $request->validate([
            'owner_name'  => 'required|string|max:100',
            'owner_email' => 'required|email|unique:users,email',
            'owner_phone' => 'nullable|string|max:15',
        ]);

        $school = School::findOrFail($id);

        // Create new user with school_owner role
        $user = User::create([
            'name'     => $request->owner_name,
            'email'    => $request->owner_email,
            'phone'    => $request->owner_phone,
            'password' => Hash::make('School@123'),
            'role'     => 'school_owner',  // agar role column hai table me
        ]);

        // Spatie ka use karte ho to ye bhi add karo:
        // $user->assignRole('school_owner');

        $school->update(['owner_id' => $user->id]);

        return back()->with('success',
            "✅ Owner assigned! Email: {$request->owner_email} | Password: School@123"
        );
    }

    // ─────────────────────────────────────────
    // Admission Actions (Admin — No Owner School)
    // ─────────────────────────────────────────
    public function approveAdmission($schoolId, $id)
    {
        Admission::where('school_id', $schoolId)->findOrFail($id)
            ->update(['status' => 'approved']);
        return back()->with('success', '✅ Admission approved!');
    }

    public function rejectAdmission($schoolId, $id)
    {
        Admission::where('school_id', $schoolId)->findOrFail($id)
            ->update(['status' => 'rejected']);
        return back()->with('success', '❌ Admission rejected.');
    }

    public function reviewAdmission($schoolId, $id)
    {
        Admission::where('school_id', $schoolId)->findOrFail($id)
            ->update(['status' => 'reviewing']);
        return back()->with('success', '🔍 Marked as under review.');
    }

    // ─────────────────────────────────────────
    // Visit Actions (Admin — No Owner School)
    // ─────────────────────────────────────────
    public function confirmVisit($schoolId, $id)
    {
        VisitBooking::where('school_id', $schoolId)->findOrFail($id)
            ->update(['status' => 'confirmed']);
        return back()->with('success', '✅ Visit confirmed!');
    }

    public function cancelVisit($schoolId, $id)
    {
        VisitBooking::where('school_id', $schoolId)->findOrFail($id)
            ->update([
                'status'        => 'cancelled',
                'cancel_reason' => 'Cancelled by admin',
            ]);
        return back()->with('success', '❌ Visit cancelled.');
    }

    public function completeVisit($schoolId, $id)
    {
        VisitBooking::where('school_id', $schoolId)->findOrFail($id)
            ->update(['status' => 'completed']);
        return back()->with('success', '🏁 Visit marked as completed!');
    }
}