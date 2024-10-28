<?php

namespace App\Http\Controllers\Admin\User;

use AllowDynamicProperties;
use App\Http\Controllers\Controller;
use App\Utilities\Mnemonic\Mnemonic;
use Defuse\Crypto\Crypto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Middleware\PermissionMiddleware;

#[AllowDynamicProperties] class indexController extends Controller implements HasMiddleware
{
    // !!   Import use App\Models\Modelname;
    protected static string $model = 'user';
    protected array $searchableColumns = ['id', 'username', 'email', 'is_active'];

    public static function middleware(): array
    {
        $model = self::$model;
        return [
            'auth',
            new Middleware(PermissionMiddleware::using($model . '-list'), only: ['index', 'export']),
            new Middleware(PermissionMiddleware::using($model . '-create'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using($model . '-edit'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using($model . '-destroy'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using($model . '-ban'), only: ['ban_user']),
        ];
    }


    public function index(Request $request)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);
        $page_title = ucfirst($model) . ' ' . Lang::get('admin.' . 'management');
        $query = $modelClass::query();
        $isSearched = false;

        $itemsPerPage = Cache::tags('SystemSettings')->get('items_per_page', 10);

        if ($request->filled('search') && $request->filled('column')) {
            // Validate that the column is in the list of allowable searchable columns
            if (in_array($request->column, $this->searchableColumns)) {
                // Properly escaping the search term for SQL LIKE statement
                $searchTerm = str_replace(['%', '_'], ['\%', '\_'], $request->search);
                // Using the query with parameter binding for safety
                $query->where($request->column, 'like', '%' . $searchTerm . '%');
                $isSearched = true;
            }
        }

        $datas = $query->paginate($itemsPerPage);
        $totalItems = $isSearched ? $datas->total() : $modelClass::count();


        return view('admin.' . $model . '.index', [
            'page_title' => $page_title,
            'model' => $model,
            'searchableColumns' => $this->searchableColumns,
            'datas' => $datas,
            'totalItems' => $totalItems,
            'isSearched' => $isSearched,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);
        $data = $modelClass::with('permissions')->find($id);
        $role_permissions = $data->permissions->pluck('uuid')->all();
        $roles = \App\Models\Role::all();
        $currentRole = $data->getRoleNames()->first();
        $page_title = ucfirst($model) . ' ' . Lang::get('admin.' . 'edit') . ' : ' . $data->username;

        return view('admin.' . $model . '.edit', [
            'data' => $data,
            'model' => $model,
            'roles' => $roles,
            'currentRole' => $currentRole,
            'page_title' => $page_title,
            'role_permissions' => $role_permissions,
        ]);
    }

    public function create()
    {
        $model = self::$model;

        $roles = \App\Models\Role::all();
        $page_title = 'Create ' . ucfirst($model);

        return view('admin.' . $model . '.create', [

            'roles' => $roles,
            'page_title' => $page_title,
            'model' => $model,
        ]);
    }


    public function update(Request $request, $id)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);
        $user = $modelClass::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'new_password' => 'nullable|min:6',
            'referral_code' => 'required|string|max:255',
            'role' => 'required|exists:roles,uuid'
        ]);

        // Handle the file upload
        if ($request->hasFile('avatar_path') && $request->file('avatar_path')->isValid()) {
            $path = $request->avatar_path->store('avatars', 'public');
            if ($user->avatar_path) {
                Storage::delete($user->avatar_path);
            }
            $user->avatar_path = $path;
        }

        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }
        $user->referral_code = $request->referral_code;

        // Remove all roles and add the new one
        $user->roles()->detach();
        $user->roles()->attach($request->role);

        $user->save();
        $message = Lang::get('messages.model_updated', ['modelname' => ucfirst($model)]);
        return redirect()->back()->with('success_message', $message);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'nullable|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'referral_code' => 'nullable|string|max:255',
            'role' => 'required|exists:roles,uuid',
            'is_active' => 'sometimes|boolean',
            'login_2fa' => 'sometimes|boolean'
        ]);

        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);

        $mnemonic_length = 12;
        $mnemonic = (new Mnemonic())->generate($mnemonic_length);

        $data = new $modelClass();
        $data->username = $request->username;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->referral_code = $request->referral_code;
        $data->is_active = $request->has('is_active');
//        $data->login_2fa = $request->has('login_2fa');
        $data->referral_code = strtoupper(Str::random(6));
        $data->mnemonic = bcrypt(hash('sha256', $mnemonic));

        // Handle file upload
        if ($request->hasFile('avatar_path') && $request->file('avatar_path')->isValid()) {
            $data->avatar_path = $request->avatar_path->store('avatars', 'public');
        }

        $data->save();

        // Attach role to user
        $data->roles()->attach($request->role);
        $message = Lang::get('messages.user_created', ['username' => $data->username]);
        return redirect()->route('admin.' . $model . '.index')->with('success_message', $message);
    }


    public function destroy(Request $request, $id)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);
        // Find the role by ID
        $data = $modelClass::where('id', $id)->first();

        // Check if the model item exists
        if ($data) {
            try {
                // Attempt to delete the model item
                $data->delete();
                $message = Lang::get('messages.model_deleted', ['modelname' => ucfirst($model)]);
                return redirect()->back()->with('success_message', $message);
            } catch (\Exception $e) {
                // Handle potential errors
                $message = Lang::get('messages.model_not_deleted', ['modelname' => ucfirst($model)]);
                return redirect()->back()->with('error_message', $message . ' ' . $e->getMessage());
            }
        } else {
            // Model item not found
            $message = Lang::get('messages.model_not_found', ['modelname' => ucfirst($model)]);
            return redirect()->back()->with('error_message', $message);
        }
    }

    public function is_active(Request $request, $id)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);
        // Find the model instance
        $data = $modelClass::findOrFail($id);

        // Toggle the is_active status
        $data->is_active = !$data->is_active;

        // Save the changes
        $data->save();

        // Prepare the success message
        $message = Lang::get('messages.active_status_changed', ['username' => $data->username]);

        // Redirect back with a success message
        return redirect()->back()->with('success_message', $message);
    }



    public function ban_user(Request $request, $userId)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);

        $data = $modelClass::findOrFail($userId); // Find the user or fail with a 404 error

        // Get number of days from the request, default to 30 days if not provided
        $days = (int)$request->input('days', 30);  // Explicitly cast to int

        // Calculate the banned_until date
        $data->banned_until = Carbon::now()->addDays($days);
        $data->save(); // Save the user with the updated banned_until date

        // Get the appropriate translation for the feedback message
        $message = Lang::get('messages.user_banned', [
            'username' => $data->username,
            'days' => $days
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success_message', $message);
    }

    public function unban_user(Request $request, $userId)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);

        $data = $modelClass::findOrFail($userId); // Find the user or fail with a 404 error

        // Calculate the banned_until date
        $data->banned_until = null;
        $data->save(); // Save the user with the updated banned_until date

        // Get the appropriate translation for the feedback message
        $message = Lang::get('messages.user_unbanned', [
            'username' => $data->username,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success_message', $message);
    }


}
