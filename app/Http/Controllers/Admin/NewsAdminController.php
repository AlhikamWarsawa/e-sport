<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Helpers\AdminLogger;

class NewsAdminController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'summary'      => 'nullable|string|max:300',
            'content'      => 'required|string',
            'thumbnail'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'published_at' => 'required|date',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (News::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $thumbnailName = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnailName = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/news'), $thumbnailName);
        }

        $news = News::create([
            'title'        => $validated['title'],
            'slug'         => $slug,
            'summary'      => $validated['summary'],
            'content'      => $validated['content'],
            'thumbnail'    => $thumbnailName,
            'published_at' => $validated['published_at'],
            'status'       => 'published',
            'created_by'   => Auth::guard('admin')->id(),
        ]);

        AdminLogger::log('create_news', [
            'news_id' => $news->id,
            'title'   => $news->title,
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'summary'      => 'nullable|string|max:300',
            'content'      => 'required|string',
            'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'published_at' => 'required|date',
        ]);

        $news->update([
            'title'        => $validated['title'],
            'summary'      => $validated['summary'],
            'content'      => $validated['content'],
            'published_at' => $validated['published_at'],
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail && File::exists(public_path('images/news/' . $news->thumbnail))) {
                File::delete(public_path('images/news/' . $news->thumbnail));
            }

            $file = $request->file('thumbnail');
            $thumbnailName = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/news'), $thumbnailName);

            $news->update([
                'thumbnail' => $thumbnailName,
            ]);
        }

        AdminLogger::log('update_news', [
            'news_id' => $news->id,
            'title'   => $news->title,
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->thumbnail && File::exists(public_path('images/news/' . $news->thumbnail))) {
            File::delete(public_path('images/news/' . $news->thumbnail));
        }

        $newsId    = $news->id;
        $newsTitle = $news->title;

        $news->delete();

        AdminLogger::log('delete_news', [
            'news_id' => $newsId,
            'title'   => $newsTitle,
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function toggle($id)
    {
        $news = News::findOrFail($id);

        $oldStatus = $news->status;

        $news->update([
            'status' => $news->status === 'published' ? 'draft' : 'published',
        ]);

        AdminLogger::log('toggle_news_status', [
            'news_id'   => $news->id,
            'title'     => $news->title,
            'from'      => $oldStatus,
            'to'        => $news->status,
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Status berita berhasil diperbarui.');
    }
}
