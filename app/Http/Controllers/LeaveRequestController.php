<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreLeaveRequest;
use App\Models\LeaveRequest;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class LeaveRequestController extends Controller
{
    // Display a listing of leave requests based on user role.
    public function index(Request $request): Response
    {
        $user = $request->user();
        // Manager see all the requests with eager-loaded user names ( zero N+1 query issue), Regular employees see only their own requests.
        $leaveRequests = $user->is_manager
            ? LeaveRequest::with('user')->latest()->get()
            : $user->leaveRequests()->latest()->get();
            
            return Inertia::render('LeaveRequests/Index', [
                'leaveRequests' => $leaveRequests,
            ]);
    }

    // Store a newly created leave request in storage.
    public function store(StoreLeaveRequest $request): RedirectResponse
    {
        // Securely create through the logged-in user relationship 
        $request->user()->leaveRequests()->create($request->validated());

        return redirect()->route('leave-requests.index')
            ->with('success', 'leave request submitted successfully');
    }

    // Update the status of a leave request ( manager only ).
    public function updateStatus(Request $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        // enforce the manager role authentication
        if(! $request->user()->is_manager){
            abort(403,'Only managers can approve or deny leave requests.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:approved,denied'],
        ]);
        $leaveRequest->update(['status' => $validated['status']]);

        return redirect()->route('leave-requests.index')
            ->with('success', "Leave request {$validated['status']} successfully.");
    }
}
 