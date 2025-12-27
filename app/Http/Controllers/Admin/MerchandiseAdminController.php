<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use App\Models\MerchandiseLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Helpers\AdminLogger;

class MerchandiseAdminController extends Controller
{
    public function index()
    {
        $merchandise = Merchandise::with(['links', 'creator'])
            ->latest()
            ->paginate(10);

        return view('admin.merchandise.index', compact('merchandise'));
    }

    public function create()
    {
        return view('admin.merchandise.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'nullable|numeric',
            'image'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'shop_name.*' => 'nullable|string|max:100',
            'url.*'       => 'nullable|url',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/merch'), $imageName);
        }

        $slug = Str::slug($request->name);
        if (Merchandise::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $merchandise = Merchandise::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $imageName,
            'created_by'  => Auth::guard('admin')->id(),
        ]);

        if ($request->filled('shop_name') && $request->filled('url')) {
            foreach ($request->shop_name as $i => $shop) {
                if (!empty($shop) && !empty($request->url[$i])) {
                    MerchandiseLink::create([
                        'merchandise_id' => $merchandise->id,
                        'shop_name'      => $shop,
                        'url'            => $request->url[$i],
                    ]);
                }
            }
        }

        AdminLogger::log('create_merchandise', [
            'merchandise_id' => $merchandise->id,
            'name'           => $merchandise->name,
        ]);

        return redirect()
            ->route('admin.merchandise.index')
            ->with('success', 'Merchandise berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $merchandise = Merchandise::with('links')->findOrFail($id);
        return view('admin.merchandise.edit', compact('merchandise'));
    }

    public function update(Request $request, $id)
    {
        $merchandise = Merchandise::with('links')->findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'nullable|numeric',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'shop_name.*' => 'nullable|string|max:100',
            'url.*'       => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            if ($merchandise->image && File::exists(public_path('images/merch/' . $merchandise->image))) {
                File::delete(public_path('images/merch/' . $merchandise->image));
            }

            $image     = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/merch'), $imageName);

            $merchandise->image = $imageName;
        }

        $merchandise->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
        ]);

        MerchandiseLink::where('merchandise_id', $merchandise->id)->delete();

        if ($request->filled('shop_name') && $request->filled('url')) {
            foreach ($request->shop_name as $i => $shop) {
                if (!empty($shop) && !empty($request->url[$i])) {
                    MerchandiseLink::create([
                        'merchandise_id' => $merchandise->id,
                        'shop_name'      => $shop,
                        'url'            => $request->url[$i],
                    ]);
                }
            }
        }

        AdminLogger::log('update_merchandise', [
            'merchandise_id' => $merchandise->id,
            'name'           => $merchandise->name,
        ]);

        return redirect()
            ->route('admin.merchandise.index')
            ->with('success', 'Merchandise berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $merchandise = Merchandise::with('links')->findOrFail($id);

        $merchandiseId   = $merchandise->id;
        $merchandiseName = $merchandise->name;

        if ($merchandise->image && File::exists(public_path('images/merch/' . $merchandise->image))) {
            File::delete(public_path('images/merch/' . $merchandise->image));
        }

        MerchandiseLink::where('merchandise_id', $merchandise->id)->delete();
        $merchandise->delete();

        AdminLogger::log('delete_merchandise', [
            'merchandise_id' => $merchandiseId,
            'name'           => $merchandiseName,
        ]);

        return redirect()
            ->route('admin.merchandise.index')
            ->with('success', 'Merchandise berhasil dihapus.');
    }
}
