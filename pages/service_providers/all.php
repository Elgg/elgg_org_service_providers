<?php
/**
 * All service providers
 */

elgg_pop_breadcrumb();
elgg_register_title_button();

$content_options = array(
	'type' => 'object',
	'subtype' => 'service_provider',
	'limit' => 10,
	'full_view' => false,
	'view_toggle_type' => true,
//	'list_type' => 'gallery',
	'metadata_name_value_pairs' => array(
		'name' => 'expires',
		'value' => time(),
		'operand' => '>'
	),
	// @todo Eh?
	'order_by' => 'RAND()'
);

// check for expired
if (elgg_is_logged_in()) {
	$filter = get_input('filter', 'unexpired');
	if ($filter == 'expired') {
		$content_options['metadata_name_value_pairs'] = array(
			'name' => 'expires',
			'value' => time(),
			'operand' => '<'
		);
	}
	unset($content_options['order_by']);
}

$content = elgg_list_entities_from_metadata($content_options);

if (!$content) {
	$content = 'None';
}

$title = 'Elgg Service Providers';
$filter_menu = false;

// show tabs for un/expired
if (elgg_is_admin_logged_in()) {
	$title_menu = elgg_view_menu('title', array(
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
	
	$tabs = array(
		'unexpired' => array(
			'text' => 'Unexpired',
			'href' => elgg_http_add_url_query_elements(current_page_url(), array('filter' => 'unexpired')),
			'selected' => ($filter == 'unexpired'),
			'priority' => 100,
		),
		'expired' => array(
			'text' => 'Expired',
			'href' => elgg_http_add_url_query_elements(current_page_url(), array('filter' => 'expired')),
			'selected' => ($filter == 'expired'),
			'priority' => 200,
		),
	);

	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;

		elgg_register_menu_item('filter', $tab);
	}

	$filter_menu = elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}

$sidebar = <<<HTML
<h2>Get Listed</h2>
The service listing feature is currently on hold while we establish the Elgg Foundation. Watch this space and the Elgg Blog for more information!
HTML;

$layout_options = array(
	'filter' => $filter_menu,
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $title
);

$body = elgg_view_layout('content', $layout_options);

echo elgg_view_page($title, $body);