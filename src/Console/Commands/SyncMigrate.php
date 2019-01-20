<?php

namespace Faryar76\LRM\Console\Commands;

use Illuminate\Console\Command;
use Faryar76\LRM\FileReader;
use Faryar76\LRM\Client;
class SyncMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lrm:sync_migrate {type?} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy local migrate files to the server then Run the database migrations with new files';
    public    $default_migration_path;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->default_migration_path=base_path("database/migrations");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle($test=null)
    {
        $path =$this->option('path')!=null ? $this->option('path') : config('lrm.host_path');
        $type =$this->argument('type')!=null ? "migrate:".$this->argument('type') : 'migrate';

        $this->comment("scaning files");
        // $this->default_migration_path=
        $files=(new FileReader($this->default_migration_path))->get();
        $this->comment(count($files)." file detected");

        foreach($files as $key=>$file)
        {
            if(is_file($file))
            {
                $result[$key]['content']=base64_encode(file_get_contents($file)); 
                $result[$key]['name']=$file; 
                $result[$key]['realpath']=str_replace(base_path(),'',$file); 
            }
        }
        if(isset($result) && count($result) < 1)
        {
            return $this->comment("Error cant find any file");
        }
        $command=[
            'command'=>$type,
            'option'=>"",
        ];
        $this->comment("Starting actions...");

        $response = (new Client)->post($path, [
                'files'=>$result,
                'command'=>$command
        ]);
        // $response = $response->getBody()->getContents();
        // return $result;
        $this->line($response);
        $this->info("migrating Done");
        // $this->comment("Just a comment passing by");
        // $this->question("Why did you do that?");
        // $this->error("Ops, that should not happen.");
    }
}
