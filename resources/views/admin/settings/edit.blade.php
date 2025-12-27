@extends('layouts.admin')

@section('title', 'Settings Fansclub')

@section('content')
    <div class="max-w-2xl mx-auto py-10">

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-6">
            Settings Fansclub
        </h1>

        <form action="{{ route('admin.settings.update') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-5">

            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold mb-1">
                    Nama Fansclub <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="fansclub_name"
                       value="{{ old('fansclub_name', $settings->fansclub_name) }}"
                       class="w-full border-gray-300 rounded p-2"
                       required>
            </div>

            <div>
                <label class="block font-semibold mb-1">
                    Deskripsi Fansclub
                </label>
                <textarea name="fansclub_description"
                          rows="4"
                          class="w-full border-gray-300 rounded p-2">{{ old('fansclub_description', $settings->fansclub_description) }}</textarea>
            </div>

            @if($settings->logo_url)
                <div>
                    <label class="block font-semibold mb-1">
                        Logo Saat Ini
                    </label>
                    <img src="{{ $settings->logo_url }}"
                         alt="Logo"
                         class="w-24 h-24 rounded-full border">
                </div>
            @endif

            <div>
                <label class="block font-semibold mb-1">
                    Ganti Logo
                </label>
                <input type="file"
                       name="logo_image"
                       accept="image/png,image/jpeg"
                       class="w-full border-gray-300 rounded p-2">
            </div>

            @if($settings->banner_url)
                <div>
                    <label class="block font-semibold mb-1">
                        Banner Saat Ini
                    </label>
                    <img src="{{ $settings->banner_url }}"
                         alt="Banner"
                         class="w-full max-h-52 object-cover rounded border">
                </div>
            @endif

            <div>
                <label class="block font-semibold mb-1">
                    Ganti Banner
                </label>
                <input type="file"
                       name="banner_image"
                       accept="image/png,image/jpeg"
                       class="w-full border-gray-300 rounded p-2">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded font-semibold">
                    Simpan Perubahan
                </button>

                <a href="{{ route('admin.dashboard') }}"
                   class="text-gray-600 hover:underline">
                    Batal
                </a>
            </div>

        </form>
    </div>
@endsection
