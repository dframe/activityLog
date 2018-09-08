<?php

namespace Dframe\ActivityLog\Demo\Drivers;

define('APP_DIR', __DIR__ . '/../');

/**
 * Dframe/ActivityLog
 * Copyright (c) Sławomir Kaleta
 *
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 */
class FileLog implements \Dframe\ActivityLog\Driver
{
    const FILE_DB = APP_DIR . 'Logs' . DIRECTORY_SEPARATOR . 'db.txt';

    public function push($loggedId, $on, $entity, $log)
    {
        $data = [];
        $data['loggedId'] = '1';
        $data['on'] = $on;
        $data['entity'] = $entity;
        $data['log'] = $log;

        $fp = fopen(self::FILE_DB, 'rw+');
        if (!flock($fp, LOCK_EX)) {
            return false;
        }

        if (filesize(self::FILE_DB) > 0) {
            $contents = null;
            while (!feof($fp)) {
                $contents .= fread($fp, 8192);
            }

            $jsondecode = json_decode($contents, true);
            $jsondecode[] = $data;

            flock($fp, LOCK_UN);
            fclose($fp);

            $fp = fopen(self::FILE_DB, 'w+');
            $result = fwrite($fp, json_encode($jsondecode));
        } else {
            $result = fwrite($fp, json_encode($data));
        }

        flock($fp, LOCK_UN);
        fclose($fp);


        return $result !== false;
    }

    /**
     * @param        $start
     * @param        $limit
     * @param        $whereArray
     * @param string $order
     * @param string $sort
     *
     * @return mixed
     */
    public function logs($start, $limit, $where, $order, $sort)
    {
        if (!file_exists(self::FILE_DB)) {
            return false;
        }

        $fp = fopen(self::FILE_DB, 'r');

        $contents = null;
        while (!feof($fp)) {
            $contents .= fread($fp, 8192);
        }

        fclose($fp);

        $data = json_decode($contents, true);
        return ['return' => true, 'data' => $data];
    }
}
