<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 13.03.2016
 * Time: 19:08
 */

foreach (glob("classes/*.php") as $filename)
{
    if(file_exists($filename)){
        require_once $filename;
    }

}