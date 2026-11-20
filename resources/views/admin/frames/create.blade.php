
@extends('admin.layouts.app')

@section('title', 'Tambah Template - WhimsyBooth')
@section('page-title', 'Tambah Template')
@section('page-subtitle', 'Unggah frame photobooth baru.')

@push('styles')
<style>
    .form-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        border: 1px solid #eee5df;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #765b83;
    }

    .form-group input[type="text"],
    .form-group input[type="file"],
    .form-group select {
        width: 100%;
        padding: 13px;
        border: 1px solid #e5dcd5;
        border-radius: 9px;
        background: #fff;
        color: #39332f;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #a78bc0;
        box-shadow: 0 0 0 3px rgba(167, 139, 192, 0.12);
    }

    .preview {
        margin-top: 15px;
        padding: 20px;
        background: #f8f5f2;
        border: 1px dashed #d9c9e3;
        border-radius: 12px;
        text-align: center;
        color: #8b817b;
    }

    .preview img {
        max-width: 100%;
        max-height: 350px;
        object-fit: contain;
    }

    .hint {
        color: #8b817b;
        font-size: 13px;
        margin-top: 8px;
    }

    .error {
        color: #c76d6d;
        font-size: 13px;
        margin-top: 7px;
    }

    .buttons {
        display: flex;
        gap: 12px;
        margin-top: 25px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        border: none;
        border-radius: 9px;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-save {
        background: #8d6eac;
        color: white;
    }

    .btn-back {
        background: #eee5df;
        color: #6b625d;
    }

    .btn:hover {
        opacity: 0.85;
    }

    @media (max-width: 600px) {
        .form-card {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')

<div class="form-container">
    <div class="form-card">

        <form
            action="{{ route('admin.frames.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="form-group">
                <label for="name">Nama Frame</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Contoh: Whimsical Pastel"
                    value="{{ old('name') }}"
                    required
                >

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Upload Frame Photobooth</label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".png,.jpg,.jpeg,.webp,.gif"
                    required
                >

                <p class="hint">
                    Format: PNG, JPG, JPEG, WEBP, GIF.
                    Maksimal ukuran file 20 MB.
                </p>

                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror

                <div class="preview" id="preview">
                    <p>Preview frame akan muncul di sini.</p>
                </div>
            </div>

            <div class="form-group">
                <label for="is_active">Status Frame</label>

                <select
                    id="is_active"
                    name="is_active"
                    required
                >
                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>
                </select>

                @error('is_active')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="buttons">
                <button type="submit" class="btn btn-save">
                    Simpan Template
                </button>

                <a
                    href="{{ route('admin.frames.index') }}"
                    class="btn btn-back"
                >
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');

    let previewUrl = null;

    imageInput.addEventListener('change', function () {

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
        }

        const file = this.files[0];

        if (!file) {
            preview.innerHTML =
                '<p>Preview frame akan muncul di sini.</p>';
            return;
        }

        const allowedTypes = [
            'image/png',
            'image/jpeg',
            'image/webp',
            'image/gif'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung.');
            this.value = '';
            return;
        }

        if (file.size > 20 * 1024 * 1024) {
            alert('Ukuran file maksimal 20 MB.');
            this.value = '';
            return;
        }

        previewUrl = URL.createObjectURL(file);

        preview.innerHTML = `
            <img src="${previewUrl}" alt="Preview frame">
        `;
    });
</script>
@endpush
