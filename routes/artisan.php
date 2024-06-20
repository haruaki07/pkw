<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Output\BufferedOutput;

if (env("APP_DEBUG", false) == true) {
    Route::get('/artisan', function (Request $request) {
        $args = $request->query("cmd");
        $allow_list = [
            "storage:link",
            "migrate",
            "migrate:fresh",
            "db:seed",
            "config:clear",
            "config:cache",
            "cache:clear",
            "view:cache",
            "view:clear",
            "route:cache",
            "route:clear",
            "optimize",
            "optimize:clear",
            "key:generate"
        ];

        if ($args == null) return "noop";

        $cmd = explode(" ", $args)[0];

        // if not an artisan command
        if (!array_key_exists($cmd, Artisan::all())) return "noop";

        // if not in allow list
        if (!in_array($cmd, $allow_list)) return "noop";

        // check if request is curl-like tools
        $is_curl = Str::contains($request->userAgent(), ['curl', 'wget', 'httpie'], true);

        // execute command
        $buf = new BufferedOutput();
        Artisan::call("{$args} --no-ansi --no-interaction", [], $buf);
        $out = $buf->fetch();

        if ($is_curl) return $out;

        return "<pre>{$out}</pre>";
    });
}
