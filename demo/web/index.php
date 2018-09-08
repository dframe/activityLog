<?php

/**
 * DframeFramework
 * Copyright (C) Sławomir Kaleta
 *
 * @license https://github.com/dusta/Dframe/blob/master/LICENCE
 */

use Dframe\ActivityLog\Activity;

require_once __DIR__ . '/../../vendor/autoload.php';

$log = (new Activity(new \Dframe\ActivityLog\Demo\Drivers\FileLog()));
$log->log('system')->entity(\Dframe\ActivityLog\Demo\Entity\Action::class, ['Hello Word!'])->push();

echo '<pre>';
var_dump($log->logs(null, null, null, null, null));
