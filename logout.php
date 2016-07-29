<?php

$session->logout();
$session->message(__("You was successfully logged out!"));
$session->redirect("/");
