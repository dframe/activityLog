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
	
    public function __construct($driver, $loggedId){
    	$this->driver = $driver;
        $this->loggedId = $loggedId;
    }

    public function loggedId($loggedId){
        $this->loggedId = $loggedId;
    }

    public function entity($entity){
        $class = new \ReflectionClass($entity);
        $this->entity = $entity;
    	$this->entityType = $class->getName();
    	return $this;
    }

    public function on($type, $id){
        $this->on = array();
        $this->on['table'] = $type;
        $this->on['id'] = $id;
        return $this;
    }


    public function log(string $log){
    	$this->log = $log;
    	return $this;
    }

    public function push(){
        $push = $this->driver->push($this->loggedId, $this->on, array('entity' => $this->entityType, 'data' => $this->entity), $this->log);
        if($push['return'] == true)
            return array('return' => true);

        return array('return' => false);
    }


    public function read(){
        
    }


}