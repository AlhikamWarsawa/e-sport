@extends('layouts.app')

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

        <h1 class="text-3xl font-bold mb-6">Form Pendaftaran Member</h1>

        <form action="{{ url('/member/register') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="full_name" value="{{ old('full_name') }}"
                       class="w-full border-gray-300 rounded p-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border-gray-300 rounded p-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Nomor HP <span class="text-red-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full border-gray-300 rounded p-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Tanggal Lahir</label>
                <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                       class="w-full border-gray-300 rounded p-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Kota</label>
                <input type="text" name="city" value="{{ old('city') }}"
                       class="w-full border-gray-300 rounded p-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Alamat</label>
                <textarea name="address" rows="3"
                          class="w-full border-gray-300 rounded p-2">{{ old('address') }}</textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1">Username <span class="text-red-600">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}"
                       class="w-full border-gray-300 rounded p-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Upload Bukti Pembayaran (JPG/PNG/PDF) <span class="text-red-600">*</span></label>
                <input type="file" name="payment_proof"
                       class="w-full border-gray-300 rounded p-2" required>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="terms" value="1" required>
                <label>Setuju dengan syarat & ketentuan</label><span class="text-red-600">*</span>
            </div>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded font-semibold">
                Daftar
            </button>
        </form>

    </div>
@endsection
