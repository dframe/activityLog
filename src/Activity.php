<?php
namespace Dframe\activityLog;

/**
 * Dframe/activityLog
 * Copyright (c) Sławomir Kaleta
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 *
 */

class Activity
{
	
    public function __construct($driver){
    	$this->driver = $driver;
    }

    public function activityTypes(array $list){
    	$this->list = $list;
    }

    public function entity($name = '\Dframe\activityLog\Entity\default'){
    	$this->entity = $name;
    	return $this;
    }

    public function modification(array $data){
    	$this->modification = $data;
    	return $this;
    }


}