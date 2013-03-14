<?php
/**
 * Delete a provider
 */

$guid = get_input('guid');
$provider = get_entity($guid);

if (elgg_instanceof($provider, 'object', 'service_provider') && $provider->canEdit()) {
	if ($provider->delete()) {
		system_message("Service provider deleted");
		forward(REFERRER);
	}
}

register_error('Could not delete service provider.');
forward(REFERER);
