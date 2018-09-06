<?php

namespace Dframe\ActivityLog;

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
