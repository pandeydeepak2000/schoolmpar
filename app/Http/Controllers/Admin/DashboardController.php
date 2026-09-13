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
            $query->where(function ($q) use ($request) {
                $q->where('parent_name', 'like', '%'.$request->search.'%')
                  ->orWhere('mobile',      'like', '%'.$request->search.'%')
                  ->orWhereHas('school', fn($sq) => $sq->where('name', 'like', '%'.$request->search.'%'));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
        $brochure_count   = Enquiry::where('child_class', 'like', '%brochure%')->orWhere('message', 'like', '%brochure%')->count();
        $enquiries        = $query->latest()->paginate(15)->withQueryString();

        return view('admin.enquiries', compact('enquiries', 'new_count', 'contacted_count', 'brochure_count'));
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
            $query->where(function($q) use ($request) {
                $q->where('parent_name', 'like', '%'.$request->search.'%')
                  ->orWhere('parent_phone', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date'))   $query->whereDate('visit_date', $request->date);

        $stats = [
            'total'     => VisitBooking::count(),
            'pending'   => VisitBooking::where('status', 'pending')->count(),
            'confirmed' => VisitBooking::where('status', 'confirmed')->count(),
            'completed' => VisitBooking::where('status', 'completed')->count(),
        ];

        $visits = $query->latest()->paginate(15)->withQueryString();

        return view('admin.visits', compact('visits', 'stats'));
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