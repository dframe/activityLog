<?php

namespace Dframe\ActivityLog\Demo\Drivers;

/**
 * Dframe/ActivityLog
 * Copyright (c) Sławomir Kaleta
 *
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 */

class MysqlLogModel implements \Dframe\ActivityLog\Driver
{
    /**
     * @param string $loggedId
     * @param string $on
     * @param object $entity
     * @param        $log
     *
     * @return mixed
     */
    public function push($loggedId, $on, $entity, $log)
    {
        $data = [
            'logged_id' => $loggedId,
            'log_entity' => $entity['entity'],
            'log_data' => json_encode($entity['data'] ?? ''),
            'log_message' => $log
        ];

        if (isset($on['table']) and isset($on['id'])) {
            $data['log_type'] = $on['table'];
            $data['changed_id'] = $on['id'];
        }

        $getLastInsertId = $this->baseClass->db->insert('logs', $data)->getLastInsertId();
        return $this->methodResult(true, ['lastInsertId' => $getLastInsertId]);
    }

    /**
     * @param $whereArray
     *
     * @return mixed
     */
    public function logsCount($where)
    {
        $query = $this->baseClass->db->prepareQuery('SELECT count(*) AS count FROM `logs`');
        $query->prepareWhere($where);
        $row = $this->baseClass->db->pdoQuery($query->getQuery(), $query->getParams())->result();
        return $row['count'];
    }

    /**
     * @param        $start
     * @param        $limit
     * @param        $where
     * @param string $order
     * @param string $sort
     *
     * @return mixed
     */
    public function logs($where = [], $order = 'id', $sort = 'DESC', $limit = 30, $start = 0)
    {
        $query = $this->baseClass->db->prepareQuery('SELECT * FROM `logs`');
        $query->prepareWhere($where);
        $query->prepareOrder($order, $sort);
        $query->prepareLimit($limit, $start);

        $results = $this->baseClass->db->pdoQuery($query->getQuery(), $query->getParams())->results();
        return $this->methodResult(true, ['data' => $results]);
    }


    /**
     * @param       $table
     * @param       $columns
     * @param array $where
     *
     * @return mixed
     */
    public function readTypes($table, $columns, array $where)
    {
        $row = $this->baseClass->db->select($table, $columns, $where)->result();
        return $this->methodResult(true, ['data' => $row]);
    }
}
