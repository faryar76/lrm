<?php

namespace Faryar76\LRM\Console\Commands;

use Illuminate\Console\Command;
use Faryar76\LRM\FileReader;
use Faryar76\LRM\Client;
class Migration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lrm:migrate {type?} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the database migrations only with Existing files on the server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
        
        $this->comment("connecting to ".$path);
        // $migrationPath=base_path("database/migrations");
        // $files=(new FileReader($migrationPath))->files()->get();
        
        // foreach($files as $key=>$file)
        // {
        //     if(is_file($migrationPath.DIRECTORY_SEPARATOR.$file))
        //     {
        //         $result[$key]['content']=base64_encode(file_get_contents($migrationPath.DIRECTORY_SEPARATOR.$file)); 
        //         $result[$key]['name']=$file; 
        //         $result[$key]['realpath']=str_replace(base_path(),'',$migrationPath.DIRECTORY_SEPARATOR.$file); 
        //     }
        // }
        $command=[
            'command'=>$type,
            'option'=>"",
        ];
        $this->comment("starting migrate ... ");
        $response = (new Client)->post($path, [
                'files'=>null,
                'command'=>$command
        ]);
        // $response = $response->getBody()->getContents();
        // return $result;

        $this->line($response);
        $this->info("migrate ... Done");

        // $this->info("Hey, watch this !");
        // $this->comment("Just a comment passing by");
        // $this->question("Why did you do that?");
        // $this->error("Ops, that should not happen.");
    }
}
