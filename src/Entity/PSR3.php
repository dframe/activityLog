<?php

namespace Dframe\ActivityLog\Entity;

/**
 * Dframe/ActivityLog
 * Copyright (c) Sławomir Kaleta
 *
 * @license https://github.com/dusta/activityLog/blob/master/LICENCE
 */
class PSR3
{
    /**
     * Action constructor.
     */
    public function __construct()
    {
        return $this;
    }

    public function build($level, $message, array $context = [])
    {
        return [
            'level' => $level,
            'message' => $this->interpolate($message, $context),
            'context' => $context
        ];
    }

    public function interpolate($message, array $context = [])
    {
        // build a replacement array with braces around the context keys
        $replace = [];
        foreach ($context as $key => $val) {
            // check that the value can be casted to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
