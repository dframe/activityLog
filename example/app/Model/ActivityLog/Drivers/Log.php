<?php
namespace Model\ActivityLog\Drivers;

/**
 * @author Sławek Kaleta
 */
class LogModel extends \Model\Model implements \Dframe\ActivityLog\Driver
{
    
    public function push($loggedId, $on, $entity, $log)
    {

        $data = array(
        'logged_id' => $loggedId,
        'log_type' => $on['table'],
        'changed_id' => $on['id'],
        'log_entity' => $entity['entity'],
        'log_data' => json_encode($entity['data']),
        'log_message' => $log
        );

        $getLastInsertId = $this->baseClass->db->insert('logs', $data)->getLastInsertId();        
        return $this->methodResult(true, array('lastInsertId' => $getLastInsertId));

    }

    public function logsCount($whereArray)
    {

        $query = $this->baseClass->db->prepareQuery('SELECT count(*) AS count FROM `logs`');
        $query->prepareWhere($whereArray);
        $row = $this->baseClass->db->pdoQuery($query->getQuery(), $query->getParams())->result();
        return $row['count'];

    }

    public function logs($start, $limit, $whereArray, $order = 'logs.log_id', $sort = 'DESC')
    {

        $query = $this->baseClass->db->prepareQuery('SELECT * FROM `logs`');
        $query->prepareWhere($whereArray);
        $query->prepareOrder($order, $sort);
        $query->prepareLimit($limit, $start);

        $results = $this->baseClass->db->pdoQuery($query->getQuery(), $query->getParams())->results();
        return $this->methodResult(true, array('data' => $results));
    }


    public function readTypes($table, $columns, array $where)
    {
        $row = $this->baseClass->db->select($table, $columns, $where)->result();
        return $this->methodResult(true, array('data' => $row));
    }

}
