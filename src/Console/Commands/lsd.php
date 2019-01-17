<?php

namespace Faryar76\LSD\Console\Commands;

use Illuminate\Console\Command;

class lsd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lsd:migrate {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $path = $this->option('path');

        $migrationPath=base_path("database/migrations/");
        $files=array_values(array_diff(scandir($migrationPath),['..','.']));
        
        foreach($files as $key=>$file)
        {
            $result[$key]['content']=base64_encode(file_get_contents($migrationPath.$file)); 
            $result[$key]['path']=$file; 
        }
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $path, [
            "form_params"=>$result
        ]);
        $response = $response->getBody()->getContents();
        // return $result;
        $this->line($response);
        // $this->info("Hey, watch this !");
        // $this->comment("Just a comment passing by");
        // $this->question("Why did you do that?");
        // $this->error("Ops, that should not happen.");
    }
}
