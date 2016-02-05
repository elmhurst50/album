<?php

namespace samjoyce777\album;


use Intervention\Image\Facades\Image;

/**
 * Class Album
 * @package samjoyce777\album
 */
class Album
{
    protected $originalsPath;

    protected $cachePath;

    protected $sizes;

    protected $publicUrl;

    public function __construct()
    {
        $this->originalsPath = $this->setOriginalsPath();

        $this->cachePath = $this->setCachePath();

        $this->publicUrl = $this->setPublicUrl();

        $this->sizes = $this->setImageSizes();
    }


    /**
     * This is the main call into the class, returns the url of the cached image.
     * @param $imageFile
     * @param $size
     * @return string
     */
    public function getImage($imageFile, $size)
    {
        $this->checkCallForErrors($size);

        $requestedFile = $this->makeSizeFilename($imageFile, $size);

        if (!file_exists($this->cachePath . $requestedFile)) $this->generateFile($imageFile, $size);

        return $this->publicUrl . $requestedFile;
    }

    /**
     * Returns the path for the orignal files, ideal for saving images
     * @return string
     */
    public function getOriginalPath(){
        return $this->originalsPath;
    }


    /**
     * This makes the cached image file
     * @param $imageFile
     * @param $size
     * @return string
     */
    protected function generateFile($imageFile, $size)
    {
        $destinationFile = $this->makeSizeFilename($imageFile, $size);

        $originalFile = $this->originalsPath . $imageFile;

        if (!file_exists($originalFile)) throw new \Exception('Original file not found');

        $image = Image::make($originalFile);

        //resize oringinal, then crop to keep consistent then make size.
        $image->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->crop(800, 600)
            ->resize($this->sizes[$size]["width"], $this->sizes[$size]["height"], function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationFile, 100);
    }


    /**
     * Checks the initial call for errors
     * @param $size
     * @throws \Exception
     */
    protected function checkCallForErrors($size)
    {
        if (!array_key_exists($size, $this->sizes)) throw new \Exception($size . ' is not a valid size');
    }


    /**
     * Generates a filename for the cached sized image
     * @param $imageFile
     * @param $size
     * @return string
     */
    protected function makeSizeFilename($imageFile, $size)
    {
        $pathParts = pathinfo($imageFile);

        if ($pathParts['dirname'] == '.') $pathParts['dirname'] = '';

        $filename = $pathParts['dirname'] . $pathParts['filename'] . '-' . $this->sizes[$size]['width'] . 'x' . $this->sizes[$size]['height'] . '.' . $pathParts['extension'];

        return $filename;
    }


    /**
     * Sets the array of image sizes, which are arrays of width and height
     * @return array
     */
    protected function setImageSizes()
    {
        return config('sizes');
    }

    /**
     * generates the public path to the cache file
     * @return string
     */
    protected function setPublicUrl()
    {
        $publicUrl = url() . config('paths.cache');

        return $publicUrl;
    }

    /**
     * Sets the cache path to store all the resized images
     * @return string
     */
    protected function setCachePath()
    {
        $cachePath = public_path() . config('paths.cache');

        if (!file_exists($cachePath)) mkdir($cachePath, 0777, true);

        return $cachePath;
    }

    /**
     * Sets the original path to store original images and create dir if not done
     * @return string
     */
    protected function setOriginalsPath()
    {
        $originalsPath = base_path() .  config('paths.original');

        if (!file_exists($originalsPath)) mkdir($originalsPath, 0777, true);

        return $originalsPath;
    }

}