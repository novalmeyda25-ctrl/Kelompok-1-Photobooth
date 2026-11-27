
@extends('admin.layouts.app')

@section('title', 'Edit Template - WhimsyBooth')
@section('page-title', 'Edit Template')
@section('page-subtitle', 'Atur informasi, posisi, dan ukuran area foto.')

@push('styles')
<style>
    .edit-container {
        max-width: 950px;
        margin: auto;
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

    input, select {
        width: 100%;
        padding: 12px;
        border: 1px solid #e5dcd5;
        border-radius: 9px;
        background: white;
        color: #39332f;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #a78bc0;
        box-shadow: 0 0 0 3px rgba(167, 139, 192, 0.12);
    }

    .editor {
        margin: 30px 0;
        padding: 22px;
        background: #fbf9fc;
        border: 1px solid #eee5f2;
        border-radius: 14px;
    }

    .editor h3 {
        color: #765b83;
        margin-bottom: 10px;
    }

    .stage {
        position: relative;
        width: 100%;
        max-width: 450px;
        margin: 20px auto;
        touch-action: none;
        user-select: none;
    }

    .stage img {
        display: block;
        width: 100%;
        height: auto;
        pointer-events: none;
    }

    .photo-area {
        position: absolute;
        left: 0%;
        top: 0%;
        width: 100%;
        height: 100%;
        border: 2px solid #a17ac0;
        background: rgba(161, 122, 192, 0.25);
        cursor: move;
        touch-action: none;
    }

    .photo-area span {
        position: absolute;
        top: 5px;
        left: 5px;
        background: #765b83;
        color: white;
        font-size: 11px;
        padding: 5px 8px;
        border-radius: 4px;
        pointer-events: none;
    }

    .resize-handle {
        position: absolute;
        width: 15px;
        height: 15px;
        right: -7px;
        bottom: -7px;
        background: white;
        border: 2px solid #765b83;
        border-radius: 50%;
        cursor: nwse-resize;
        touch-action: none;
    }

    .hint {
        color: #8b817b;
        font-size: 13px;
        text-align: center;
        line-height: 1.6;
    }

    .field-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .buttons {
        display: flex;
        gap: 12px;
        margin-top: 28px;
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

    .error {
        color: #c76d6d;
        font-size: 13px;
        margin-top: 7px;
    }

    @media (max-width: 600px) {
        .form-card {
            padding: 18px;
        }

        .field-grid {
            grid-template-columns: 1fr;
        }

        .editor {
            padding: 15px;
        }
    }
</style>
@endpush

@section('content')

<div class="edit-container">

    <div class="form-card">

        <form
            action="{{ route('admin.frames.update', $frame->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Frame</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $frame->name) }}"
                    required
                >

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="imageInput">Ganti Gambar (Opsional)</label>

                <input
                    type="file"
                    name="image"
                    id="imageInput"
                    accept=".png,.jpg,.jpeg,.webp,.gif"
                >

                <p class="hint">
                    Kosongkan jika tidak ingin mengganti gambar.
                    Format PNG, JPG, JPEG, WEBP, atau GIF.
                </p>

                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group">
                <label for="is_active">Status Frame</label>

                <select name="is_active" id="is_active" required>

                    <option value="1"
                        {{ old('is_active', $frame->is_active) == 1 ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0"
                        {{ old('is_active', $frame->is_active) == 0 ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>

                </select>

                @error('is_active')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="buttons">

                <button type="submit" class="btn btn-save">
                    Simpan Perubahan
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
    const stage = document.getElementById('stage');
    const area = document.getElementById('photoArea');
    const handle = document.getElementById('resizeHandle');
    const image = document.getElementById('frameImage');

    const fields = {
        x: document.getElementById('photo_x'),
        y: document.getElementById('photo_y'),
        width: document.getElementById('photo_width'),
        height: document.getElementById('photo_height')
    };

    let mode = null;
    let startX = 0;
    let startY = 0;
    let original = {};

    function number(value) {
        return parseFloat(value) || 0;
    }

    function readFields() {
        return {
            x: number(fields.x.value),
            y: number(fields.y.value),
            width: number(fields.width.value),
            height: number(fields.height.value)
        };
    }

    function updateArea() {
        const data = readFields();

        data.x = Math.max(0, Math.min(data.x, 100));
        data.y = Math.max(0, Math.min(data.y, 100));
        data.width = Math.max(0.01, Math.min(data.width, 100 - data.x));
        data.height = Math.max(0.01, Math.min(data.height, 100 - data.y));

        fields.x.value = data.x.toFixed(2);
        fields.y.value = data.y.toFixed(2);
        fields.width.value = data.width.toFixed(2);
        fields.height.value = data.height.toFixed(2);

        area.style.left = data.x + '%';
        area.style.top = data.y + '%';
        area.style.width = data.width + '%';
        area.style.height = data.height + '%';
    }

    Object.values(fields).forEach(field => {
        field.addEventListener('input', updateArea);
    });

    area.addEventListener('pointerdown', function(event) {
        event.preventDefault();

        mode = event.target === handle ? 'resize' : 'move';

        const rect = stage.getBoundingClientRect();
        const data = readFields();

        startX = event.clientX;
        startY = event.clientY;

        original = {
            ...data,
            stageWidth: rect.width,
            stageHeight: rect.height
        };

        area.setPointerCapture(event.pointerId);
    });

    area.addEventListener('pointermove', function(event) {
        if (!mode) return;

        const dx = (event.clientX - startX) / original.stageWidth * 100;
        const dy = (event.clientY - startY) / original.stageHeight * 100;

        if (mode === 'move') {
            fields.x.value = Math.max(
                0, Math.min(100 - original.width, original.x + dx)
            ).toFixed(2);

            fields.y.value = Math.max(
                0, Math.min(100 - original.height, original.y + dy)
            ).toFixed(2);
        }

        if (mode === 'resize') {
            fields.width.value = Math.max(
                0.01, Math.min(100 - original.x, original.width + dx)
            ).toFixed(2);

            fields.height.value = Math.max(
                0.01, Math.min(100 - original.y, original.height + dy)
            ).toFixed(2);
        }

        updateArea();
    });

    function stopDragging() {
        mode = null;
    }

    area.addEventListener('pointerup', stopDragging);
    area.addEventListener('pointercancel', stopDragging);

    document.getElementById('imageInput').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const url = URL.createObjectURL(this.files[0]);
            image.src = url;
        }
    });

    updateArea();
</script>
@endpush
