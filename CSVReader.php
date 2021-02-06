<?php

class CSVReader {

	/*
	 * Path to the input .csv file
	 * @var string
	 */
	public string $inputFile = '';

	/*
	 * The working file resource
	 * @var bool|resource
	 */
	public $fd;

	function __construct($filename){
		$this->inputFile = dirname(__FILE__) . '/' . $filename;
	}

	public function init(): self {
		$this->fd = fopen($this->inputFile, "r");
		if(!$this->fd){
			return $this;
		}
		$this->onFileOpen($this->fd);
		while(!feof($this->fd)){
			$this->loop(fgetcsv($this->fd));
		}
		$this->beforeFileClose($this->fd);
		fclose($this->fd);
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
	 * Action to take on the csv fields
	 * @param $fields
	 */
	public function loop($fields){}
}

