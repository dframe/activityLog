<?php
namespace Dframe\activityLog;

interface Driver {

	public function push($loggedId, $on, $entity, $log);

}