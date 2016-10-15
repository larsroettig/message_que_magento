<?php


namespace Hackathon\MQMonitor\Api;

/**
 * Created by PhpStorm.
 * User: roettigl
 * Date: 15.10.16
 * Time: 10:46
 */
interface MessageInterface
{
    /**
     * @param string $text
     * @return void
     */
    public function setText($text);

    /**
     * @return string
     */
    public function getText();


}