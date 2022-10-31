<?php

/**
 * @file
 * Rest API Interface
 */

use PetBest\RestService;

require_once('common.php');
RestService::create($database)->processApi();

?>
