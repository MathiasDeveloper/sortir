<?php

namespace App\Util;

use Psr\Log\LoggerInterface;

/**
 * Class Logger
 * @package App\Util
 */
class Logger implements LoggerInterface
{
    /**
     * @var Logger $instance
     */
    private static Logger $instance;

    /**
     * @var LoggerInterface $logger
     */
    private static LoggerInterface $logger;

    /**
     * Logger constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

    /**
     * @return Logger
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Logger(self::$logger);
        }
        return self::$instance;
    }

    /**
     * @inheritDoc
     */
    public function emergency($message, array $context = array())
    {
        self::getInstance()->emergency($message, $context);
    }

    /**
     * @inheritDoc
     */
    public function alert($message, array $context = array())
    {
        self::getInstance()->alert($message, $context);
    }

    /**
     * @inheritDoc
     */
    public function critical($message, array $context = array())
    {
        self::getInstance()->critical($message, $context);
    }

    /**
     * @inheritDoc
     */
    public function error($message, array $context = array())
    {
        self::getInstance()->error($message, $context);
    }

    /**
     * @inheritDoc
     */
    public function warning($message, array $context = array())
    {
        self::getInstance()->warning($message, $context);
    }

    /**
     * @inheritDoc
     */
    public function notice($message, array $context = array())
    {
        self::getInstance()->notice($message, $context);
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = array())
    {
        self::getInstance()->info($message, $context);
    }

    /**
     * @inheritDoc
     */
    public function debug($message, array $context = array())
    {
        self::getInstance()->debug($message, $context);
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        self::getInstance()->log($message, $context);
    }
}
