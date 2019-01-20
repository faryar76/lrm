<?php

namespace Faryar76\LRM\Console\Commands;

use Illuminate\Console\Command;
use Faryar76\LRM\FileReader;
use Faryar76\LRM\Client;
class SyncFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lrm:upload {path?} {--path=} {--sub}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload file or folders to server';
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
        $files_path =$this->argument('path') ?? false;

        if(!$files_path || !file_exists($files_path))
        {
            $this->error('--> cant get file in "'.$files_path.'"');
            $this->comment('--> please enter path of folder or a file. for example :');
            $this->info('--> for folder :');
            $this->line('--> php artisan lrm:upload "app/Http/Controllers"');
            $this->info('--> for single file :');
            $this->line('--> php artisan lrm:upload "app/Http/User.php"');
            return false;
        }
        $this->comment("scaning files....");

        $files=[base_path($files_path)];   
        if(!is_file(base_path($files_path)))
        {
            $files=(new FileReader(base_path($files_path),$this->option('sub')))->get();
        }
        $this->comment( count($files) . " file detected");
        foreach($files as $key=>$file)
        {
            if(is_file($file))
            {
                $result[$key]['content']=base64_encode(file_get_contents($file)); 
                $result[$key]['name']=basename($file); 
                $result[$key]['realpath']=str_replace(base_path(),'',$file); 
            }
        }
        // dd($result);
        // if(isset($result) && count($result) < 1)
        // {
        //     $this->comment("Error cant find any file");
        //     abort();
        // }
        $command=[
            'command'=>null,
            'option'=>null,
        ];
        $this->comment("Uploading files ...");

        $response = (new Client)->post($path, [
                'files'=>$result,
                'command'=>$command
        ]);
        // $response = $response->getBody()->getContents();
        // return $result;
        $this->line($response);
        $this->info("Uploading files Done");
        // $this->info("Hey, watch this !");
        // $this->comment("Just a comment passing by");
        // $this->question("Why did you do that?");
        // $this->error("Ops, that should not happen.");
    }
}
