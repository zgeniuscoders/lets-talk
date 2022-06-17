<?php


namespace Legacy\Legacy\Facades;

use Legacy\Legacy\File\Upload as UploadClass;

class Upload
{
    public static function __callStatic($name, $arguments)
    {
        $upload = new UploadClass();
        return call_user_func_array([$upload,$name], $arguments);
    }
}
