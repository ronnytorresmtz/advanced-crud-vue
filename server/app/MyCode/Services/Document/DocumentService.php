<?php namespace MyCode\Services\Document;


use App\Events\RegisterTransactionAccessEvent;

use Auth, Exception, Event, Lang, Session, DB;

class DocumentService implements DocumentServiceInterface 
{

	public function export($data, $fileType, $sheetName)
	{
		try {
		
			\Excel::create($sheetName, function($excel) use($data, $sheetName) {
				//create a excel sheet
		        $excel->sheet($sheetName, function($sheet) use($data){
		        	// insert the programs to excel sheet
		        	$sheet->fromArray($data);		        	

	        	});
	        // export to a file
	    	})->export($fileType);

			return array('error' => true, 'message' => Lang::get('messages.success'));
		
		} catch (Exception $e) {
	    	//Set the message error to display
			return array('error' => false, 'message' => Lang::get('messages.error_caught_exception') .'&nbsp;' . str_replace("'"," ", $e->getMessage()));
		}

	}

}