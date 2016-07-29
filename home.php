<?php

$form = renderCatalogForm("info@xyz.abc", "Contact via my new ProcessWire page");

$bodycopy = renderView($page, 'home', array(
  'form' => $form
));
