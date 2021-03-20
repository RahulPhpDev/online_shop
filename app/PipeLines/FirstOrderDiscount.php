<?php

namespace App\PipeLines;
use Clouser;
// use App\Interfaces\Pipe;

class FirstOrderDiscount 
{
	public function handle($content , Closure $next) 
	{
		dd($content);
		 return  $next($content);
	}
}  