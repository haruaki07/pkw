<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeadersMiddleware
{
    private $unwantedHeaders = ['X-Powered-By', 'server', 'Server'];

    /**
     * @param $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (!app()->environment('testing')) {
            $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline' fonts.bunny.net; img-src 'self' * data:; font-src 'self' fonts.bunny.net data:; connect-src 'self'; media-src 'self'; frame-src 'self' ; object-src 'none'; base-uri 'self'; upgrade-insecure-requests");
            $response->headers->set('Expect-CT', 'enforce, max-age=30');
            $response->headers->set('Permissions-Policy', 'autoplay=(self), camera=(), encrypted-media=(self), fullscreen=(), geolocation=(self), gyroscope=(self), magnetometer=(), microphone=(), midi=(), payment=(), sync-xhr=(self), usb=()');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,PATCH,DELETE,OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type,Authorization,X-Requested-With,X-CSRF-Token');
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            $response->headers->set('X-Content-Type-Options', 'nosniff');

            $this->removeUnwantedHeaders($this->unwantedHeaders);
        }

        return $response;
    }

    /**
     * @param $headers
     */
    private function removeUnwantedHeaders($headers): void
    {
        foreach ($headers as $header) {
            header_remove($header);
        }
    }
}
