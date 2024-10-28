<?php

namespace App\Http\Controllers\Admin\Setting;

use AllowDynamicProperties;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Middleware\PermissionMiddleware;

#[AllowDynamicProperties] class indexController extends Controller implements HasMiddleware
{
    protected static string $model = 'setting';
    protected array $searchableColumns = ['name', 'value', 'description'];

    public function __construct()
    {
        $this->model_text = Lang::get('admin.' . self::$model);
    }

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(PermissionMiddleware::using('setting-list'), only: ['index', 'export']),
            new Middleware(PermissionMiddleware::using('setting-create'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using('setting-edit'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('setting-destroy'), only: ['destroy']),
        ];
    }


    public function index(Request $request)
    {
        $model = self::$model;
        $page_title = $this->model_text . ' ' . Lang::get('admin.' . 'management');
        $settings = ['app_name' => 'test'];

        return view('admin.' . $model . '.index', [
            'page_title' => $page_title,
            'model' => $model,
            'model_text' => $this->model_text,
            'searchableColumns' => $this->searchableColumns,
            'settings' => $settings,
        ]);
    }

    public function edit()
    {

    }


    public function update(Request $request)
    {
        $rules = [
            'app_name' => 'string|max:255',
            'app_url' => 'url',
            'app_logo' => 'file|image|max:2048',
            'app_email' => 'email',
            'app_pubkey' => 'string',
            'app_footertext' => 'string|max:255',
            'app_telegram' => 'string|max:255',
            'app_github' => 'string|max:255',
            'app_dread' => 'string|max:255',
            'homepage_main_text' => 'string',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        $anchor = $request->input('current_tab', '');

        if ($validator->fails()) {
            return redirect()->to(url()->previous() . $anchor)
                ->withErrors($validator)
                ->withInput()
                ->with('error_message', 'Some problems at your input!');
        }

        $data = $request->except('_token', 'current_tab');

        // Store raw Markdown without converting it to HTML
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            Cache::tags('Settings')->forever($key, $value);
        }

        return redirect()->to(url()->previous() . $anchor)->with('success_message', 'Settings updated successfully.');
    }

    public function export()
    {

    }
}
