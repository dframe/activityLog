<?php

namespace Dframe\ActivityLog;

/**
 * Interface Driver
 * Copyright (c) Sławomir Kaleta
 *
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 */
interface Driver
{
    /**
     * @param string $loggedId
     * @param string $on
     * @param object $entity
     * @param $log
     *
     * @return mixed
     */
    public function push($loggedId, $on, $entity, $log);
}
