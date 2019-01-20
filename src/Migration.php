<?php 

namespace Faryar76\LRM;

class Migration 
{
   public function RunCommand($command,$options=[])
   {
       Artisan::call($command,$options);
       return Artisan::output();
   } 
}