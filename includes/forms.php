<?php

function renderCatalogForm($backend_email, $subject) {
  $out = '';

  $modules = wire('modules');

  $input = wire('input');

  $sanitizer = wire('sanitizer');

  // Create the new <form>
  $form = $modules->get("InputfieldForm");
  $form->action = "./";
  $form->method = "post";
  $form->attr("id+name",'contact-form');

    // Set markup for form elements
  $form->setMarkup(array(
    'list' => "<div {attrs}>{out}</div>",
    'item' => "<div {attrs}>{out}</div>",
    'item_label' => "<label for='{for}'>{out}</label>",
    'item_content' => "{out}",
    'item_error' => "<p class=\"error\">{out}</p>",
    'item_description' => "<p>{out}</p>",
    'item_head' => "<h2>{out}</h2>",
    'item_notes' => "<p class='notes'>{out}</p>",
  ));

    // Set classes for form elements
  $form->setClasses(array(
    'list' => 'form-list',
    'list_clearfix' => '',
    'item' => '{class}',
    'item_required' => 'required',
    'item_error' => '',
    'item_collapsed' => '',
    'item_column_width' => '',
    'item_column_width_first' => ''
  ));

  // New field: First name
  $field = $modules->get("InputfieldText");
  $field->label = __("First name");
  $field->attr('id+name','firstname');
  $field->required = 1;
  $form->append($field);

  // New field: Last name
  $field = $modules->get("InputfieldText");
  $field->label = __("Last name");
  $field->attr('id+name','lastname');
  $field->required = 1;
  $form->append($field);

  // New field: E-Mail
  $field = $modules->get("InputfieldEmail");
  $field->label = __("E-mail");
  $field->attr('id+name','email');
  $field->required = 1;
  $form->append($field);

  // New field: Phone
  $field = $modules->get("InputfieldText");
  $field->label = __("Your phone");
  $field->attr('id+name','phone');
  $field->required = 1;
  $form->append($field);

  // New field: Message
  $field = $modules->get("InputfieldTextarea");
  $field->label = __("Message");
  $field->attr('id+name', 'message');
  $field->required = 1;
  $form->append($field);

  // Submit button!
  $submit = $modules->get("InputfieldSubmit");

  $submit->attr("id+name", "submit");
  $form->append($submit);

  // POST request, process the form
  if($input->post->submit) {
      $form->processInput($input->post);

      $firstname = $sanitizer->text($input->post->firstname);
      $lastname = $sanitizer->text($input->post->lastname);
      $email = $sanitizer->email($input->post->email);
      $message = $sanitizer->text($input->post->message);
      $phone = $sanitizer->text($input->post->phone);

      if($form->getErrors()) {
        $out .= $form->render();
      } else {
        // Process the form here!

        $mail = wireMail();
        $mail->to($backend_email)->from($email);
        $mail->subject($subject);


        $body = "First name: " . $firstname . "\n";
        $body .= "Last name: " . $lastname . "\n";
        $body .= "E-Mail: " . $email . "\n";
        $body .= "Phone: " . $phone . "\n\n";
        $body .= "Message:\n" . $message;

        $mail->body($body);

        echo '<pre>'.$body.'</pre>';
        #$numSent = $mail->send();

        $out .= '<p>'.__("You submission was completed! Thanks for your time").'</p>';

      }
  } else {
      // GET request, simply show the form
      $out .= $form->render();
  }

  return $out;
}
