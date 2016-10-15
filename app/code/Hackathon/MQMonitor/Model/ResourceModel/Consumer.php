<?php

namespace Hackathon\MQMonitor\Model\ResourceModel;

use Hackathon\MQMonitor\Api\MessageInterface;
use Psr\Log\LoggerInterface;

class Consumer
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * HackathonTest constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param MessageInterface $message
     */
    public function processMessage(MessageInterface $message)
    {
        $this->logger->critical($message->getText());
    }

}