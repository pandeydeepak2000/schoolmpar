<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnquiryController extends Controller
{
    // Parent submits enquiry from school page
    public function store(Request $request)
    {
        $schoolId   = $request->school_id;
        $childClass = $request->child_class ?? $request->class_interest;
        $message    = $request->message;

        if (Auth::check()) {
            $user = Auth::user();
            $parentName = $request->parent_name ?? $request->name ?? $user->name;
            $phone      = $request->phone ?? $request->mobile ?? $user->phone ?? '9876543210';
            
            $request->validate([
                'school_id'   => 'required|exists:schools,id',
                'child_class' => 'nullable',
                'class_interest' => 'nullable',
                'message'     => 'nullable|string|max:1000',
            ]);

            // If user did not pick class, default to 'General Admission Enquiry'
            if (!$childClass) {
                $childClass = 'General Admission';
            }

            // Duplicate check — same user, same school, last 24 hours
            $exists = Enquiry::where('school_id', $schoolId)
                ->where('user_id', $user->id)
                ->where('created_at', '>=', now()->subHours(24))
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->with('error', '⚠️ You have already submitted an enquiry for this school in the last 24 hours.');
            }

            $enquiry = Enquiry::create([
                'school_id'   => $schoolId,
                'parent_name' => $parentName,
                'mobile'      => $phone,
                'child_class' => $childClass,
                'message'     => $message,
                'user_id'     => $user->id,
                'status'      => 'new',
            ]);

            // Dispatch Notifications to School Owner, Admin & Parent
            $this->dispatchNotifications($enquiry, $user->email);

            return redirect()->back()
                ->with('success', '✅ Enquiry submitted successfully! The school administration will contact you shortly.');
        }

        // Guest submission
        $validated = $request->validate([
            'school_id'   => 'required|exists:schools,id',
            'parent_name' => 'nullable|string|max:100',
            'name'        => 'nullable|string|max:100',
            'phone'       => 'required|string|max:20',
            'child_class' => 'nullable',
            'class_interest' => 'nullable',
            'message'     => 'nullable|string|max:1000',
        ]);

        $parentName = $request->parent_name ?? $request->name ?? 'Parent';
        $childClass = $childClass ?: 'General Admission';

        $enquiry = Enquiry::create([
            'school_id'   => $validated['school_id'],
            'parent_name' => $parentName,
            'mobile'      => $validated['phone'],
            'child_class' => $childClass,
            'message'     => $message,
            'user_id'     => null,
            'status'      => 'new',
        ]);

        $this->dispatchNotifications($enquiry, null);

        return redirect()->back()
            ->with('success', '✅ Enquiry submitted successfully! The school will contact you shortly.');
    }

    private function dispatchNotifications(Enquiry $enquiry, ?string $parentEmail): void
    {
        try {
            $school = School::with('owner')->find($enquiry->school_id);
            if (!$school) return;

            // 1. Notify School Partner / School Email
            $recipientSchoolEmail = $school->owner?->email ?? $school->email;
            if ($recipientSchoolEmail) {
                \Illuminate\Support\Facades\Mail::to($recipientSchoolEmail)
                    ->send(new \App\Mail\EnquiryReceivedNotificationMail($enquiry, $school, 'school_owner'));
            }

            // 2. Notify Admin Desk
            $adminEmail = \App\Models\SystemSetting::get('admin_notification_email', 'admin@schoolmapr.com');
            if ($adminEmail) {
                \Illuminate\Support\Facades\Mail::to($adminEmail)
                    ->send(new \App\Mail\EnquiryReceivedNotificationMail($enquiry, $school, 'admin'));
            }

            // 3. Acknowledge Parent (if email available)
            if ($parentEmail) {
                \Illuminate\Support\Facades\Mail::to($parentEmail)
                    ->send(new \App\Mail\EnquiryReceivedNotificationMail($enquiry, $school, 'parent'));
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Enquiry email notification error: ' . $e->getMessage());
        }
    }

    // School Owner: list enquiries for their schools
    public function schoolOwnerIndex(Request $request)
    {
        $schoolIds = auth()->user()->schools()->pluck('id');

        $enquiries = Enquiry::whereIn('school_id', $schoolIds)
            ->with('school')
            ->latest()
            ->paginate(15);

        $stats = [
            'total'     => Enquiry::whereIn('school_id', $schoolIds)->count(),
            'new'       => Enquiry::whereIn('school_id', $schoolIds)->where('status','new')->count(),
            'contacted' => Enquiry::whereIn('school_id', $schoolIds)->where('status','contacted')->count(),
            'replied'   => Enquiry::whereIn('school_id', $schoolIds)->where('status','replied')->count(),
            'closed'    => Enquiry::whereIn('school_id', $schoolIds)->where('status','closed')->count(),
            'today'     => Enquiry::whereIn('school_id', $schoolIds)
                               ->whereDate('created_at', today())->count(),
        ];

        return view('school-owner.enquiries.index', compact('enquiries', 'stats'));
    }

    // School Owner: update enquiry status
    public function updateStatus(Request $request, Enquiry $enquiry)
    {
        // Security: sirf apni school ki enquiry update kar sake
        $schoolIds = auth()->user()->schools()->pluck('id');

        if (!$schoolIds->contains($enquiry->school_id)) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:new,contacted,replied,closed',
        ]);

        $enquiry->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'status'  => $enquiry->status,
            'message' => 'Status updated!',
        ]);
    }

    // School Owner: single enquiry detail
    public function schoolOwnerShow(Enquiry $enquiry)
    {
        $schoolIds = auth()->user()->schools()->pluck('id');

        if (!$schoolIds->contains($enquiry->school_id)) {
            abort(403, 'Unauthorized');
        }

        $enquiry->load('school');
        return view('school-owner.enquiries.show', compact('enquiry'));
    }
}