<?php 

namespace Faryar76\LRM;

class File
{
    protected $default_backup_folder=DIRECTORY_SEPARATOR."old_files";
    protected $realpath;
    protected $content;
    
    public function __construct(array $file)
    {
        $this->realpath=$file['realpath'];
        $this->content=$file['content'];
    }

    public function handle()
    {
        $this->create_backup($this->realpath);
        $this->createFile($this->realpath,$this->content);
    }

    public function createFile()
    {
        $content=$this->content;
        if(base64_encode(base64_decode($this->content))==$this->content)
        {
            $content=base64_decode($this->content);
        }
        return file_put_contents(base_path().$this->realpath,base64_decode($this->content),FILE_APPEND);
    }

    public function create_backup()
    {
        if(! file_exists(base_path($this->realpath)))
        {
            return false;
        }
        $folder_path=base_path(dirname($this->realpath).$this->default_backup_folder);
        $folder_path=base_path($this->default_backup_folder.dirname($this->realpath));

        if(!is_dir($folder_path))
        {
            mkdir($folder_path,0777,true);
        }
        return  rename(
                    base_path().$this->realpath,
                    $folder_path . DIRECTORY_SEPARATOR . time() . "_" . basename($this->realpath)
                    );

    }

}