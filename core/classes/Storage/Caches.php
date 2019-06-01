<?php
/**
 * @Author by Sulaiman Adewale.
 * @Date 1/18/2019
 * @Time 6:48 PM
 * @Project Path
 */

namespace Path\Core\Storage;


class Caches
{
    private const CACHE_DIR = "path/.Storage/.Caches/";

    /**
     *
     * @param $key
     * @return null|string
     */
    static public function get($key): ?string
    {
        //        TODO: Do some validation for the key
        $caches_path = root_path() . self::CACHE_DIR . $key . ".pch";
        $value = @file_get_contents($caches_path);
        return  $value ?? null;
    }

    /**
     *
     * @param $key
     * @param $value
     * @return bool|int
     */
    static public function set($key, $value)
    {
        $caches_path = root_path() . self::CACHE_DIR . $key . ".pch";
        return file_put_contents($caches_path, $value);
    }

    static public function cache($key, $value)
    {
        $caches_path = root_path() . self::CACHE_DIR . $key . ".pch";
        return file_put_contents($caches_path, $value);
    }

    /**
     * @param $key
     */
    static public function delete($key)
    {
        $caches_path = root_path() . self::CACHE_DIR . $key . ".pch";
        @unlink($caches_path);
    }

    static function deleteAll(){
        $files = glob(self::CACHE_DIR.'*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
    }
}
