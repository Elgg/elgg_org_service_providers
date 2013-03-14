<?php
/**
 * Add service provider
 */

$title = elgg_echo("Add a service provider");
elgg_push_breadcrumb($title);

$vars = service_providers_prepare_form_vars();
$content = elgg_view_form('service_providers/save', array('enctype' => 'multipart/form-data'), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);