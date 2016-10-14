<?php

return array (
  'backend' => 
  array (
    'frontName' => 'admin',
  ),
    'queue' => [
        'amqp' => [
            'host' => '172.17.0.4',
            'port' => '5672',
            'user' => 'guest',
            'password' => 'guest',
            'virtualhost' => '/',
            'ssl' => ''
        ]
    ],
  'db' => 
  array (
    'connection' => 
    array (
      'indexer' => 
      array (
        'host' => 'localhost',
        'dbname' => 'magento',
        'username' => 'root',
        'password' => '',
        'model' => 'mysql4',
        'engine' => 'innodb',
        'initStatements' => 'SET NAMES utf8;',
        'active' => '1',
        'persistent' => NULL,
      ),
      'default' => 
      array (
        'host' => 'localhost',
        'dbname' => 'magento',
        'username' => 'root',
        'password' => '',
        'model' => 'mysql4',
        'engine' => 'innodb',
        'initStatements' => 'SET NAMES utf8;',
        'active' => '1',
      ),
    ),
    'table_prefix' => '',
  ),
  'crypt' => 
  array (
    'key' => '866cdc3d220068bb7b5b1731f50104d8',
  ),
  'session' => 
  array (
    'save' => 'db',
  ),
  'resource' => 
  array (
    'default_setup' => 
    array (
      'connection' => 'default',
    ),
  ),
  'x-frame-options' => 'SAMEORIGIN',
  'MAGE_MODE' => 'developer',
  'cache_types' => 
  array (
    'config' => 1,
    'layout' => 1,
    'block_html' => 1,
    'collections' => 1,
    'reflection' => 1,
    'db_ddl' => 1,
    'eav' => 1,
    'customer_notification' => 1,
    'target_rule' => 1,
    'full_page' => 1,
    'config_integration' => 1,
    'config_integration_api' => 1,
    'translate' => 1,
    'config_webservice' => 1,
  ),
  'install' => 
  array (
    'date' => 'Wed, 05 Oct 2016 15:09:54 +0000',
  ),
);
