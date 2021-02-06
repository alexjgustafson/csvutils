<?php

class CSVWriter {

	/**
	 * Path to the new .csv file
	 * @var string
	 */
	public $fileName = '';

	/**
	 * The rows to be added to the csv
	 * @var array
	 */
	public $rows = [];

	/**
	 * The working file resource, or false invalid
	 * @var mixed
	 */
	public $fw;

	function __construct($filename, $rows){
		$this->fileName = dirname(__FILE__) . '/' . $filename;
		$this->rows = $rows;
	}

	public function init(): self {
		$this->fw = fopen($this->fileName, "w");
		if(!$this->fw){
			return $this;
		}
		$this->onFileOpen($this->fw);
		$this->writeRows($this->fw, $this->rows);
		$this->beforeFileClose($this->fw);
		fclose($this->fw);
		return $this;
	}

	/**
	 * Any action to take on the file resource before looping through its rows
	 * @param $file resource The file pointer
	 */
	public function onFileOpen($file){}

	/**
	 * Any action to take on the file resource before closing it
	 * @param $file resource The file pointer
	 */
	public function beforeFileClose($file){}

	/**
	 * For each row provided in the constructor, add it to the csv
	 *
	 * @param	$file resource The file pointer
	 * @param $rows array fields to write to the csv
	 */
	public function writeRows($file, array $rows){
		foreach( $rows as $row ){
			fputcsv($file, $row);
		}
	}
}

