<?php namespace MyCode\Services\Document;

Interface DocumentServiceInterface {
	
	/**
	* Generate a csv file
	*
	* @param 	$request: 	All the inputs from the request
	*
	* @return 	boolean
	*/
	
	public function export($model, $fileType, $sheetName);
	
}