<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Debug: Log total user count
        $totalUsers = User::count();
        \Log::info('Total users in database: ' . $totalUsers);

        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Get users with latest first
        $users = $query->latest()->paginate(15);
        
        // Debug: Log users being displayed
        \Log::info('Users query result:', [
            'total_users' => $totalUsers,
            'users_count' => $users->total(),
            'current_page' => $users->currentPage(),
            'user_ids' => $users->pluck('id')->toArray()
        ]);
        
        // Get all unique roles for filter dropdown
        $roles = User::distinct()->pluck('role')->filter()->sort()->values();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            // Debug: Log the request data
            \Log::info('Creating user with data:', $request->all());

            // Test database connection
            DB::connection()->getPdo();

            // Check if user already exists
            $existingUser = User::where('email', trim($request->email))->first();
            if ($existingUser) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'A user with this email address already exists.');
            }

            // Use database transaction to ensure atomicity
            $user = DB::transaction(function () use ($request) {
                // Create the user
                $user = User::create([
                    'name' => trim($request->name),
                    'email' => trim($request->email),
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                ]);

                // Verify user was created and has an ID
                if (!$user || !$user->exists) {
                    throw new \Exception('User was not created successfully - no user object returned');
                }

                if (!$user->id) {
                    throw new \Exception('User was created but has no ID - database issue');
                }

                // Force database refresh to ensure data is persisted
                $user->refresh();
                
                // Double-check by querying the database directly
                $freshUser = User::find($user->id);
                if (!$freshUser) {
                    throw new \Exception('User was created but cannot be found in database');
                }

                return $freshUser;
            });

            // Debug: Log the created user
            \Log::info('User created successfully:', [
                'user_id' => $user->id, 
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role,
                'created_at' => $user->created_at,
                'count_after_creation' => User::count()
            ]);

            // Final verification - check if user appears in listing
            $userInList = User::where('email', $user->email)->first();
            if (!$userInList) {
                throw new \Exception('User created but not found in subsequent query');
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User "' . $user->name . '" created successfully.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Database specific errors
            \Log::error('Database error creating user: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'error_code' => $e->getCode(),
                'sql_state' => $e->errorInfo[0] ?? null,
                'driver_code' => $e->errorInfo[1] ?? null,
                'error_message' => $e->errorInfo[2] ?? null
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Database error occurred while creating user. Error: ' . $e->getMessage());
                
        } catch (\Exception $e) {
            // Other errors
            \Log::error('Error creating user: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,teacher,student',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
