<?php
/**
 * Elgg.org service providers
 */

elgg_register_event_handler('init', 'system', 'service_providers_init');

function service_providers_init() {

	$root = dirname(__FILE__);

	// actions
	$action_path = "$root/actions/service_providers";
	elgg_register_action('service_providers/save', "$action_path/save.php");
	elgg_register_action('service_providers/delete', "$action_path/delete.php");

	elgg_register_page_handler('service_providers', 'service_providers_page_handler');

	elgg_register_entity_url_handler('object', 'service_providers', 'service_provider_url');
}

/**
 *  All:     service_providers/all
 *  One:     service_providers/view/:guid/:title
 *  Add:     service_providers/add
 *  Edit:    service_providers/edit/:guid
 *
 * @param array $page
 * @return bool
 */
function service_providers_page_handler($page) {

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$pages = dirname(__FILE__) . '/pages/service_providers';

	switch ($page[0]) {
		case "all":
			include "$pages/all.php";
			break;

		case "view":
			set_input('guid', $page[1]);
			include "$pages/view.php";
			break;

		case "add":
			gatekeeper();
			include "$pages/add.php";
			break;

		case "edit":
			gatekeeper();
			set_input('guid', $page[1]);
			include "$pages/edit.php";
			break;

		default:
			return false;
	}

	elgg_pop_context();
	return true;
}

/**
 * Prepare the add/edit form variables
 *
 * @param ServiceProvider $service_provider A service_provider object.
 * @return array
 */
function service_providers_prepare_form_vars($service_provider = null) {
	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'provider_url' => '',
		'community_profile_url' => '',
		'expires' => strtotime('+1 year'),
		
		'guid' => null,
		'entity' => $service_provider,
	);

	if ($service_provider) {
		foreach (array_keys($values) as $field) {
			if (isset($service_provider->$field)) {
				$values[$field] = $service_provider->$field;
			}
		}
	}

	if (elgg_is_sticky_form('service_provider')) {
		$sticky_values = elgg_get_sticky_values('service_provider');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('service_provider');

	return $values;
}