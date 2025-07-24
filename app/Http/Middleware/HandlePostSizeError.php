<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandlePostSizeError
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if POST content length exceeds PHP's post_max_size
        if ($request->isMethod('POST') && empty($_POST) && empty($_FILES) && $request->getContentLength() > 0) {
            $maxSize = $this->parseSize(ini_get('post_max_size'));
            $actualSize = $request->getContentLength();
            
            if ($actualSize > $maxSize) {
                return back()->withErrors([
                    'image' => sprintf(
                        'The uploaded file is too large (%s). Maximum allowed size is %s. Please choose a smaller image or compress it.',
                        $this->formatBytes($actualSize),
                        ini_get('post_max_size')
                    )
                ])->withInput();
            }
        }

        return $next($request);
    }

    /**
     * Parse size string (like "8M") to bytes
     */
    private function parseSize(string $size): int
    {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $value = (int) $size;

        switch ($last) {
            case 'g':
                $value *= 1024;
            case 'm':
                $value *= 1024;
            case 'k':
                $value *= 1024;
        }

        return $value;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $size): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $base = log($size, 1024);
        return round(pow(1024, $base - floor($base)), 1) . ' ' . $units[floor($base)];
    }
}
