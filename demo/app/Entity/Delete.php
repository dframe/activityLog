<?php

namespace Dframe\ActivityLog\Demo\Entity;

/**
 * Dframe/ActivityLog
 * Copyright (c) Sławomir Kaleta
 *
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 */
class Delete
{
    /**
     * Delete constructor.
     *
     * @param $before
     */
    public function __construct()
    {
        return $this;
    }

    /**
     * @param $before
     *
     * @return array
     */
    public function build($before)
    {
        return ['before' => $before];
    }
}
