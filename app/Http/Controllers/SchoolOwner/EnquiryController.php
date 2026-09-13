<?php

namespace App\Http\Controllers\SchoolOwner;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $schoolIds = School::where('owner_id', auth()->id())->pluck('id');
        $mySchools = School::where('owner_id', auth()->id())->get(['id','name']);

        // ── Build Query ──
        $query = Enquiry::with('school')
                    ->whereIn('school_id', $schoolIds)
                    ->latest();

        // Search (parent name, mobile, school name)
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('parent_name', 'like', "%{$s}%")
                  ->orWhere('mobile',      'like', "%{$s}%")
                  ->orWhereHas('school', fn($sq) => $sq->where('name','like',"%{$s}%"));
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // School filter
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        // Class filter
        if ($request->filled('child_class')) {
            $query->where('child_class', $request->child_class);
        }

        // Date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort
        match($request->get('sort', 'latest')) {
            'oldest' => $query->reorder('created_at', 'asc'),
            'name'   => $query->reorder('parent_name', 'asc'),
            default  => $query->reorder('created_at', 'desc'),
        };

        // ── CSV Export ──
        if ($request->get('export') == 1) {
            return $this->exportCsv($query->get());
        }

        // ── Stats ──
        $all   = Enquiry::whereIn('school_id', $schoolIds);
        $stats = [
            'total'     => (clone $all)->count(),
            'new'       => (clone $all)->where('status','new')->count(),
            'contacted' => (clone $all)->where('status','contacted')->count(),
            'replied'   => (clone $all)->where('status','replied')->count(),
            'closed'    => (clone $all)->where('status','closed')->count(),
            'today'     => (clone $all)->whereDate('created_at', today())->count(),
        ];

        $enquiries = $query->paginate(15)->withQueryString();

        return view('school-owner.enquiries.index',
                    compact('enquiries', 'stats', 'mySchools'));
    }

    public function show($id)
    {
        $schoolIds = School::where('owner_id', auth()->id())->pluck('id');
        $enquiry   = Enquiry::with('school')
                        ->whereIn('school_id', $schoolIds)
                        ->findOrFail($id);

        return view('school-owner.enquiries.show', compact('enquiry'));
    }

    public function updateStatus(Request $request, $id)
    {
        $schoolIds = School::where('owner_id', auth()->id())->pluck('id');
        $enquiry   = Enquiry::whereIn('school_id', $schoolIds)->findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,contacted,replied,closed',
        ]);

        $enquiry->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function sendBrochure(Request $request, $id)
    {
        $schoolIds = School::where('owner_id', auth()->id())->pluck('id');
        $enquiry   = Enquiry::whereIn('school_id', $schoolIds)->with(['school', 'user'])->findOrFail($id);
        $school    = $enquiry->school;

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

            // If school doesn't have a saved prospectus yet, save this uploaded file
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

            $enquiry->update(['status' => 'replied']);

            return back()->with('success', "✅ Official School Brochure and admission packet emailed successfully with attachment to {$request->email}!");
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('School owner send brochure error: ' . $e->getMessage());
            return back()->with('error', '❌ Could not send brochure: ' . $e->getMessage());
        }
    }

    private function exportCsv($enquiries)
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="enquiries-'.now()->format('Y-m-d').'.csv"',
        ];

        $callback = function() use ($enquiries) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['#','Parent Name','Mobile','Child Class','School','Message','Status','Date']);
            foreach ($enquiries as $i => $e) {
                fputcsv($file, [
                    $i + 1,
                    $e->parent_name,
                    $e->mobile,
                    'Class '.$e->child_class,
                    $e->school->name ?? '—',
                    $e->message ?? '',
                    ucfirst($e->status),
                    $e->created_at->format('d M Y'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}