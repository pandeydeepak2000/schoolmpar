@extends('admin.layout')
@section('title', 'Pending Approval')
@section('page-title', 'Pending Approval')
@section('page-sub', 'Schools waiting for your approval')

@section('content')

<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-hourglass-half" style="color:#f43f5e; font-size:12px;"></i>
            Pending Schools ({{ $schools->total() }})
        </div>
    </div>

    @if($schools->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>School Name</th>
                <th>City</th>
                <th>Board</th>
                <th>Medium</th>
                <th>Classes</th>
                <th>Submitted</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schools as $i => $school)
            <tr>
                <td style="color:#94a3b8; font-size:12px;">{{ $schools->firstItem() + $i }}</td>
                <td>
                    <div style="font-weight:700; color:#0f1729; font-size:13px;">{{ $school->name }}</div>
                    <div style="font-size:11px; color:#94a3b8; margin-top:2px;">{{ Str::limit($school->address, 38) }}</div>
                </td>
                <td style="color:#475569; font-weight:500;">{{ $school->city }}</td>
                <td><span class="badge badge-yellow">{{ $school->board }}</span></td>
                <td style="color:#64748b;">{{ $school->medium }}</td>
                <td>
                    <span class="badge badge-blue">{{ $school->class_from }}–{{ $school->class_to }}</span>
                </td>
                <td style="color:#94a3b8; font-size:12px;">{{ $school->created_at->diffForHumans() }}</td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <form action="/admin/schools/{{ $school->id }}/approve" method="POST" style="display:inline">
                            @csrf @method('PATCH')
                            <button style="background:#dcfce7; color:#16a34a; border:none; border-radius:7px; padding:6px 14px; font-size:11.5px; font-weight:700; cursor:pointer; transition:all 0.15s;"
                                onmouseover="this.style.background='#22c55e';this.style.color='#fff'"
                                onmouseout="this.style.background='#dcfce7';this.style.color='#16a34a'">
                                <i class="fas fa-check" style="margin-right:4px;"></i>Approve
                            </button>
                        </form>
                        <form action="/admin/schools/{{ $school->id }}/reject" method="POST" style="display:inline">
                            @csrf @method('PATCH')
                            <button style="background:#fee2e2; color:#dc2626; border:none; border-radius:7px; padding:6px 14px; font-size:11.5px; font-weight:700; cursor:pointer; transition:all 0.15s;"
                                onmouseover="this.style.background='#ef4444';this.style.color='#fff'"
                                onmouseout="this.style.background='#fee2e2';this.style.color='#dc2626'">
                                <i class="fas fa-times" style="margin-right:4px;"></i>Reject
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:14px 18px; border-top:1px solid #f0f4fb;">
        {{ $schools->links() }}
    </div>

    @else
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; padding:70px 20px; text-align:center;">
        <div style="width:60px; height:60px; background:#f0fdf4; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:14px;">
            <i class="fas fa-check-double" style="color:#22c55e; font-size:24px;"></i>
        </div>
        <div style="font-size:15px; font-weight:800; color:#0f1729; margin-bottom:6px;">All caught up!</div>
        <div style="font-size:13px; color:#94a3b8;">No schools are waiting for approval right now.</div>
    </div>
    @endif
</div>

@endsection