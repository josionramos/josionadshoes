<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Gallery;
use App\Http\Resources\Media as MediaResource;
use App\Http\Requests\Media as MediaRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Gallery       $gallery
     * @param  MediaRequest  $request
     * @return MediaResource
     */
    public function upload(Gallery $gallery, MediaRequest $request)
    {
        $ext = '.jpg';
        $path = trim($gallery->path, '/');
        $prefix = str_random(12);
        $image = Image::make($request->image->path());
        $storage = Storage::disk('public');

        $sizes = [];
        $resizes = [];

        foreach (range(0, 2) as $index) {
            $width = null;
            $height = null;

            if ($gallery->width) {
                $width = $gallery->width;

                if ($index > 0) {
                    $width = $width / ($index * $gallery->resize_ratio);
                }
            }

            $sizes[] = [
                'width' => $width ? round($width) : null,
                'height' => $height ? round($height) : null
            ];
        }

        $original = $path . '/' . $prefix . '_orginal'  . $ext;
        $storage->put($original, $image->encode('jpg'));

        foreach ($sizes as $size) {
            $image->resize($size['width'], $size['height'], function ($constraint) {
                $constraint->aspectRatio();
            });

            $sufix = $image->width() . 'x' . $image->height();
            $fullpath = $path . '/' . $prefix . '_' . $sufix . $ext;

            $resizes[] = $fullpath;

            $storage->put($fullpath, $image->encode('jpg', 75));
        }

        $media = Media::create([
            'thumbnail' => $resizes[2],
            'medium' => $resizes[1],
            'large' => $resizes[0],
            'original' => $original,
        ]);

        return new MediaResource($media);
    }
}
