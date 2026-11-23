
@extends('admin.layouts.app')

@section('title', 'Kelola Frame - WhimsyBooth')
@section('page-title', 'Kelola Frame')
@section('page-subtitle', 'Atur frame photobooth WhimsyBooth kamu.')

@push('styles')
<style>
    .template-container {
        max-width: 1200px;
        margin: auto;
    }

    .template-toolbar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 25px;
    }

    .btn {
        display: inline-block;
        padding: 11px 18px;
        color: white;
        text-decoration: none;
        border: none;
        border-radius: 9px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-add {
        background: #8d6eac;
    }

    .btn-edit {
        background: #d9a66f;
    }

    .btn-delete {
        background: #c76d6d;
    }

    .btn:hover {
        opacity: 0.85;
    }

    .alert {
        background: #e4f3e6;
        color: #496b4b;
        padding: 15px;
        border-radius: 9px;
        margin-bottom: 20px;
    }

    .template-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 22px;
    }

    .template-card {
        background: white;
        border: 1px solid #eee5df;
        border-radius: 15px;
        padding: 15px;
        transition: 0.3s ease;
    }

    .template-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(160, 125, 180, 0.10);
    }

    .template-card img {
        width: 100%;
        height: 220px;
        object-fit: contain;
        background: #f5f1ed;
        border-radius: 10px;
    }

    .template-card h3 {
        margin: 15px 0 8px;
        color: #765b83;
    }

    .status {
        margin-bottom: 15px;
        font-size: 14px;
    }

    .status-active {
        color: #718b6b;
    }

    .status-inactive {
        color: #c76d6d;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .actions form {
        margin: 0;
    }

    .actions .btn {
        font-size: 13px;
        padding: 9px 12px;
    }

    .empty {
        grid-column: 1 / -1;
        background: white;
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        color: #8b817b;
        border: 1px solid #eee5df;
    }

    .empty h3 {
        color: #765b83;
        margin-bottom: 10px;
    }

    @media (max-width: 600px) {
        .template-toolbar {
            justify-content: flex-start;
        }

        .template-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<div class="template-container">

    <div class="template-toolbar">
        <a href="{{ route('admin.frames.create') }}" class="btn btn-add">
            + Tambah Frame
        </a>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="template-grid">

        @forelse($frames as $frame)

            <div class="template-card">

                <img
                    src="{{ asset('storage/' . $frame->image_path) }}"
                    alt="{{ $frame->name }}"
                >

                <h3>{{ $frame->name }}</h3>

                <p class="status {{ $frame->is_active ? 'status-active' : 'status-inactive' }}">
                    {{ $frame->is_active ? 'Aktif' : 'Nonaktif' }}
                </p>

                <div class="actions">

                    <a
                        href="{{ route('admin.frames.edit', $frame->id) }}"
                        class="btn btn-edit"
                    >
                        Edit
                    </a>

                    <form
                        action="{{ route('admin.frames.destroy', $frame->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus frame ini?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-delete">
                            Hapus
                        </button>
                    </form>

                </div>

            </div>

        @empty

            <div class="empty">
                <h3>Belum Ada Frame</h3>
                <p>Silakan tambahkan frame photobooth pertamamu.</p>
            </div>

        @endforelse

    </div>

</div>

@endsection
