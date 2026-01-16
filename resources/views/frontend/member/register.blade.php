@extends('layouts.app')

@section('content')
    <div class="min-h-screen px-4 py-12">

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

        <div class="w-full max-w-2xl mx-auto bg-white rounded-md shadow-sm border border-gray-100 p-6 md:p-10">

            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">
                    Member Registration
                </h1>
                <p class="mt-2 text-gray-500 text-sm">
                    Lengkapi data di bawah untuk menjadi member
                </p>
            </div>

            <form action="{{ url('/member/register') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Username <span class="text-red-600">*</span>
                    </label>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="username"
                        class="w-full px-2 py-1 rounded border border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-600">*</span>
                    </label>
                    <input
                        type="text"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        placeholder="Nama sesuai identitas"
                        class="w-full px-2 py-1 rounded border border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-600">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email@example.com"
                        class="w-full px-2 py-1 rounded border border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor HP <span class="text-red-600">*</span>
                    </label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-2 py-1 rounded border border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Lahir
                        </label>
                        <input
                            type="date"
                            name="birth_date"
                            value="{{ old('birth_date') }}"
                            class="w-full px-2 py-1 rounded border border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kota
                        </label>
                        <input
                            type="text"
                            name="city"
                            value="{{ old('city') }}"
                            placeholder="Kota domisili"
                            class="w-full px-2 py-1 rounded border border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Alamat
                    </label>
                    <textarea
                        name="address"
                        rows="3"
                        placeholder="Alamat lengkap"
                        class="w-full px-2 py-1 rounded border border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('address') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Bukti Pembayaran <span class="text-red-600">*</span>
                    </label>
                    <div class="flex items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-full bg-gray-50">
                        <input
                            type="file"
                            name="payment_proof"
                            required
                            class="block w-full text-sm text-gray-600
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-full file:border-0
                                   file:bg-blue-600 file:text-white
                                   hover:file:bg-blue-700 transition"
                        >
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        Format: JPG, PNG, atau PDF
                    </p>
                </div>

                <div class="flex items-start gap-3">
                    <input
                        type="checkbox"
                        name="terms"
                        value="1"
                        required
                        class="mt-1 px-2 py-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    >
                    <label class="text-sm text-gray-700">
                        Saya menyetujui <span class="font-medium">syarat & ketentuan</span>
                        <span class="text-red-600">*</span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition shadow-sm"
                >
                    Daftar Sekarang
                </button>

            </form>

        </div>
    </div>
@endsection
