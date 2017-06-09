<?php
namespace Entity\activityLog;

/**
 * Dframe/activityLog
 * Copyright (c) Sławomir Kaleta
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 *
 */

class user
{
	public $id = null;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setAdd($data){
        $this->id = $id;
    }

    public function setRemove($data){
        $this->id = $id;
    }

    public function setChanges($before, $after){
        $this->id = $id;
    }
    
}