<?php

namespace Dframe\ActivityLog\Demo\Entity;

/**
 * Dframe/ActivityLog
 * Copyright (c) Sławomir Kaleta
 *
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 */
class Change
{
    /**
     * @param $key
     *
     * @return mixed
     */
    public function interpreter($key)
    {
        $this->interpreter = [
            'users' => ['id', 'firstname', 'lastname']
        ];

        return $this->interpreter[$key];
    }

    /**
     * @param $before
     * @param $after
     *
     * @return $this
     */
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

        $this->changes = ['before' => $before, 'after' => $after];
        return $this;
    }
}
