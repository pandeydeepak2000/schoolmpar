<?php

namespace App\Http\Controllers;

use App\Models\VisitBooking;
use App\Models\School;
use Illuminate\Http\Request;

class VisitBookingController extends Controller
{
    // Parent — Book Visit Form
    public function create($slug)
    {
        $school = School::where('slug', $slug)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->firstOrFail();

        return view('visit.book', compact('school'));
    }

    // Parent — Submit Visit Booking
    public function store(Request $request, $slug)
    {
        $school = School::where('slug', $slug)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->firstOrFail();

        $request->validate([
            'visitor_name'  => 'required|string|max:100',
            'visitor_phone' => 'required|string|max:15',
            'visit_date'    => 'required|date|after:today',
            'visit_time'    => 'required|string|max:20',
            'notes'         => 'nullable|string|max:500',
        ]);

        $already = VisitBooking::where('user_id', auth()->id())
            ->where('school_id', $school->id)
            ->where('visit_date', $request->visit_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($already) {
            return back()->with('error', 'You already have a visit booked on this date.');
        }

        $booking = VisitBooking::create([
            'user_id'       => auth()->id(),
            'school_id'     => $school->id,
            'visitor_name'  => $request->visitor_name,
            'visitor_phone' => $request->visitor_phone,
            'visit_date'    => $request->visit_date,
            'visit_time'    => $request->visit_time,
            'notes'         => $request->notes,
            'status'        => 'pending',
        ]);

        return redirect()
            ->route('visit.confirmation', $booking->id)
            ->with('success', 'Visit booked successfully!');
    }

    // Parent — Booking Confirmation
    public function confirmation($id)
    {
        $booking = VisitBooking::with('school')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('visit.confirmation', compact('booking'));
    }

    // Parent — My Visits
    public function myVisits()
    {
        $visits = VisitBooking::with('school')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('parent.visits', compact('visits'));
    }

    // Parent — Cancel Visit
    public function cancel(Request $request, $id)
    {
        $booking = VisitBooking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending visits can be cancelled.');
        }

        $booking->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->reason ?? 'Cancelled by user',
        ]);

        return back()->with('success', 'Visit cancelled successfully.');
    }

    // 🏫 School Owner — All Visit Requests
    public function schoolVisits(Request $request)
    {
        // 🔥 FIX: multiple schools support
        $schoolIds = auth()->user()->schools()->pluck('id');

        $query = VisitBooking::with('user')
            ->whereIn('school_id', $schoolIds);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->where('visit_date', $request->date);
        }

        $visits = $query->latest()->paginate(15);

        // 🔥 FIX: stats also correct
        $stats = [
            'total'     => VisitBooking::whereIn('school_id', $schoolIds)->count(),
            'pending'   => VisitBooking::whereIn('school_id', $schoolIds)->where('status', 'pending')->count(),
            'confirmed' => VisitBooking::whereIn('school_id', $schoolIds)->where('status', 'confirmed')->count(),
            'completed' => VisitBooking::whereIn('school_id', $schoolIds)->where('status', 'completed')->count(),
        ];

        // for UI
        $school = auth()->user()->schools()->first();

        return view('school-owner.visits', compact('visits', 'stats', 'school'));
    }

    // School Owner — Confirm Visit
    public function confirm($id)
    {
        $schoolIds = auth()->user()->schools()->pluck('id');

        $booking = VisitBooking::where('id', $id)
            ->whereIn('school_id', $schoolIds)
            ->firstOrFail();

        $booking->update(['status' => 'confirmed']);

        return back()->with('success', 'Visit confirmed successfully.');
    }

    // School Owner — Reject Visit
    public function reject(Request $request, $id)
    {
        $schoolIds = auth()->user()->schools()->pluck('id');

        $booking = VisitBooking::where('id', $id)
            ->whereIn('school_id', $schoolIds)
            ->firstOrFail();

        $booking->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->reason ?? 'Rejected by school',
        ]);

        return back()->with('success', 'Visit rejected.');
    }

    // School Owner — Mark Completed
    public function complete($id)
    {
        $schoolIds = auth()->user()->schools()->pluck('id');

        $booking = VisitBooking::where('id', $id)
            ->whereIn('school_id', $schoolIds)
            ->firstOrFail();

        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Visit marked as completed.');
    }
}