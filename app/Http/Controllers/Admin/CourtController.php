<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $filename = uniqid() . '-' . time() . '.webp';
                
                $manager = new ImageManager(new Driver());
                $img = $manager->decode($file->getRealPath());
                
                // Resize to max 800px width
                $img->scaleDown(width: 800);
                
                // Encode to webp 75% quality
                $encoded = $img->encode(new WebpEncoder(quality: 75))->toString();
                
                Storage::disk('public')->put('courts/' . $filename, $encoded);
                $imagePath = 'courts/' . $filename;
            } catch (\Exception $e) {
                return back()->withInput()->with('error', 'Gagal memproses gambar: ' . $e->getMessage());
            }
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
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $filename = uniqid() . '-' . time() . '.webp';
                
                $manager = new ImageManager(new Driver());
                $img = $manager->decode($file->getRealPath());
                $img->scaleDown(width: 800);
                $encoded = $img->encode(new WebpEncoder(quality: 75))->toString();
                
                // Hapus gambar lama agar tidak menumpuk di storage (Maintainability & Storage Optimization)
                if ($court->image && Storage::disk('public')->exists($court->image)) {
                    Storage::disk('public')->delete($court->image);
                }

                Storage::disk('public')->put('courts/' . $filename, $encoded);
                $court->image = 'courts/' . $filename;
            } catch (\Exception $e) {
                return back()->withInput()->with('error', 'Gagal memproses gambar: ' . $e->getMessage());
            }
        }

        $court->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'image' => $court->image,
        ]);

        return redirect()->route('courts.index')->with('success', 'Court berhasil diupdate');
    }

    public function destroy(Court $court)
    {
        // Hapus gambar fisik dari server saat data dihapus
        if ($court->image && Storage::disk('public')->exists($court->image)) {
            Storage::disk('public')->delete($court->image);
        }

        $court->delete();

        return redirect()->route('courts.index')
            ->with('success', 'Court berhasil dihapus');
    }
}
