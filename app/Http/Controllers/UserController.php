<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;

class UserController extends Controller
{
    /**
     * Display a listing of staff users.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:super_admin,admin,technician,salesman',
            'phone' => 'nullable|string|max:20',
            'skill_level' => 'nullable|string|max:100',
            'experience' => 'nullable|string|max:100',
            'branch' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'permissions' => 'nullable|array',
        ]);

        $permissions = [];
        $allowedPermissions = ['pos', 'repairs', 'inventory', 'purchases', 'expenses', 'reports', 'settings', 'social_media', 'cash'];
        foreach ($allowedPermissions as $perm) {
            $permissions[$perm] = $request->has("permissions.{$perm}");
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = Helpers::compressAndStoreImage($request->file('avatar'), 'avatars');
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'phone' => $request->input('phone'),
            'skill_level' => $request->input('skill_level'),
            'experience' => $request->input('experience'),
            'branch' => $request->input('branch'),
            'avatar' => $avatarPath,
            'permissions' => $permissions,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Staff account created successfully!');
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:super_admin,admin,technician,salesman',
            'phone' => 'nullable|string|max:20',
            'skill_level' => 'nullable|string|max:100',
            'experience' => 'nullable|string|max:100',
            'branch' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'permissions' => 'nullable|array',
        ]);

        $permissions = [];
        $allowedPermissions = ['pos', 'repairs', 'inventory', 'purchases', 'expenses', 'reports', 'settings', 'social_media', 'cash'];
        foreach ($allowedPermissions as $perm) {
            $permissions[$perm] = $request->has("permissions.{$perm}");
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');
        $user->skill_level = $request->input('skill_level');
        $user->experience = $request->input('experience');
        $user->branch = $request->input('branch');
        $user->permissions = $permissions;
        
        if ($request->has('is_active')) {
            if (auth()->id() !== $user->id) {
                $user->is_active = $request->boolean('is_active');
            }
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = Helpers::compressAndStoreImage($request->file('avatar'), 'avatars');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Staff account updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent admin from deleting their own account
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account!');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Staff account removed successfully!');
    }

    /**
     * Display logged in user profile.
     */
    public function profile()
    {
        $user = auth()->user();
        
        $stats = [
            'jobs_completed' => 0,
            'sales_count' => 0,
        ];

        if ($user->role === 'technician') {
            $stats['jobs_completed'] = \App\Models\Repair::where('assigned_technician_id', $user->id)
                ->whereIn('status', ['completed', 'delivered'])
                ->count();
        } elseif ($user->role === 'salesman') {
            $stats['sales_count'] = \App\Models\Sale::where('salesman_id', $user->id)->count();
        }

        return view('users.profile', compact('user', 'stats'));
    }

    /**
     * Update logged in user profile details.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = Helpers::compressAndStoreImage($request->file('avatar'), 'avatars');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile details updated successfully!');
    }

    /**
     * Display a listing of system activity logs for Super Admins.
     */
    public function activityLogs(Request $request)
    {
        $query = \App\Models\ActivityLog::with('user');

        // Filter by Staff Member
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Filter by Action type
        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        // Search in description or loggable type/id
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('loggable_type', 'like', "%{$search}%")
                  ->orWhere('loggable_id', 'like', "%{$search}%");
            });
        }

        // Filter by Date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(25);
        $users = User::orderBy('name', 'asc')->get();

        return view('users.activity-logs', compact('logs', 'users'));
    }

    /**
     * Toggle status (active/inactive) for a user.
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Prevent deactivating own account
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot deactivate your own account!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusStr = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.users.index')->with('success', "Staff account '{$user->name}' has been {$statusStr} successfully!");
    }
}
