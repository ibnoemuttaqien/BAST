<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  /**
   * Display a listing of the users.
   */
  public function index()
  {
    $users = User::all();
    $user = Auth::user();

    return view('admin.users.index', compact('users', 'user'));
  }

  /**
   * Show the form for creating a new user.
   */
  public function create()
  {
    return view('admin.users.create');
  }

  /**
   * Store a newly created user in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'username' => 'required|string|max:255|unique:users',
      'nama' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'role' => 'required|string',
      'password' => 'required|string|min:8',
      'jenis_kelamin' => 'required|string',
      'nohp' => 'nullable|string',
      'alamat' => 'nullable|string',
      'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
    ]);

    $data = $request->only(['username', 'nama', 'email', 'role', 'jenis_kelamin', 'nohp', 'alamat']);
    $data['password'] = Hash::make($request->password);

    if ($request->hasFile('foto')) {
      // Menyimpan foto secara manual ke direktori 'uploads'
      $file = $request->file('foto');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $data['foto'] = 'uploads/' . $filename;
    }

    User::create($data);

    return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
  }


  /**
   * Show the form for editing the specified user.
   */
  public function edit(User $user)
  {
    return view('admin.users.edit', compact('user'));
  }

  /**
   * Update the specified user in storage.
   */
  public function update(Request $request, User $user)
  {
    $request->validate([
      'username' => 'required|string|max:255|unique:users,username,' . $user->id,
      'nama' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
      'role' => 'required|string',
      'password' => 'nullable|string|min:8',
      'jenis_kelamin' => 'required|string',
      'nohp' => 'nullable|string',
      'alamat' => 'nullable|string',
      'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->only(['username', 'nama', 'email', 'role', 'jenis_kelamin', 'nohp', 'alamat']);

    if ($request->filled('password')) {
      $data['password'] = Hash::make($request->password);
    }

    if ($request->hasFile('foto')) {
      // Hapus foto lama jika ada
      if ($user->foto && file_exists(public_path($user->foto))) {
        unlink(public_path($user->foto));
      }

      // Simpan foto baru secara manual
      $file = $request->file('foto');
      $filename = time() . '_' . $file->getClientOriginalName();
      $file->move(public_path('uploads'), $filename);
      $data['foto'] = 'uploads/' . $filename;
    }

    $user->update($data);

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
  }


  /**
   * Remove the specified user from storage.
   */
  public function destroy(User $user)
  {
    // Hapus foto dari direktori secara manual
    if ($user->foto && file_exists(public_path($user->foto))) {
      unlink(public_path($user->foto));
    }

    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
  }
}
