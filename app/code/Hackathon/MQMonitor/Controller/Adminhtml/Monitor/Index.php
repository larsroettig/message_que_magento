<?php

namespace Hackathon\MQMonitor\Controller\Adminhtml\Monitor;

use Hackathon\MQMonitor\Api\MessageInterfaceFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\MessageQueue\PublisherInterface;


class Index extends Action
{

    const TOPIC_NAME = 'hackaton.test';


    /**
     * @var PublisherInterface
     */
    private $publisher;


    /**
     * @var \Hackathon\MQMonitor\Api\MessageInterfaceFactory
     */
    private $messageFactory;

    /**
     * Index constructor.
     *
     * @param Action\Context $context
     */
    public function __construct(Context $context, PublisherInterface $publisher, MessageInterfaceFactory $messageFactory
    ) {
        parent::__construct($context);
        $this->publisher = $publisher;
        $this->messageFactory = $messageFactory;
    }


    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var  \Hackathon\MQMonitor\Api\MessageInterface $message */
        try {
            $message = $this->messageFactory->create();
            $message->setText("foobarss");
            $this->publisher->publish(self::TOPIC_NAME, $message);
        } catch (\Exception $exception) {
            var_export($exception->getMessage());
        }


        die('message create');
    }

}
