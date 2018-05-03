<?php
namespace Libs\Extensions\ActivityLog;

/**
 * Dframe/activityLog
 * Copyright (c) Sławomir Kaleta
 *
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 */

class Change
{

    public function interpreter($key)
    {
        $this->interpreter = array(
            'users' => array('id', 'firstname', 'lastname')
        );

        return $this->interpreter[$key];
    }

    public function build($before, $after)
    {

        if (!empty(array_diff_key($before, $after))) {
            throw new \Exception("Keys in array MUST be same", 1);
        }

        foreach ($after as $key => $value) {
            if ($before[$key] == $value) {
                unset($before[$key]);
                unset($after[$key]);
            }
        }
        
        $this->changes = array('before' => $before, 'after' => $after);
        return $this;
    }

}