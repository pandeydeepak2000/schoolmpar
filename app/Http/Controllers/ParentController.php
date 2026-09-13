<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Enquiry;
use App\Models\SavedSchool;
use App\Models\Admission;
use App\Models\VisitBooking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    // ── Parent Dashboard ──────────────────────────────
    public function dashboard()
    {
        $user = Auth::user();

        $savedSchools = SavedSchool::where('user_id', $user->id)
                            ->with('school')
                            ->latest()
                            ->take(6)
                            ->get();

        $enquiries = Enquiry::where('user_id', $user->id)
                        ->with('school')
                        ->latest()
                        ->take(5)
                        ->get();

        // Stats
        $totalSaved        = SavedSchool::where('user_id', $user->id)->count();
        $totalEnquiries    = Enquiry::where('user_id', $user->id)->count();
        $totalAdmissions   = Admission::where('user_id', $user->id)->count();
        $pendingAdmissions = Admission::where('user_id', $user->id)->where('status', 'pending')->count();
        $totalVisits       = VisitBooking::where('user_id', $user->id)->count();
        $pendingVisits     = VisitBooking::where('user_id', $user->id)->where('status', 'pending')->count();

        // Recent Admissions (dashboard card)
        $recentAdmissions = Admission::with('school')
                                ->where('user_id', $user->id)
                                ->latest()
                                ->take(4)
                                ->get();

        // Recent Visits (dashboard card)
        $recentVisits = VisitBooking::with('school')
                            ->where('user_id', $user->id)
                            ->latest()
                            ->take(4)
                            ->get();

        return view('parent.dashboard', compact(
            'user',
            'savedSchools',
            'enquiries',
            'totalSaved',
            'totalEnquiries',
            'totalAdmissions',
            'pendingAdmissions',
            'totalVisits',
            'pendingVisits',
            'recentAdmissions',
            'recentVisits'
        ));
    }

    // ── Saved Schools List ────────────────────────────
    public function saved()
    {
        $savedSchools = SavedSchool::where('user_id', Auth::id())
                            ->with('school')
                            ->latest()
                            ->paginate(12);

        return view('parent.saved', compact('savedSchools'));
    }

    // ── My Enquiries ──────────────────────────────────
    public function enquiries()
    {
        $enquiries = Enquiry::where('user_id', Auth::id())
                        ->with('school')
                        ->latest()
                        ->paginate(10);

        return view('parent.enquiries', compact('enquiries'));
    }

    // ── Compare Redirect ─────────────────────────────
    public function compare()
    {
        return redirect('/compare');
    }

    // ── Save School (POST) ────────────────────────────
    public function save(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $already = SavedSchool::where('user_id', Auth::id())
                              ->where('school_id', $id)
                              ->first();

        if ($already) {
            return response()->json(['message' => 'Already saved', 'saved' => true]);
        }

        SavedSchool::create([
            'user_id'   => Auth::id(),
            'school_id' => $id,
        ]);

        return response()->json(['message' => '❤️ School saved!', 'saved' => true]);
    }

    // ── Unsave School (DELETE) ────────────────────────
    public function unsave(Request $request, $id)
    {
        SavedSchool::where('user_id', Auth::id())
                   ->where('school_id', $id)
                   ->delete();

        return response()->json(['message' => '💔 Removed.', 'saved' => false]);
    }

    // ── My Payment History & Invoices ─────────────────
    public function payments()
    {
        $payments = Payment::where('user_id', Auth::id())
                        ->with(['school', 'admission'])
                        ->latest()
                        ->paginate(10);

        $totalSpent = Payment::where('user_id', Auth::id())
                        ->where('status', 'success')
                        ->sum('amount');

        return view('parent.payments', compact('payments', 'totalSpent'));
    }
}