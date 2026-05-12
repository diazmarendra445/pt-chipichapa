@extends('layouts.app')
@section('title', 'Register - PT ChipiChapa')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0"><i class="bi bi-person-plus"></i> Daftar Akun</h4>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap"
                               class="form-control @error('nama_lengkap') is-invalid @enderror"
                               value="{{ old('nama_lengkap') }}"
                               minlength="3" maxlength="40" required>
                        <div class="form-text">Minimal 3 huruf, maksimal 40 huruf.</div>
                        @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="contoh@gmail.com" required>
                        <div class="form-text">Harus menggunakan @gmail.com.</div>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               minlength="6" maxlength="12" required>
                        <div class="form-text">Minimal 6 huruf, maksimal 12 huruf.</div>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Handphone <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_hp"
                               class="form-control @error('nomor_hp') is-invalid @enderror"
                               value="{{ old('nomor_hp') }}"
                               placeholder="08xxxxxxxxxx" required>
                        <div class="form-text">Harus diawali dengan 08.</div>
                        @error('nomor_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100">Daftar</button>
                </form>

                <hr>
                <p class="text-center mb-0">
                    Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
