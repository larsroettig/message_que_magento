<?php

namespace TechDivision\Hello\Controller\Hello;

class World extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context)
    {
        return parent::__construct($context);
    }

    public function execute()
    {
        echo PHP_VERSION . ' ' . __METHOD__ . ':' . __LINE__;
    }
}
