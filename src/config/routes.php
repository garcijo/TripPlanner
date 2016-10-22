<?php

use Web\Action\HomePageAction;

$app->get('/home', HomePageAction::class)->setName('home');