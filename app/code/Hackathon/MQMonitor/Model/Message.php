<?php
/**
 * Created by PhpStorm.
 * User: roettigl
 * Date: 15.10.16
 * Time: 11:16
 */

namespace Hackathon\MQMonitor\Model;

use Hackathon\MQMonitor\Api\MessageInterface;

class Message implements MessageInterface
{
    /**
     * @var string
     */
    private $text;

    /**
     * @param string $text
     *
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}