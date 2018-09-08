<?php

namespace Dframe\ActivityLog\Helper;

/**
 * Class Psr16Adapter
 *
 * @package phpFastCache\Helper
 */
class Psr3Adapter extends \Psr\Log\AbstractLogger implements \Psr\Log\LoggerInterface
{

    /**
     * Psr3Adapter constructor.
     *
     * @param \Dframe\ActivityLog\Activity $log
     * @param                              $communique
     * @param                              $entity
     */
    public function __construct(\Dframe\ActivityLog\Activity $log, $communique, $entity)
    {
        $this->log = $log;
        $this->communique = $communique;
        $this->entity = $entity;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $this->log->log($this->communique)->entity($this->entity, [
            'level' => $level,
            'message' => $message,
            'context' => $context
        ])->push();
    }
}
