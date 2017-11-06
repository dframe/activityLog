<?php
namespace Dframe\ActivityLog;

interface Driver {

	public function push($loggedId, $on, $entity, $log);

}
