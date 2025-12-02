<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::query();
        
        // Filter by role if specified
        if (request()->has('role') && request('role') !== '') {
            $query->where('is_admin', request('role'));
        }
        
        // Filter by search term if specified
        if (request()->has('search') && request('search') !== '') {
            $searchTerm = request('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }
        
        $users = $query->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'is_admin' => 'required|in:1,2',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'confirm_password.required' => 'The password confirmation field is required.',
            'confirm_password.same' => 'The password confirmation does not match.',
            'is_admin.required' => 'The role field is required.',
            'is_admin.in' => 'Please select a valid role.',
        ]);
        
        try {
            DB::beginTransaction();
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_admin' => $request->is_admin
            ]);
            
            DB::commit();
            
            return redirect()->route('users.index')
                ->with('success', 'User created successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create user. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'is_admin' => 'required|in:1,2',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'is_admin.required' => 'The role field is required.',
            'is_admin.in' => 'Please select a valid role.',
        ]);
        
        try {
            DB::beginTransaction();
            
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'is_admin' => $request->is_admin
            ]);
            
            // Update password if provided
            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'min:6',
                    'confirm_password' => 'required|same:password',
                ], [
                    'password.min' => 'The password must be at least 6 characters.',
                    'confirm_password.required' => 'The password confirmation field is required.',
                    'confirm_password.same' => 'The password confirmation does not match.',
                ]);
                
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('users.index')
                ->with('success', 'User updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update user. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting the last admin
            if ($user->is_admin == 1 && User::where('is_admin', 1)->count() <= 1) {
                return redirect()->route('users.index')
                    ->with('error', 'Cannot delete the last admin user.');
            }
            
            $user->delete();
            
            return redirect()->route('users.index')
                ->with('success', 'User deleted successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', 'Failed to delete user. ' . $e->getMessage());
        }
    }
}
