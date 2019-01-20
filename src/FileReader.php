<?php 

namespace Faryar76\LRM;

class FileReader
{
    public $path;
    private $folderItem;
    private $subItems;

    public function __construct($path,$subItems=false)
    {
        $this->path=$path;
        $this->subItems=$subItems;
        $this->scaner();
    }
    public function scaner()
    {
        $this->folderItem=$this->find($this->path);
    }
    public function get()
    {
        return $this->folderItem;
    }
    public function files()
    {
        $files=[];
        foreach($this->folderItem as $file)
        {
            $file_path=$this->path.DIRECTORY_SEPARATOR.$file;
            if(is_file($file_path))
            {
                $files[]=$file;
            }
        }
        $this->folderItem=$files;
        return $this;
    }
    public function getContentFrom($file_path)
    {   
        if(!file_exists($file_path))
        {
            return false;
        }
        return file_get_contents($file_path);
    }
    public function find($path)
    {   
        $items=[];
        $files=array_diff(scandir($path),['.','..','old_files']);
        foreach($files as $file)
        {
            $f=$path.DIRECTORY_SEPARATOR.$file;
            if(is_file($f))
            {
                $items=array_merge($items,[$f]);
            }else if($this->subItems==true){
                $items=array_merge($items,$this->find($f));
            }
        }
        return $items;
    }

}