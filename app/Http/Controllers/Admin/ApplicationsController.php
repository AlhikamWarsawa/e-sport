<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberProfile;
use App\Models\User;
use App\Mail\MemberApprovedMail;
use App\Mail\MemberRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

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
            return back()->with('error', 'Pendaftaran sudah diproses sebelumnya.');
        }

        DB::beginTransaction();

        $qrFullPath = null;

        try {
            $year = now()->year;
            $membershipId = null;

            Cache::lock("generate-membership-{$year}", 10)->block(10, function () use (
                $year,
                &$membershipId,
                $application,
                &$qrFullPath
            ) {
                $lastNumber = MemberProfile::where('membership_id', 'like', "FANS-{$year}-%")
                    ->max(DB::raw('CAST(SUBSTR(membership_id, -4) AS UNSIGNED)')) ?? 0;

                $newNumber   = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                $membershipId = "FANS-{$year}-{$newNumber}";

                $qrToken = Str::random(64);

                $qrDir = public_path('images/qr');
                if (!File::exists($qrDir)) {
                    File::makeDirectory($qrDir, 0755, true);
                }

                $verificationUrl = route('member.verify', $qrToken);

                $qrFileName = "{$membershipId}.png";
                $qrFullPath = $qrDir . '/' . $qrFileName;

                $qrCode = new QrCode(
                    data: $verificationUrl,
                    size: 300,
                    margin: 10
                );

                (new PngWriter())
                    ->write($qrCode)
                    ->saveToFile($qrFullPath);

                $application->update([
                    'membership_id'        => $membershipId,
                    'qr_code_path'         => $qrFileName,
                    'qr_token'             => $qrToken,
                    'qr_token_expires_at'  => null,
                ]);
            });

            $application->update([
                'status'          => 'approved',
                'approved_at'     => now(),
                'rejected_reason' => null,
            ]);

            $user = User::create([
                'member_id' => $application->id,
                'name'      => $application->full_name,
                'email'     => $application->email,
                'password'  => Hash::make(Str::random(32)),
                'role'      => 'member',
                'status'    => 'active',
            ]);

            $token = Str::random(64);

            $user->update([
                'set_password_token'            => $token,
                'set_password_token_expired_at' => Carbon::now()->addHours(24),
            ]);

            Mail::to($application->email)
                ->send(new MemberApprovedMail($application, $token));

            DB::commit();

            return redirect()
                ->route('admin.applications.index')
                ->with('success', 'Pendaftaran berhasil diapprove. Email set password telah dikirim.');

        } catch (\Throwable $e) {
            DB::rollBack();

            if ($qrFullPath && File::exists($qrFullPath)) {
                File::delete($qrFullPath);
            }

            report($e);

            return back()->with(
                'error',
                'Terjadi kesalahan saat approve: ' . $e->getMessage()
            );
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejected_reason' => 'nullable|string|max:255',
        ]);

        $application = MemberProfile::findOrFail($id);

        if ($application->status !== 'pending') {
            return back()->with('error', 'Pendaftaran sudah diproses sebelumnya.');
        }

        DB::beginTransaction();

        try {
            $application->update([
                'status'          => 'rejected',
                'rejected_reason' => $request->rejected_reason,
                'approved_at'     => null,
            ]);

            Mail::to($application->email)
                ->send(new MemberRejectedMail($application));

            DB::commit();

            return redirect()
                ->route('admin.applications.index')
                ->with('success', 'Pendaftaran berhasil direject dan email telah dikirim.');

        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            return back()->with(
                'error',
                'Terjadi kesalahan saat memproses penolakan. Silakan coba lagi.'
            );
        }
    }
}
