<?php
/**
 * Service provider
 */

$full = elgg_extract('full_view', $vars, FALSE);
$provider = elgg_extract('entity', $vars, FALSE);

if (!$provider) {
	return;
}

$icon = elgg_view_entity_icon($provider, 'medium');

// no full view.

$description = elgg_view('output/longtext', array(
	'value' => $provider->description,
	'class' => 'pbl'
));

if (elgg_is_logged_in()) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'service_providers',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

$title_link = elgg_view('output/url', array(
	'text' => $provider->title,
	'href' => $provider->provider_url,
	'is_trusted' => true,
));

$community_link = false;
$community_url = $provider->community_profile_url;
if ($community_url) {
	$community_link = elgg_view('output/url', array(
		'text' => 'Elgg Community Profile',
		'href' => $community_url,
		'is_trusted' => true,
	));
}

$params = array(
	'title' => $title_link,
	'entity' => $provider,
	'metadata' => $metadata,
	'subtitle' => $community_link,
	'content' => $description,
);

$params = $params + $vars;
$body = elgg_view('object/elements/summary', $params);

echo elgg_view_image_block($icon, $body);