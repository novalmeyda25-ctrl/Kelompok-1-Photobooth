<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index()
    {
        $filters = Filter::latest()->get();

        return view('admin.filters.index', compact('filters'));
    }

    public function create()
    {
        return view('admin.filters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'css_filter' => 'required|string|max:255',
        ]);

        Filter::create([
            'name' => $request->name,
            'css_filter' => $request->css_filter,
        ]);

        return redirect()
            ->route('admin.filters.index')
            ->with('success', 'Filter berhasil ditambahkan!');
    }

    public function edit(Filter $filter)
    {
        return view('admin.filters.edit', compact('filter'));
    }

    public function update(Request $request, Filter $filter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'css_filter' => 'required|string|max:255',
        ]);

        $filter->update($request->only([
            'name',
            'css_filter',
        ]));

        return redirect()
            ->route('admin.filters.index')
            ->with('success', 'Filter berhasil diperbarui!');
    }

    public function destroy(Filter $filter)
    {
        $filter->delete();

        return redirect()
            ->route('admin.filters.index')
            ->with('success', 'Filter berhasil dihapus!');
    }
}
