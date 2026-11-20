
@extends('admin.layouts.app')

@section('title', 'Kelola Filter - WhimsyBooth')
@section('page-title', 'Kelola Filter')
@section('page-subtitle', 'Atur efek filter untuk hasil foto WhimsyBooth.')

@push('styles')
<style>
    .filter-container {
        max-width: 1200px;
        margin: auto;
    }

    .filter-toolbar {
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

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 22px;
    }

    .filter-card {
        background: white;
        border: 1px solid #eee5df;
        border-radius: 16px;
        padding: 16px;
        transition: 0.3s ease;
    }

    .filter-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(160, 125, 180, 0.10);
    }

    .filter-preview {
        height: 220px;
        background: #f5f1ed;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 18px;
    }

    .filter-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .filter-card h3 {
        margin-bottom: 8px;
        color: #765b83;
        font-size: 18px;
        text-transform: capitalize;
    }

    .filter-value {
        color: #8b817b;
        font-size: 13px;
        word-break: break-word;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .filter-value code {
        background: #f5eff9;
        color: #765b83;
        padding: 5px 8px;
        border-radius: 6px;
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
        .filter-toolbar {
            justify-content: flex-start;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<div class="filter-container">

    <div class="filter-toolbar">
        <a href="{{ route('admin.filters.create') }}" class="btn btn-add">
            + Tambah Filter
        </a>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="filter-grid">

        @forelse($filters as $filter)

            <div class="filter-card">

                <div class="filter-preview">
                    <img
                        src="{{ asset('images/filter-preview.jpg') }}"
                        alt="Preview {{ $filter->name }}"
                        style="filter: {{ $filter->css_filter }};"
                    >
                </div>

                <h3>{{ $filter->name }}</h3>

                <p class="filter-value">
                    Efek CSS:
                    <br>
                    <code>{{ $filter->css_filter }}</code>
                </p>

                <div class="actions">

                    <a
                        href="{{ route('admin.filters.edit', $filter->id) }}"
                        class="btn btn-edit"
                    >
                        Edit
                    </a>

                    <form
                        action="{{ route('admin.filters.destroy', $filter->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus filter ini?')"
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
                <h3>Belum Ada Filter</h3>
                <p>Silakan tambahkan filter pertamamu.</p>
            </div>

        @endforelse

    </div>

</div>

@endsection
