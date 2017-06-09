<?php
namespace Dframe\activityLog;

/**
 * Dframe/activityLog
 * Copyright (c) Sławomir Kaleta
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 *
 */

class Log
{
	
    public function __construct($driver = false){
    	$this->driver = $driver;
    }

    public function typesActivity(array $list){

    }

    public function entity($name = 'Dframe\activityLog\Entity\default'){
    	$this->entity = $name;
    	return $this;
    }

    public function modification(array $data){
    	$this->modification = $data;
    	return $this;
    }

    public function log(string $data){
    	$this->log = $data;
    }

}