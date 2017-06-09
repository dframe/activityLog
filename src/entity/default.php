<?php
namespace Dframe\activityLog\Entity;

/**
 * Dframe/activityLog
 * Copyright (c) Sławomir Kaleta
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 *
 */

class default
{

    public function setAdd($data){
        $this->add = $data;
    }

    public function setRemove($data){
        $this->remove = $data;
    }

    public function setChanges($before, $after){
        $this->changes = array('before' => $before, 'after' => $after);
    }
    
}