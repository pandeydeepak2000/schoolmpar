<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Enquiry;
use App\Models\User;
use App\Models\Admission;
use App\Models\VisitBooking;
use App\Models\Payment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_schools'    => School::count(),
            'active_schools'   => School::where('status', 'approved')->count(),
            'pending_schools'  => School::where('status', 'pending')->count(),
            'total_enquiries'  => Enquiry::count(),
            'new_enquiries'    => Enquiry::where('status', 'new')->count(),
            'total_admissions' => Admission::count(),
            'pending_adm'      => Admission::where('status', 'pending')->count(),
            'total_visits'     => VisitBooking::count(),
            'pending_visits'   => VisitBooking::where('status', 'pending')->count(),
            'total_users'      => User::count(),
            'total_revenue'    => Payment::whereIn('status', ['success', 'successful'])->sum('amount'),
            'total_logs'       => ActivityLog::count(),
        ];

        $pending_schools  = School::where('status', 'pending')->latest()->take(5)->get();
        $recent_enquiries = Enquiry::with('school')->latest()->take(5)->get();
        $recent_admissions= Admission::with(['school', 'user'])->latest()->take(5)->get();
        $recent_visits    = VisitBooking::with(['school', 'user'])->latest()->take(5)->get();
        $recent_logs      = ActivityLog::latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'stats',
            'pending_schools',
            'recent_enquiries',
            'recent_admissions',
            'recent_visits',
            'recent_logs'
        ));
    }

    public function schools(Request $request)
    {
        $query = School::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name',    'like', '%'.$request->search.'%')
                  ->orWhere('city',  'like', '%'.$request->search.'%')
                  ->orWhere('board', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('board'))  $query->where('board', $request->board);
        if ($request->filled('status')) $query->where('status', $request->status);

        $schools = $query->latest()->paginate(15)->withQueryString();
        return view('admin.schools', compact('schools'));
    }

    public function pendingSchools()
    {
        $schools = School::where('status', 'pending')->latest()->paginate(15);
        return view('admin.pending-schools', compact('schools'));
    }

    public function enquiries(Request $request)
    {
        $query = Enquiry::with(['school', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('parent_name', 'like', '%'.$search.'%')
                  ->orWhere('mobile',      'like', '%'.$search.'%')
                  ->orWhereHas('school', fn($sq) => $sq->where('name', 'like', '%'.$search.'%'));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('type')) {
            if ($request->type === 'brochure') {
                $query->where(function ($q) {
                    $q->where('child_class', 'like', '%brochure%')
                      ->orWhere('message', 'like', '%brochure%')
                      ->orWhere('message', 'like', '%prospectus%');
                });
            } elseif ($request->type === 'admission') {
                $query->where(function ($q) {
                    $q->where('child_class', 'not like', '%brochure%')
                      ->where('message', 'not like', '%brochure%');
                });
            }
        }

        $new_count        = Enquiry::where('status', 'new')->count();
        $contacted_count  = Enquiry::where('status', 'contacted')->count();
        $brochure_count   = Enquiry::where(function($q) {
            $q->where('child_class', 'like', '%brochure%')
              ->orWhere('message', 'like', '%brochure%')
              ->orWhere('message', 'like', '%prospectus%');
        })->count();
        $enquiries        = $query->latest()->paginate(15)->withQueryString();

        return view('admin.enquiries', compact('enquiries', 'new_count', 'contacted_count', 'brochure_count'));
    }

    public function exportEnquiries(Request $request)
    {
        $query = Enquiry::with(['school', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('parent_name', 'like', '%'.$search.'%')
                  ->orWhere('mobile',      'like', '%'.$search.'%')
                  ->orWhereHas('school', fn($sq) => $sq->where('name', 'like', '%'.$search.'%'));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('type')) {
            if ($request->type === 'brochure') {
                $query->where(function ($q) {
                    $q->where('child_class', 'like', '%brochure%')
                      ->orWhere('message', 'like', '%brochure%')
                      ->orWhere('message', 'like', '%prospectus%');
                });
            } elseif ($request->type === 'admission') {
                $query->where(function ($q) {
                    $q->where('child_class', 'not like', '%brochure%')
                      ->where('message', 'not like', '%brochure%');
                });
            }
        }

        $enquiries = $query->latest()->get();
        $filename  = 'enquiries_export_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($enquiries) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'ID',
                'Parent Name',
                'Mobile Number',
                'Email',
                'Target School',
                'Class / Type',
                'Status',
                'Parent Message',
                'CRM Notes & Follow-ups',
                'Received Date',
            ]);

            foreach ($enquiries as $row) {
                $notesSummary = '';
                if (!empty($row->notes_list)) {
                    $lines = [];
                    foreach ($row->notes_list as $n) {
                        $dt = $n['created_at_human'] ?? ($n['created_at'] ?? '');
                        $author = $n['author'] ?? 'Admin';
                        $follow = !empty($n['followup_date']) ? " (Follow-up: {$n['followup_date']})" : '';
                        $lines[] = "[{$dt}] {$author}: {$n['note']}{$follow}";
                    }
                    $notesSummary = implode(" \n", $lines);
                }

                fputcsv($file, [
                    $row->id,
                    $row->parent_name,
                    $row->mobile ?: $row->phone,
                    $row->parent_email ?: ($row->user?->email ?? ''),
                    $row->school?->name ?? 'N/A',
                    $row->is_brochure_request ? 'Brochure Request' : $row->formatted_class,
                    ucfirst($row->status),
                    $row->message,
                    $notesSummary,
                    $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function bulkDeleteEnquiries(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:enquiries,id',
        ]);

        $count = count($request->ids);
        Enquiry::whereIn('id', $request->ids)->delete();

        ActivityLog::record(
            'bulk_delete_enquiries',
            "Admin bulk deleted {$count} enquiry lead(s).",
            'Enquiry',
            null
        );

        return back()->with('success', "✅ Successfully deleted {$count} enquiry record(s).");
    }

    public function addEnquiryNote(Request $request, $id)
    {
        $request->validate([
            'note'          => 'required|string|max:2000',
            'followup_date' => 'nullable|string|max:50',
            'status'        => 'nullable|in:new,contacted,closed',
        ]);

        $enquiry = Enquiry::findOrFail($id);

        if ($request->filled('status')) {
            $enquiry->status = $request->status;
        }

        $newEntry = $enquiry->addAdminNote(
            $request->note,
            $request->followup_date,
            auth()->user()?->name ?? 'Admin'
        );

        ActivityLog::record(
            'add_enquiry_note',
            "Admin added note to enquiry #{$enquiry->id} ({$enquiry->parent_name}): " . \Illuminate\Support\Str::limit($request->note, 80),
            'Enquiry',
            $enquiry->id
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'     => true,
                'message'     => 'Follow-up note logged successfully!',
                'note'        => $newEntry,
                'notes'       => $enquiry->fresh()->notes_list,
                'status'      => $enquiry->status,
                'notes_count' => count($enquiry->fresh()->notes_list),
            ]);
        }

        return back()->with('success', '✅ Follow-up note logged successfully.');
    }


    public function users(Request $request)
    {
        $query = User::with('roles')->withCount(['admissions']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name',  'like', '%'.$request->search.'%')
                  ->orWhere('email','like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('role'))   $query->role($request->role);
        if ($request->filled('status')) {
            $request->status === 'banned'
                ? $query->where('is_banned', true)
                : $query->where('is_banned', false);
        }

        $stats = [
            'total'   => User::count(),
            'parents' => User::role('parent')->count(),
            'owners'  => User::role('school_owner')->count(),
            'banned'  => User::where('is_banned', true)->count(),
        ];

        $users = $query->latest()->paginate(15)->withQueryString();
        return view('admin.users', compact('users', 'stats'));
    }

    // ─── ADMISSIONS ───────────────────────────────────────────
    public function admissions(Request $request)
    {
        $query = Admission::with(['school', 'user']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('student_name', 'like', '%'.$request->search.'%')
                  ->orWhere('application_number', 'like', '%'.$request->search.'%')
                  ->orWhere('parent_name', 'like', '%'.$request->search.'%')
                  ->orWhere('parent_phone', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('status'))    $query->where('status', $request->status);
        if ($request->filled('school_id')) $query->where('school_id', $request->school_id);
        if ($request->filled('class_applying')) $query->where('class_applying', $request->class_applying);

        $stats = [
            'total'    => Admission::count(),
            'pending'  => Admission::where('status', 'pending')->count(),
            'approved' => Admission::where('status', 'approved')->count(),
            'rejected' => Admission::where('status', 'rejected')->count(),
            'paid'     => Admission::whereNotNull('payment_id')->count(),
        ];

        $schools    = School::where('status', 'approved')->pluck('name', 'id');
        $admissions = $query->latest()->paginate(15)->withQueryString();

        return view('admin.admissions', compact('admissions', 'stats', 'schools'));
    }

    // ─── PAYMENTS ─────────────────────────────────────────────
    public function payments(Request $request)
    {
        $query = Payment::with(['user', 'school', 'admission'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('transaction_id', 'like', '%'.$request->search.'%')
                  ->orWhere('gateway_payment_id', 'like', '%'.$request->search.'%')
                  ->orWhereHas('user', function ($uq) use ($request) {
                      $uq->where('name',  'like', '%'.$request->search.'%')
                         ->orWhere('email','like', '%'.$request->search.'%');
                  });
            });
        }

        $payments = $query->paginate(20)->withQueryString();

        $stats = [
            'total'   => Payment::count(),
            'success' => Payment::where('status','success')->count(),
            'pending' => Payment::where('status','pending')->count(),
            'failed'  => Payment::where('status','failed')->count(),
            'revenue' => Payment::where('status','success')->sum('amount'),
        ];

        return view('admin.payments', compact('payments', 'stats'));
    }

    // ─── VISITS ───────────────────────────────────────────────
    public function visits(Request $request)
    {
        $query = VisitBooking::with(['school', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('visitor_name', 'like', '%'.$search.'%')
                  ->orWhere('visitor_phone', 'like', '%'.$search.'%')
                  ->orWhereHas('school', fn($sq) => $sq->where('name', 'like', '%'.$search.'%'));
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('visit_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('visit_date', '<=', $request->to_date);
        }
        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->date);
        }

        $stats = [
            'total'     => VisitBooking::count(),
            'pending'   => VisitBooking::where('status', 'pending')->count(),
            'confirmed' => VisitBooking::where('status', 'confirmed')->count(),
            'completed' => VisitBooking::where('status', 'completed')->count(),
        ];

        $visits = $query->latest()->paginate(15)->withQueryString();

        return view('admin.visits', compact('visits', 'stats'));
    }

    public function exportVisits(Request $request)
    {
        $query = VisitBooking::with(['school', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('visitor_name', 'like', '%'.$search.'%')
                  ->orWhere('visitor_phone', 'like', '%'.$search.'%')
                  ->orWhereHas('school', fn($sq) => $sq->where('name', 'like', '%'.$search.'%'));
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('visit_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('visit_date', '<=', $request->to_date);
        }
        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->date);
        }

        $visits   = $query->latest()->get();
        $filename = 'visits_export_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($visits) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'ID',
                'Visitor Name',
                'Visitor Phone',
                'School Destination',
                'Scheduled Date',
                'Scheduled Time',
                'Status',
                'Visitor Notes / Queries',
                'Cancellation Reason',
                'Created At',
            ]);

            foreach ($visits as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->visitor_name,
                    $row->visitor_phone,
                    $row->school?->name ?? 'N/A',
                    $row->visit_date ? $row->visit_date->format('Y-m-d') : '',
                    $row->visit_time,
                    ucfirst($row->status),
                    $row->notes,
                    $row->cancel_reason,
                    $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function bulkDeleteVisits(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:visit_bookings,id',
        ]);

        $count = count($request->ids);
        VisitBooking::whereIn('id', $request->ids)->delete();

        ActivityLog::record(
            'bulk_delete_visits',
            "Admin bulk deleted {$count} visit bookings.",
            'VisitBooking',
            null
        );

        return back()->with('success', "✅ Successfully deleted {$count} visit booking(s).");
    }


    // ─── ACTIVITY LOGS (AUDIT TRAIL) ──────────────────────────
    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('action', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%')
                  ->orWhere('user_name', 'like', '%'.$request->search.'%')
                  ->orWhere('ip_address', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $stats = [
            'total'     => ActivityLog::count(),
            'schools'   => ActivityLog::where('action', 'like', '%School%')->count(),
            'leads'     => ActivityLog::where('action', 'like', '%Enquiry%')->orWhere('action', 'like', '%Admission%')->count(),
            'security'  => ActivityLog::where('action', 'like', '%Login%')->orWhere('action', 'like', '%Auth%')->count(),
        ];

        $actions = ActivityLog::distinct()->pluck('action')->filter()->values();
        $roles   = ActivityLog::distinct()->pluck('role')->filter()->values();
        $logs    = $query->paginate(25)->withQueryString();

        return view('admin.activity-logs', compact('logs', 'stats', 'actions', 'roles'));
    }
}