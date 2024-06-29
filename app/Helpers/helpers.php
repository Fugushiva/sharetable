<?php

use Illuminate\Support\Facades\File;

if (!function_exists('image_path')) {
    function image_path($name)
    {
        $extensions = ['jpg', 'png', 'jpeg'];
        foreach ($extensions as $extension) {
            $path = public_path("img/profiles/{$name}.{$extension}");
            if (File::exists($path)) {
                return asset("img/profiles/{$name}.{$extension}");
            }
        }
        return null;
    }
}

if (!function_exists('generateUniqueImageName')) {
    /**
     * Génère un nom unique pour une image uploadée.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    function generateUniqueImageName($file)
    {
        // get the file extension
        $extension = $file->getClientOriginalExtension();

        // generate a unique name for the image
        $uniqueName = uniqid() . '_' . time() . '.' . $extension;

        return $uniqueName;
    }
}
