<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;

class ImageServeController extends Controller
{
    protected $disk = 'public';
    protected $cacheRoot = 'cache';
    protected $fallback = 'fallback.png';

    public function serve(Request $request, $path)
    {
        // Sanitize path (prevent directory traversal)
        $safePath = str_replace('..', '', $path);
        $source = $request->query('source', 'storage');
        $originalPath = $safePath;
        //Log::info(secure_image_url(...));
        //🔐 Signed URL validation
        if (!$request->hasValidSignature()) {
            Log::warning('Invalid signature', ['url' => $request->fullUrl()]);
            abort(403, 'Invalid or expired signed URL.');
        }

        // Check if image exists, fallback if not
        $fullOriginalPath = $source === 'public' ? public_path($originalPath) : Storage::disk($this->disk)->path($originalPath);
        if (!file_exists($fullOriginalPath)) {
            Log::warning("Image not found: {$originalPath}. Using fallback.");

            $originalPath = $this->fallback;
            $fullOriginalPath = $source === 'public' ? public_path($originalPath) : Storage::disk($this->disk)->path($originalPath);
            if (!file_exists($fullOriginalPath)) {
                abort(404, 'Image and fallback not found.');
            }
        }

        $ext = pathinfo($fullOriginalPath, PATHINFO_EXTENSION);
        if (strtolower($ext) === 'svg') {
            return response()->file($fullOriginalPath);
        }

        // Query params
        $params = $request->only(['width', 'height', 'quality', 'format', 'crop', 'grayscale', 'blur', 'fit']);
        $quality = isset($params['quality']) ? (int) $params['quality'] : 90;
        $format = $this->validateFormat($params['format'] ?? 'jpg');

        // Cache filename
        $pathInfo = pathinfo($safePath);
        $hash = md5($safePath . json_encode($params));
        $cacheSubDir = "{$pathInfo['dirname']}";
        $cachedFileName = "{$pathInfo['filename']}_{$hash}.{$format}";
        $cachedPath = "{$this->cacheRoot}/{$cacheSubDir}/{$cachedFileName}";

        // Return cached version if exists
        if (Storage::disk($this->disk)->exists($cachedPath)) {
            return response()->file(Storage::disk($this->disk)->path($cachedPath));
        }
        $manager = new ImageManager(new Driver());
        // Process & save
        $image = $manager->read($fullOriginalPath);
        $image = $this->applyTransformations($image, $params);

        $cacheFullPath = Storage::disk('public')->path($cachedPath);
        $cacheDirectory = dirname($cacheFullPath);

        if (!is_dir($cacheDirectory)) {
            mkdir($cacheDirectory, 0755, true);
        }

        $image->save(Storage::disk('public')->path($cachedPath), quality: $quality);

        return response()->file(Storage::disk($this->disk)->path($cachedPath));
    }

    protected function validateFormat($format)
    {
        return in_array($format, ['jpg', 'jpeg', 'png', 'webp', 'gif']) ? $format : 'jpg';
    }

    protected function applyTransformations($img, $params)
    {
        if (!empty($params['grayscale'])) {
            $img = $img->greyscale();
        }

        if (!empty($params['blur'])) {
            $img = $img->blur(intval($params['blur']));
        }

        $width = $params['width'] ?? null;
        $height = $params['height'] ?? null;

        if ($width || $height) {
            if (!empty($params['crop']) || !empty($params['fit'])) {
                $img = $img->cover($width ?? $img->width(), $height ?? $img->height());
            } else {
                $img = $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }

        return $img;
    }
}
