<?php

namespace Dframe\ActivityLog\Demo\Entity;

/**
 * Dframe/ActivityLog
 * Copyright (c) Sławomir Kaleta
 *
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 */
class Action
{
    /**
     * Action constructor.
     */
    public function __construct()
    {
        return $this;
    }

    public function build($message)
    {
        return ['message' => $message];
    }
}
