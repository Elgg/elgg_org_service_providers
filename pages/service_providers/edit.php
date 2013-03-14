<?php
/**
 * Edit service provider
 */

$guid = get_input('guid');
$provider = get_entity($guid);

if (!elgg_instanceof($provider, 'object', 'service_provider')) {
	forward('/', 404);
}

elgg_push_breadcrumb($provider->title);
$title = elgg_echo("Edit");
elgg_push_breadcrumb($title);


$vars = service_providers_prepare_form_vars($provider);
$content = elgg_view_form('service_providers/save', array('enctype' => 'multipart/form-data'), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);