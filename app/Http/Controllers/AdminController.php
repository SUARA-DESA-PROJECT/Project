<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all();
        $nav = 'Data Admin';

        return view('admin.index', compact('admins', 'nav'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nav = 'Tambah Admin';
        return view('admin.create', compact('nav'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:admin',
            'password' => 'required|min:8',
        ]);

        Admin::create($validatedData);
        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        $nav = 'Detail Admin - ' . $admin->username;  
        return view('admin.show', compact('admin', 'nav'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $nav = 'Edit Admin - ' . $admin->username;
        return view('admin.edit', compact('admin', 'nav'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:admin',
            'password' => 'required|min:8',
        ]);

        $admin->update($validatedData);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus');
    }
}
