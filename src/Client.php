<?php 

namespace Faryar76\LRM;

use GuzzleHttp\Client as Guzzle;

class Client
{
    public $client;
    public function __construct()
    {

        $this->client=new Guzzle(['http_errors' => false]);
    }
    public function post($path,$content)
    {
        $path=$path.config('lrm.default_route');
        if(! $this->check_valid_url($path))
        {
            return $path. '  not valid. please enter valid url';
        }
        $response = $this->client->request('POST', $path, [
            "form_params"=>[
                'files'=>$content['files'],
                'command'=>$content['command'],
                'password'=>config('lrm.password')
                ]
        ]);
        if($response->getStatusCode()==200)
        {
            return $response->getBody()->getContents();
        }
        return "Error Detected : ".$response->getStatusCode().(strip_tags($response->getBody()->getContents()));
    }
    public function check_valid_url($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}