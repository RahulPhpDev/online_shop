<?php
//PipeInterface.php
namespace App\Interfaces;

use Closure;

interface Pipe
{
	// interface does not have the method defination
	public function handle($content, Closure $next); 
}

