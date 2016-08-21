<?php

include_once("includes/functions.php");
include_once("includes/helpers.php");
include_once("includes/forms.php");

$admin_name = "processwire";

check_requirements();

$site_url = $pages->get("/")->httpUrl;
$site_name = $pages->get("/$admin_name/settings/")->site_name;
$site_title = $pages->get("/$admin_name/settings/")->site_title;
$site_meta_description = $pages->get("/$admin_name/settings/")->site_meta_description;
$copyright = $pages->get("/$admin_name/settings/")->copyright;

$headline = $page->get("headline|title");

$bodycopy = $page->body;
$sidebar = $page->sidebar;
$subnav = $page->children;

# Store the page for edit link
$target = $page;
