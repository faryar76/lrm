<?php 
use Illuminate\Http\Request;

use Faryar76\LRM\File as FileManager;

Route::post(config('lrm.default_route'),function(Request $request){
    $request=$request->all();
    if($request['password'] != config('lrm.password'))
    {
        return "wrong password";
    }
    if(request()->has('files') && request()->get('files')!=null)
    {
        foreach(request()->get('files') as $file)
        {
           (new FileManager($file))->handle($file['realpath'],$file['content']);  
        }
    }
    if(request()->has('command') && request()->get('command')!=null)
    {
        try{
            Artisan::call(request()->command['command'],[]);
            return Artisan::output();

        }catch(Exception $e){
            return "error detected on your commnad";
        }
    }
    // Artisan::call("migrate",['--path'=>"database/migrations/remoteMigrations/"]);
});