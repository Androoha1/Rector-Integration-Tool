<?php

require_once __DIR__ . '/../vendor/autoload.php';

use RectorIntegrationTool\Integrator;

new Integrator(require "configuration.php")->integrate();
