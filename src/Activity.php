<?php

namespace Dframe\ActivityLog;

/**
 * Dframe/ActivityLog
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
    public function __construct($driver, $loggedId = null)
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
        if (!is_null($arg)) {
            $this->entity = call_user_func_array([new $entity, "build"], $arg);
        } else {
            $this->entity = new $entity;
        }
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
     * @param array  $where
     * @param string $order
     * @param string $sort
     * @param int    $limit
     * @param int    $start
     *
     * @return array
     */
    public function logs($where = [], $order = 'id', $sort = 'DESC', $limit = 30, $start = 0)
    {
        $logs = $this->driver->logs($where, $order, $sort, $limit, $start);
        if (isset($logs['return']) and $logs['return'] === true) {
            foreach ($logs['data'] as $key => $value) {
                if (isset($value['log_type'])) {
                    $explode = explode(".", $value['log_type']);

                    $entity = new $value['log_entity'];
                    $table = $explode[0];
                    $columns = $entity->interpreter($explode[0]);

                    $logs['data'][$key]['table'] = $this->driver->readTypes($table, $columns, [$explode['1'] => $value['changed_id']])['data'];
                }
            }


            return ['return' => true, 'data' => $logs];
        }

        return ['return' => false];
    }
}
