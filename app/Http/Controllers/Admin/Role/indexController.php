<?php

namespace App\Http\Controllers\Admin\Role;

use AllowDynamicProperties;
use App\Exports\RolesExport;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Middleware\PermissionMiddleware;

#[AllowDynamicProperties] class indexController extends Controller implements HasMiddleware
{
    // !!   Import use App\Models\Modelname;
    protected static string $model = 'role';
    protected array $searchableColumns = ['uuid','name'];

    public static function middleware(): array
    {
        $model = self::$model;
        return [
            'auth',
            new Middleware(PermissionMiddleware::using($model . '-list'), only: ['index', 'export']),
            new Middleware(PermissionMiddleware::using($model . '-create'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using($model . '-edit'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using($model . '-destroy'), only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $model = self::$model;
        $page_title = ucfirst($model) . ' ' . Lang::get('admin.' . 'management');
        $modelClass = '\\App\\Models\\' . ucfirst($model);
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
            'totalItems' => $totalItems, // Pass the total number of items
            'isSearched' => $isSearched,
        ]);
    }

    public function edit(Request $request, $uuid)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);
        $data = $modelClass::with('permissions')->find($uuid);
        $role_permissions = $data->permissions->pluck('uuid')->all();
        $page_title = ucfirst($model) . ' ' . Lang::get('admin.' . 'edit') . ' : ' . $data->name;

        return view('admin.' . $model . '.edit', [
            'data' => $data,
            'model' => $model,
            'page_title' => $page_title,
            'role_permissions' => $role_permissions,
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);

        // Validate the request data
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,uuid',
        ]);

        // Find the role by UUID
        $data = $modelClass::find($uuid);

        if ($data) {
            // Sync permissions if provided
            if ($request->filled('permissions')) {
                $data->syncPermissions($request->input('permissions'));
            } else {
                // If no permissions are provided, sync an empty array to remove all permissions
                $data->syncPermissions([]);
            }
            // Redirect back with a success message
            $message = Lang::get('messages.model_updated', ['modelname' => ucfirst($model)]);
            return redirect()->back()->with('success_message', $message);
        }

        // If data is not found, redirect back with an error message
        $message = Lang::get('messages.model_not_found', ['modelname' => ucfirst($model)]);
        return redirect()->back()->with('error_message', $message);
    }

    public function destroy(Request $request, $uuid)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);
        // Find the role by UUID
        $data = $modelClass::where('uuid', $uuid)->first();

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

    public function export(Request $request)
    {
        $model = self::$model;
        $modelClass = '\\App\\Models\\' . ucfirst($model);
        $query = $modelClass::query();

        // Reuse the search logic from the index method
        if ($request->filled('search') && $request->filled('column')) {
            $searchTerm = str_replace(['%', '_'], ['\%', '\_'], $request->search);
            $query->where($request->column, 'like', '%' . $searchTerm . '%');
        }

        $data = $query->get();
        $filters = ['search' => $request->get('search')];

        return Excel::download(new RolesExport($data, $filters), 'roles_' . time() . '.xlsx');
    }



}
