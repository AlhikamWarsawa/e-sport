<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        return redirect()
            ->route('admin.applications.index')
            ->with('success', 'Pendaftaran berhasil diapprove.');
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

        return redirect()
            ->route('admin.applications.index')
            ->with('success', 'Pendaftaran berhasil direject.');
    }
}
