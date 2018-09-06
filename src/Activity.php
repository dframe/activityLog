<?php

namespace Dframe\ActivityLog;

/**
 * Dframe/activityLog
 * Copyright (c) Sławomir Kaleta
 *
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 */

class Activity
{

    /**
     * @param Object $driver
     * @param Int    $loggedId
     *
     * @return object
     */
    public function __construct($driver, $loggedId)
    {
        $this->driver = $driver;
        $this->loggedId = $loggedId;

        $this->dateTimeZone = "UTC"; // UTC, America/New_York itd.
    }

    /**
     * @param      $e
     * @param      $file
     * @param null $path
     *
     * @return mixed
     */
    public static function load($e, $file, $path = null)
    {
        $change = new change();
        return $change->build($file, $path);
    }

    /**
     * @param $dateTimeZone
     */
    public function setTimeZone($dateTimeZone)
    {
        $this->dateTimeZone = $dateTimeZone;
    }

    /**
     * @param string $loggedId
     */
    public function loggedId($loggedId)
    {
        $this->loggedId = $loggedId;
    }

    /**
     * @param      $entity
     * @param null $arg
     *
     * @return $this
     */
    public function entity($entity, $arg = null)
    {
        $class = new \ReflectionClass($entity);
        $this->entity = call_user_func_array([new $entity, "build"], $arg);
        $this->entityType = $class->getName();
        return $this;
    }

    /**
     * @param $type
     * @param $id
     *
     * @return $this
     */
    public function on($type, $id)
    {
        $this->on = [];
        $this->on['table'] = $type;
        $this->on['id'] = $id;
        return $this;
    }

    /**
     * @param string $log
     *
     * @return $this
     */
    public function log(string $log)
    {
        $this->log = $log;
        return $this;
    }

    /**
     * @return array
     */
    public function push()
    {
        $dateUTC = new \DateTime("now", new \DateTimeZone($this->dateTimeZone));
        $push = $this->driver->push($this->loggedId, $this->on ?? '', ['entity' => $this->entityType, 'data' => $this->entity], $this->log);
        if ($push['return'] == true) {
            return ['return' => true];
        }

        return ['return' => false];
    }

    /**
     * @param $whereArray
     *
     * @return mixed
     */
    public function logsCount($whereArray)
    {
        $logsCount = $this->driver->logsCount($whereArray);
        return $logsCount;
    }

    /**
     * @param int    $start
     * @param int    $limit
     * @param array  $where
     * @param string $order
     * @param string $sort
     *
     * @return array
     */
    public function logs($start, $limit, $where, $order, $sort)
    {
        $logs = $this->driver->logs($start, $limit, $where, $order, $sort);

        foreach ($logs['data'] as $key => $value) {
            $explode = explode(".", $value['log_type']);
            $table = $explode[0];
            $entity = new $value['log_entity'];
            $columns = $entity->interpreter($explode[0]);

            $where = [(string)$value['log_type'] => (int)$value['changed_id']];

            $logs['data'][$key]['table'] = $this->driver->readTypes($table, $columns, [$explode['1'] => $value['changed_id']])['data'];
        }


        return ['return' => true, 'data' => $logs];
    }
}
