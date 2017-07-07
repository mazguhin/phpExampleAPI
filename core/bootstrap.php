<?php

$app = [];

$app['config'] = require 'config/config.php';

if ($app['config']['debug']) {
  ini_set('error_reporting', E_ALL);
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
}

require 'core/Router.php';
require 'core/Request.php';
require 'core/Helper.php';
require 'core/database/Connection.php';
require 'core/database/QueryBuilder.php';

$app['database'] = new QueryBuilder(
    Connection::make($app['config']['database'])
);
