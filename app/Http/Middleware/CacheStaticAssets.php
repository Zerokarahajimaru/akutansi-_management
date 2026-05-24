<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheStaticAssets
{
    /**
     * Handle an incoming request.
     * Force browser to cache static resources for 1 year.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check if the request is for an asset (image, css, js, font)
        if ($this->isStaticAsset($request)) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
            $response->headers->set('Pragma', 'cache');
        }

        return $response;
    }

    private function isStaticAsset(Request $request): bool
    {
        $path = $request->getPathInfo();
        $extensions = ['.png', '.jpg', '.jpeg', '.gif', '.svg', '.ico', '.css', '.js', '.woff', '.woff2', '.ttf', '.eot'];
        
        foreach ($extensions as $ext) {
            if (str_ends_with(strtolower($path), $ext)) {
                return true;
            }
        }

        return false;
    }
}
