<?php

/*
  Usage: Set the access control in the template of the secured page
  to 'yes'. Uncheck the guest access and set the redirect page to custom value:

  Redirect to another URL: /login?r={id}
*/

if($user->isLoggedin()) {
  $session->message(sprintf(__("You are already logged in, %s!"), $user->name));
  // TODO: Specify the redirect path
  $session->redirect('/');
}

$form = $modules->get("InputfieldForm");
$form->action = "./";
$form->method = "post";
$form->attr("id+name",'login-form');

$field = $modules->get("InputfieldText");
$field->label = "Username";
$field->attr('id+name', 'username');
$field->required = 1;
$form->append($field);

$field = $modules->get("InputfieldText");
$field->label = "Password";
$field->attr('id+name', 'password');
$field->required = 1;
$field->attr('type', 'password');
$form->append($field);

$field = $modules->get("InputfieldHidden");
$field->attr('id+name', 'redirect');
$form->append($field);
$field->value = $sanitizer->intUnsigned($input->r);

$submit = $modules->get("InputfieldSubmit");
$submit->attr("value", "Login");
$submit->attr("id+name", "submit");
$form->append($submit);

if($input->post->submit) {
  $form->processInput($input->post);

  $username = $form->get("username");
  $password = $form->get("password");
  $redirect = $form->get("redirect");

  if($username->value && $password->value) {
    try {
      $new_user = $session->login($username->value, $password->value);
      if($new_user) {
        $session->message(sprintf(__("Welcome back, %s!"), $new_user->name));

        if($redirect->value) {
          $page_id = $sanitizer->intUnsigned($redirect->value);
          $session->redirect($pages->get($page_id)->url());
        } else {
          $session->redirect("/");
        }
      } else {
        $password->error(__("Combination of username/password not found"));
      }
    } catch(Exception $ex) {
      $password->error($ex->getMessage());
    }
  }
}

$bodycopy = renderView($page, null, array('form' => $form));
