<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\School;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdmissionController extends Controller
{
    // ─────────────────────────────────────────────
    // 📝 Apply Form — Parent
    // ─────────────────────────────────────────────
    public function create($slug)
    {
        $school = School::where('slug', $slug)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->firstOrFail();

        // Sirf authenticated users apply kar sakte hain
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('info', 'Please login to apply for admission.');
        }

        $alreadyApplied = Admission::where('user_id', auth()->id())
            ->where('school_id', $school->id)
            ->whereIn('status', ['pending', 'reviewing', 'approved'])
            ->exists();

        return view('admission.form', compact('school', 'alreadyApplied'));
    }

    // ─────────────────────────────────────────────
    // 📩 Store Admission
    // ─────────────────────────────────────────────
    public function store(Request $request, $slug)
    {
        $school = School::where('slug', $slug)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->firstOrFail();

        // Duplicate check — already applied?
        $alreadyApplied = Admission::where('user_id', auth()->id())
            ->where('school_id', $school->id)
            ->whereIn('status', ['pending', 'reviewing', 'approved'])
            ->exists();

        if ($alreadyApplied) {
            return redirect()->back()
                ->with('error', 'Aapne is school me pehle se apply kar rakha hai.');
        }

        $validated = $request->validate([
            'student_name'   => 'required|string|max:100',
            'student_dob'    => 'required|date|before:today',
            'student_gender' => 'required|in:male,female,other',
            'class_applying' => 'required|string|max:20',
            'parent_name'    => 'required|string|max:100',
            'parent_phone'   => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            'parent_email'   => 'nullable|email|max:100',
            'address'        => 'required|string|max:500',
        ], [
            'parent_phone.regex' => 'Valid Indian mobile number daalo (10 digits, 6-9 se start).',
            'student_dob.before' => 'Date of birth aaj se pehle honi chahiye.',
        ]);

        $admission = Admission::create([
            'user_id'        => auth()->id(),
            'school_id'      => $school->id,
            'student_name'   => $validated['student_name'],
            'student_dob'    => $validated['student_dob'],
            'student_gender' => $validated['student_gender'],
            'class_applying' => $validated['class_applying'],
            'parent_name'    => $validated['parent_name'],
            'parent_phone'   => $validated['parent_phone'],
            'parent_email'   => $validated['parent_email'] ?? null,
            'address'        => $validated['address'],
            'status'         => 'pending',
        ]);

        // ── Payment check ───────────────────────────
        if ($school->admission_fee && $school->admission_fee > 0) {
            return redirect()->route('payment.create', [
                'admission_id' => $admission->id,
            ]);
        }

        // Fee nahi → directly reviewing
        $admission->update(['status' => 'reviewing']);

        return redirect()
            ->route('admission.status', $admission->id)
            ->with('success', 'Application submitted successfully!');
    }

    // ─────────────────────────────────────────────
    // 📊 Admission Status — Parent
    // ─────────────────────────────────────────────
    public function status($id)
    {
        $admission = Admission::with(['school', 'payment'])
            ->where('id', $id)
            ->where('user_id', auth()->id()) // 🔒 sirf apni admission dekh sake
            ->firstOrFail();

        return view('admission.status', compact('admission'));
    }

    // ─────────────────────────────────────────────
    // 👤 Parent — My Admissions
    // ─────────────────────────────────────────────
    public function myAdmissions()
    {
        $admissions = Admission::with(['school', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('parent.admissions', compact('admissions'));
    }

    // ─────────────────────────────────────────────
    // 🏫 School Owner — All Admissions
    // ─────────────────────────────────────────────
    public function schoolAdmissions(Request $request)
    {
        // 🔒 Owner ki schools pluck karo
        $schoolIds = auth()->user()->schools()->pluck('id');

        if ($schoolIds->isEmpty()) {
            return view('school-owner.admissions', [
                'admissions' => collect(),
                'stats'      => array_fill_keys(['total','pending','reviewing','approved','rejected'], 0),
                'school'     => null,
            ]);
        }

        $query = Admission::with(['user', 'school', 'payment'])
            ->whereIn('school_id', $schoolIds);

        // ── Filters ─────────────────────────────────
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('class')) {
            $query->where('class_applying', $request->class);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('parent_phone', 'like', "%{$search}%")
                  ->orWhere('parent_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('school_id')) {
            // 🔒 Sirf apni schools filter kar sake — dusri nahi
            $filteredId = $schoolIds->contains($request->school_id)
                ? $request->school_id
                : null;

            if ($filteredId) {
                $query->where('school_id', $filteredId);
            }
        }

        $admissions = $query->latest()->paginate(15)->withQueryString();

        // ── Stats ────────────────────────────────────
        $base  = Admission::whereIn('school_id', $schoolIds);
        $stats = [
            'total'     => (clone $base)->count(),
            'pending'   => (clone $base)->where('status', 'pending')->count(),
            'reviewing' => (clone $base)->where('status', 'reviewing')->count(),
            'approved'  => (clone $base)->where('status', 'approved')->count(),
            'rejected'  => (clone $base)->where('status', 'rejected')->count(),
        ];

        $schools = auth()->user()->schools()->get(); // multi-school support
        $school  = $schools->first();

        return view('school-owner.admissions', compact('admissions', 'stats', 'school', 'schools'));
    }

    // ─────────────────────────────────────────────
    // ✅ Approve — School Owner
    // ─────────────────────────────────────────────
    public function approve($id)
    {
        $admission = $this->ownerAdmission($id);
        $admission->update(['status' => 'approved']);

        return back()->with('success', '✅ Application approved!');
    }

    // ─────────────────────────────────────────────
    // ❌ Reject — School Owner
    // ─────────────────────────────────────────────
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $admission = $this->ownerAdmission($id);
        $admission->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Application rejected.');
    }

    // ─────────────────────────────────────────────
    // 🔍 Review — School Owner
    // ─────────────────────────────────────────────
    public function review($id)
    {
        $admission = $this->ownerAdmission($id);
        $admission->update(['status' => 'reviewing']);

        return back()->with('success', 'Marked as under review.');
    }

    // ─────────────────────────────────────────────
    // ↩️ Withdraw — Parent Only
    // ─────────────────────────────────────────────
    public function withdraw($id)
    {
        $admission = Admission::where('id', $id)
            ->where('user_id', auth()->id()) // 🔒 sirf apni
            ->whereIn('status', ['pending', 'reviewing'])
            ->firstOrFail();

        $admission->update(['status' => 'withdrawn']);

        return redirect()
            ->route('dashboard.admissions')
            ->with('success', 'Application withdrawn successfully.');
    }
// ─────────────────────────────────────────────
// 🧾 Receipt — Parent
// ─────────────────────────────────────────────
// 🧾 Official Admission Fee Receipt
// ─────────────────────────────────────────────
public function receipt($id)
{
    $query = Admission::where('id', $id)->with('school');

    if (!auth()->user()->hasRole('super-admin') && !auth()->user()->hasRole('admin')) {
        $query->where('user_id', auth()->id());
    }

    $admission = $query->firstOrFail();

    $payment = Payment::where('user_id', $admission->user_id)
        ->where('school_id', $admission->school_id)
        ->where('status', 'successful')
        ->latest()
        ->first();

    if (!$payment && $admission->payment_id) {
        $payment = (object)[
            'razorpay_payment_id' => $admission->payment_id,
            'razorpay_order_id'   => 'ord_app_' . str_pad($admission->id, 8, '0', STR_PAD_LEFT),
            'amount'              => ($admission->school?->admission_fee ?? 1500) * 100,
            'status'              => 'successful',
            'type'                => 'Registration Token Fee',
            'created_at'          => $admission->created_at,
        ];
    }

    if (!$payment && !$admission->payment_id) {
        return redirect()->back()
            ->with('error', 'No verified payment record exists for this admission.');
    }

    return view('parent.receipt', compact('admission', 'payment'));
}
    // ─────────────────────────────────────────────
    // 🔒 Private Helper — Owner ka Admission check
    // ─────────────────────────────────────────────
    private function ownerAdmission($id): Admission
    {
        $schoolIds = auth()->user()->schools()->pluck('id');

        return Admission::where('id', $id)
            ->whereIn('school_id', $schoolIds) // 🔒 sirf apni schools ki
            ->firstOrFail();
    }
}