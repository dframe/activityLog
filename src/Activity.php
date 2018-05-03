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
     * @param Int $loggedId
     *
     * @return object
     */

    public function __construct($driver, $loggedId)
    {
        $this->driver = $driver;
        $this->loggedId = $loggedId;

        $this->dateTimeZone = "UTC"; // UTC, America/New_York itd.
    }

    public function setTimeZone($dateTimeZone)
    {
        $this->dateTimeZone = $dateTimeZone;
    }

    public function loggedId($loggedId)
    {
        $this->loggedId = $loggedId;
    }

    public function entity($entity, $arg = null)
    {
        $class = new \ReflectionClass($entity);
        $this->entity = call_user_func_array(array(new $entity, "build"), $arg);
        $this->entityType = $class->getName();
        return $this;
    }

    public function on($type, $id)
    {
        $this->on = array();
        $this->on['table'] = $type;
        $this->on['id'] = $id;
        return $this;
    }

    public function log(string $log)
    {
        $this->log = $log;
        return $this;
    }

    public static function load($e, $file, $path = null)
    {
        $change = new change();
        return $change->build($file, $path);

    }

    public function push()
    {
        $dateUTC = new \DateTime("now", new \DateTimeZone($this->dateTimeZone));
        $push = $this->driver->push($this->loggedId, $this->on ?? '', array('entity' => $this->entityType, 'data' => $this->entity), $this->log);
        if ($push['return'] == true) {
            return array('return' => true);
        }

        return array('return' => false);
    }

    public function logsCount($whereArray)
    {
        $logsCount = $this->driver->logsCount($whereArray);
        return $logsCount;

    }

    public function logs($start, $limit, $where, $order, $sort)
    {
        $logs = $this->driver->logs($start, $limit, $where, $order, $sort);

        foreach ($logs['data'] as $key => $value) {

            $explode = explode(".", $value['log_type']);
            $table = $explode[0];
            $entity = new $value['log_entity'];
            $columns = $entity->interpreter($explode[0]);

            $where = array((string)$value['log_type'] => (int)$value['changed_id']);

            $logs['data'][$key]['table'] = $this->driver->readTypes($table, $columns, array($explode['1'] => $value['changed_id']))['data'];
        }


        return array('return' => true, 'data' => $logs);

    }

}