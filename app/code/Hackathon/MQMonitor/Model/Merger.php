<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Hackathon\MQMonitor\Model;

use Magento\Framework\MessageQueue\MergerInterface;

class Merger implements MergerInterface
{

    /**
     * @param object[] $messages
     *
     * @return object[]
     */
    public function merge(array $messages)
    {
        return $messages;
    }
}