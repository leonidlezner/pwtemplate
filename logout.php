<?php

if($user->isLoggedin()) {
  $session->logout();
  $session->message(__("User was successfully logged out!"));
}

$session->redirect("/");
