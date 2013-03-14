<?php
/**
 * Edit service provider
 */

$title = elgg_echo("Edit a service provider");
elgg_push_breadcrumb($title);

$guid = get_input('guid');
$provider = get_entity($guid);

if (!elgg_instanceof($provider, 'object', 'service_provider')) {
	forward('/', 404);
}

$vars = service_providers_prepare_form_vars($provider);
$content = elgg_view_form('service_providers/save', array('enctype' => 'multipart/form-data'), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);