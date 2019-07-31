<?php


class ImageManager
{
    public static function upload($files = []){
        if(count($files) == 0) return false;
        $key = ImageManager::getKey($files);
        $name = ImageManager::makeName($files[$key]['name']);
        $tmpName = $files[$key]['tmp_name'];
        move_uploaded_file($tmpName, 'uploads/'.$name);
        return 'uploads/'.$name;
    }
    private function getKey($files){
        return array_keys($_FILES)[0];
    }

    private function makeName($name){
        $parts = explode('.', $name);
        $name = $parts[0];
        $ext = array_pop($parts);
        return $name.'-'.time().'.'.$ext;
    }

}