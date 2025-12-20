<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberProfile;
use App\Mail\MemberApprovedMail;
use App\Mail\MemberRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class ApplicationsController extends Controller
{
    public function index()
    {
        $applications = MemberProfile::where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.applications.index', compact('applications'));
    }

    public function show($id)
    {
        $application = MemberProfile::findOrFail($id);

        return view('admin.applications.show', compact('application'));
    }

    public function approve($id)
    {
        $application = MemberProfile::findOrFail($id);

        if ($application->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Pendaftaran sudah diproses sebelumnya.');
        }

        $application->update([
            'status'          => 'approved',
            'approved_at'     => Carbon::now(),
            'rejected_reason' => null,
        ]);

        Mail::to($application->email)
            ->send(new MemberApprovedMail($application));

        return redirect()
            ->route('admin.applications.index')
            ->with('success', 'Pendaftaran berhasil diapprove dan email telah dikirim.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejected_reason' => 'nullable|string|max:255',
        ]);

        $application = MemberProfile::findOrFail($id);

        if ($application->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Pendaftaran sudah diproses sebelumnya.');
        }

        $application->update([
            'status'          => 'rejected',
            'rejected_reason' => $request->rejected_reason,
            'approved_at'     => null,
        ]);

        Mail::to($application->email)
            ->send(new MemberRejectedMail($application));

        return redirect()
            ->route('admin.applications.index')
            ->with('success', 'Pendaftaran berhasil direject dan email telah dikirim.');
    }
}
