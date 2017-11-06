<?php
namespace Libs\Extensions\ActivityLog;

/**
 * Dframe/activityLog
 * Copyright (c) Sławomir Kaleta
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 *
 */

class Delete
{

    public function __construct($before){
        $this->before = array('before' => $before);
        return $this;
    }
    
}
