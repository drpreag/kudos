<?php

namespace KudosApp;
require 'vendor/autoload.php';

$counter = new Counter;

if ($counter->seedData())
    echo "Data seeded succefuly (counters table)\n";
else
    echo "Data seed failed\n";