<?php

function renderBreadcrumbs($page) {
  $result = "";
  $parents = $page->parents();

  if(count($parents) > 0) {
    $result .= "<ol>";

    foreach($parents as $parent) {
      $result .= "<li><a href='{$parent->url}'>{$parent->title}</a></li>";
    }

    $result .= "</ol>";
  }

  return $result;
}

function renderList($start, $stop) {
  $result = "";

  $result .= "<ol>";

  for($i = $start; $i <= $stop; $i++)
  {
    $result .= sprintf('<li><a href="%d">%d</a></li>', $i, $i);
  }

  $result .= "</ol>";

  return $result;
}
