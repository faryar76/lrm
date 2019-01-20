<?php

$key=(strpos(config('app.key'),'base64')!==false) ? 
            base64_decode(str_replace('base64:','',config('app.key'))): 
                $key=config('app.key');



return [

    /**
     * host path.
     */

    "host_path"     =>"", //"http://someDomaing.com/"

    /**
     * defult conect route.it will changes every 10 seconds automaticly
     */
    "default_route" =>hash('sha512',$key.substr(time(),0,9)),
    /**
     * some password for more secure.
     */
    "password"      =>hash('sha512',"your-password-to-more-secure")
];