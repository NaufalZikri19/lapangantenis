<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;

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
        Court::create($request->all());

        return redirect()->route('courts.index')
            ->with('success', 'Court berhasil ditambahkan');
    }

    public function edit(Court $court)
    {
        return view('admin.courts.edit', compact('court'));
    }

    public function update(Request $request, Court $court)
    {
        $court->update($request->all());

        return redirect()->route('courts.index')
            ->with('success', 'Court berhasil diupdate');
    }

    public function destroy(Court $court)
    {
        $court->delete();

        return redirect()->route('courts.index')
            ->with('success', 'Court berhasil dihapus');
    }
}
