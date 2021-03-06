<?php namespace Pingpong\Support;

trait ImageTrait {

    /**
     * Delete image from current instance.
     * 
     * @return boolean
     */
    public function deleteImage()
    {
        if (file_exists($path = $this->getImagePath()))
        {
            @unlink($path);

            return true;
        }

        return false;
    }

    /**
     * Get image path.
     * 
     * @return string
     */
    public function getImagePath()
    {
        return public_path(static::$path . $this->image);
    }

    /**
     * Get image url.
     * 
     * @return string
     */
    public function getImageUrl()
    {
        return asset(static::$path . $this->image);
    }

    /**
     * Accessor for "image_url".
     * 
     * @param  string $value
     * @return string
     */
    public function getImageUrlAttribute($value)
    {
        return $this->getImageUrl();
    }

    /**
     * Determine whether the current file has image.
     * 
     * @return boolean
     */
    public function hasImage()
    {
        return ! empty($this->image) && file_exists($this->getImagePath());
    }

}
