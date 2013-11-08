<?php
/**
 * Returns a service provider icon
 *
 * @uses $vars['entity']     The user entity. If none specified, the current user is assumed.
 * @uses $vars['size']       The size - tiny, small, medium or large. (medium)
 * @uses $vars['use_hover']  Display the hover menu? (true)
 * @uses $vars['use_link']   Wrap a link around image? (true)
 * @uses $vars['class']      Optional class added to the .elgg-avatar div
 * @uses $vars['img_class']  Optional CSS class added to img
 * @uses $vars['link_class'] Optional CSS class for the link
 * @uses $vars['href']       Optional override of the link href
 */

$provider = elgg_extract('entity', $vars);
$size = elgg_extract('size', $vars, 'medium');

if (!array_key_exists($size, ServiceProvider::$iconSizes)) {
	$size = 'medium';
}

$width = ServiceProvider::$iconSizes[$size];

if (!($provider instanceof ServiceProvider)) {
	return true;
}

$title = htmlspecialchars($provider->title, ENT_QUOTES, 'UTF-8', false);
$icon_url = elgg_format_url($provider->getIconURL($size));

echo elgg_view('output/img', array(
	'src' => $icon_url,
	'alt' => $title,
	'title' => $title,
	'width' => $width
));