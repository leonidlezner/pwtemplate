<?php

$form = renderCatalogForm($page->email, "Contact via my new ProcessWire page");

$bodycopy = renderView($page, null, array(
  'form' => $form
));
