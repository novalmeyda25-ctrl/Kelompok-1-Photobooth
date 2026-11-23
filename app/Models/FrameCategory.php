<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FrameController extends Controller
{
    public function index()
    {
        $frames = Frame::latest()->get();

        return view('admin.frames.index', compact('frames'));
    }

    public function create()
    {
        return view('admin.frames.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $request->file('image')->store('frames', 'public');

        Frame::create([
            'name' => $request->name,
            'image_path' => $imagePath,
            'frame_category_id' => null,
        ]);

        return redirect()->route('admin.frames.index')
            ->with('success', 'Frame berhasil ditambahkan!');
    }

    public function edit(Frame $frame)
    {
        return view('admin.frames.edit', compact('frame'));
    }

    public function update(Request $request, Frame $frame)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('image')) {
            if ($frame->image_path) {
                Storage::disk('public')->delete($frame->image_path);
            }

            $data['image_path'] = $request->file('image')
                ->store('frames', 'public');
        }

        $frame->update($data);

        return redirect()->route('admin.frames.index')
            ->with('success', 'Frame berhasil diperbarui!');
    }

    public function destroy(Frame $frame)
    {
        if ($frame->image_path) {
            Storage::disk('public')->delete($frame->image_path);
        }

        $frame->delete();

        return redirect()->route('admin.frames.index')
            ->with('success', 'Frame berhasil dihapus!');
    }
}
