<?php

/**
 * DframeFramework
 * Copyright (C) Sławomir Kaleta
 *
 * @license https://github.com/dusta/Dframe/blob/master/LICENCE
 */

use Dframe\ActivityLog\Activity;
use Dframe\ActivityLog\Demo\Drivers\FileLog;

require_once __DIR__ . '/../../vendor/autoload.php';

$log = (new Activity(new FileLog()));
$log->log('Hello Word!')->entity(\Dframe\ActivityLog\Demo\Entity\Action::class)->push();

echo '<pre>';
var_dump($log->logs());
