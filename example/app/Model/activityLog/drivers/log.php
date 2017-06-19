<?php
namespace Model\activityLog\drivers;

/**
* @author Sławek Kaleta
*/
class logModel extends \Model\Model implements \Dframe\activityLog\Driver
{
	
    public function push($loggedId, $on, $entity, $log){

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
}