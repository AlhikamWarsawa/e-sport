<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Helpers\AdminLogger;


class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::current();

        if (!$settings) {
            abort(500, 'Settings belum disiapkan.');
        }

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::current();

        if (!$settings) {
            abort(500, 'Settings belum disiapkan.');
        }

        $validated = $request->validate([
            'fansclub_name'        => 'required|string|max:150',
            'fansclub_description' => 'nullable|string',
            'logo_image'           => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'banner_image'         => 'nullable|image|mimes:png,jpg,jpeg|max:4096',
        ]);

        DB::transaction(function () use ($request, $settings, $validated) {

            $settings->fansclub_name = $validated['fansclub_name'];
            $settings->fansclub_description = $validated['fansclub_description'] ?? null;

            if ($request->hasFile('logo_image')) {
                if ($settings->logo_image) {
                    File::delete(public_path('images/settings/' . $settings->logo_image));
                }

                $logoName = 'logo_' . time() . '.' . $request->logo_image->extension();
                $request->logo_image->move(public_path('images/settings'), $logoName);

                $settings->logo_image = $logoName;
            }

            if ($request->hasFile('banner_image')) {
                if ($settings->banner_image) {
                    File::delete(public_path('images/settings/' . $settings->banner_image));
                }

                $bannerName = 'banner_' . time() . '.' . $request->banner_image->extension();
                $request->banner_image->move(public_path('images/settings'), $bannerName);

                $settings->banner_image = $bannerName;
            }

            $settings->updated_at = now();
            $settings->save();
        });

        AdminLogger::log('update_settings', [
            'fansclub_name' => $settings->fansclub_name,
            'fansclub_description' => $settings->fansclub_description,
        ]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings fansclub berhasil diperbarui.');
    }
}
