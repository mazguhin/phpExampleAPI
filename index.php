<?php

require 'core/bootstrap.php';

require Router::load('config/routes.php')->direct(Request::uri(), Request::method());
