<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourtController extends Controller
{

    public function index()
    {
        $courts = Court::latest()->get();
        return view('admin.courts.index', compact('courts'));
    }

    public function create()
    {
        return view('admin.courts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courts', 'public');
        }

        Court::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('courts.index')
            ->with('success', 'Court berhasil ditambahkan');
    }

    public function edit(Court $court)
    {
        return view('admin.courts.edit', compact('court'));
    }

    public function update(Request $request, Court $court)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $path = $file->store('courts', 'public');

            $court->image = $path;
        }

        $court->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'image' => $court->image,
        ]);

        return redirect()->route('courts.index');
    }

    public function destroy(Court $court)
    {
        $court->delete();

        return redirect()->route('courts.index')
            ->with('success', 'Court berhasil dihapus');
    }
}
