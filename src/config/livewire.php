<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Class Namespace
    |--------------------------------------------------------------------------
    |
    | This value sets the root class namespace for Livewire component classes in
    | your application. This value will change where component classes are
    | created when using the artisan make:livewire command.
    |
    */

    'class_namespace' => 'App\\Livewire',

    /*
    |--------------------------------------------------------------------------
    | View Layout
    |--------------------------------------------------------------------------
    |
    | This value sets the default layout view that will be used when rendering
    | Livewire components via Route::get('/some-endpoint', SomeComponent::class);.
    | In this case, the layout view will be layouts/app.blade.php.
    |
    */

    'layout' => 'components.layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Lazy Loading Placeholder
    |--------------------------------------------------------------------------
    |
    | This value sets the default placeholder view that will be used when
    | rendering Livewire components that have been configured to load
    | lazily (using the #[Lazy] attribute).
    |
    */

    'lazy_placeholder' => null,

    /*
    |--------------------------------------------------------------------------
    | Temporary File Uploads
    |--------------------------------------------------------------------------
    |
    | Livewire handles temporary file uploads automatically. This configuration
    | value sets the directory where these files will be stored. It defaults
    | to storage/app/livewire-tmp.
    |
    */

    'temporary_file_upload' => [
        'disk' => 'local',
        'rules' => null,
        'directory' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Render On Redirect
    |--------------------------------------------------------------------------
    |
    | This value determines whether Livewire will render a component's view
    | one last time before redirecting. This is useful if you want to
    | show a loading state or something while the redirect happens.
    |
    */

    'render_on_redirect' => false,

    /*
    |--------------------------------------------------------------------------
    | Json Encoding Options
    |--------------------------------------------------------------------------
    |
    | This value sets the options that will be passed to the json_encode
    | function when encoding Livewire component data.
    |
    */

    'legacy_model_binding' => false,

    /*
    |--------------------------------------------------------------------------
    | Inject Assets
    |--------------------------------------------------------------------------
    |
    | By default, Livewire automatically injects its assets (scripts and styles)
    | into your application's layout. However, if you want to manually
    | control where these assets are injected, you can disable this.
    |
    */

    'inject_assets' => true,

    /*
    |--------------------------------------------------------------------------
    | Navigate
    |--------------------------------------------------------------------------
    |
    | This value determines whether Livewire will use the "navigate" feature
    | to handle internal links. This feature "swaps" the body of the page
    | instead of doing a full page reload.
    |
    */

    'navigate' => [
        'show_progress_bar' => true,
        'progress_bar_color' => '#2299dd',
    ],

    /*
    |--------------------------------------------------------------------------
    | Asset URL
    |--------------------------------------------------------------------------
    |
    | This value sets the root URL for Livewire assets. This is useful if
    | you host your assets on a CDN or a different domain.
    |
    */

    'asset_url' => null,

    /*
    |--------------------------------------------------------------------------
    | App URL
    |--------------------------------------------------------------------------
    |
    | This value sets the root URL for your application. This is useful if
    | your application is running in a subdirectory or behind a proxy.
    |
    */

    'app_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Middleware Group
    |--------------------------------------------------------------------------
    |
    | This value sets the default middleware group that will be used when
    | Livewire handles requests.
    |
    */

    'middleware_group' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Temporary File Upload Endpoint
    |--------------------------------------------------------------------------
    |
    | Livewire handles temporary file uploads automatically. This configuration
    | value sets the endpoint that will be used to upload these files.
    |
    */

    'temporary_file_upload_endpoint' => null,

    /*
    |--------------------------------------------------------------------------
    | Manifest Path
    |--------------------------------------------------------------------------
    |
    | This value sets the path to the Livewire manifest file. This file is
    | used to map component aliases to classes.
    |
    */

    'manifest_path' => null,

    /*
    |--------------------------------------------------------------------------
    | Back Button Cache
    |--------------------------------------------------------------------------
    |
    | This value determines whether Livewire will cache the state of the
    | page when navigating back. This is useful for preserving scroll
    | position and other state.
    |
    */

    'back_button_cache' => false,

    /*
    |--------------------------------------------------------------------------
    | Pagination Theme
    |--------------------------------------------------------------------------
    |
    | This value sets the default pagination theme that will be used when
    | rendering Livewire pagination links.
    |
    */

    'pagination_theme' => 'tailwind',

];
