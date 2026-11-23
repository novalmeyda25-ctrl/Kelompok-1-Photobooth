
@extends('admin.layouts.app')

@section('title', 'Tambah Filter - WhimsyBooth')
@section('page-title', 'Tambah Filter')
@section('page-subtitle', 'Tambahkan efek filter baru untuk foto WhimsyBooth.')

@push('styles')
<style>
    .form-container {
        padding: 25px;
        max-width: 850px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(80, 60, 120, 0.07);
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        margin-bottom: 9px;
        color: #51436d;
        font-weight: 600;
    }

    .form-group input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ded5eb;
        border-radius: 9px;
        outline: none;
        font-size: 14px;
        box-sizing: border-box;
    }

    .form-group input:focus {
        border-color: #9b7bc8;
        box-shadow: 0 0 0 3px rgba(155, 123, 200, 0.12);
    }

    .form-help {
        display: block;
        margin-top: 7px;
        color: #8b8299;
        font-size: 12px;
    }

    .preview-box {
        width: 100%;
        min-height: 130px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #f1e9ff, #fff0f5);
        border-radius: 12px;
        margin-top: 12px;
        overflow: hidden;
    }

    .preview-text {
        font-size: 55px;
        font-weight: bold;
        color: #7656a8;
        transition: filter 0.2s ease;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
    }

    .btn {
        padding: 11px 20px;
        border-radius: 9px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-save {
        background: #8d70b8;
        color: white;
    }

    .btn-back {
        background: #eee8f5;
        color: #655477;
    }

    .error-message {
        color: #d9536b;
        font-size: 12px;
        margin-top: 6px;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-card">

        <form action="{{ route('admin.filters.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama Filter</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Vintage"
                    required
                >

                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="css_filter">Nilai CSS Filter</label>

                <input
                    type="text"
                    id="css_filter"
                    name="css_filter"
                    value="{{ old('css_filter') }}"
                    placeholder="Contoh: sepia(0.5) contrast(1.1)"
                    required
                >

                <small class="form-help">
                    Masukkan efek CSS yang ingin digunakan pada foto.
                </small>

                @error('css_filter')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <div class="preview-box">
                    <span class="preview-text" id="previewText">Aa</span>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-save">
                    Simpan Filter
                </button>

                <a href="{{ route('admin.filters.index') }}" class="btn btn-back">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const cssInput = document.getElementById('css_filter');
    const previewText = document.getElementById('previewText');

    function updatePreview() {
        previewText.style.filter = cssInput.value;
    }

    cssInput.addEventListener('input', updatePreview);

    updatePreview();
</script>
@endpush
