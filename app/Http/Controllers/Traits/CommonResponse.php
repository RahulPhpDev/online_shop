<?php
namespace App\Http\Controllers\Traits;

trait CommonResponse 
{
	public $successResponse,$failureResponse ;

 	public function __construct() {
            $this->successResponse = $this->successResponse();
            $this->failureResponse = $this->failureResponse();
        }

	public function successResponse( $data = 'success') : array 
	{
		return [
			 'result' => 1,
	          'msg' => 'success',
	          'data' => $data
		];
	}

	public function failureResponse( $data = 'failure') : array 
	{
		return [
			 'result' => 1,
	          'msg' => 'failure',
	          'data' => $data
		];
	}
}