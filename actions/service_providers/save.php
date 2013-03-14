<?php
/**
 * Save a service provider
 */

$guid = get_input('guid');
$title = get_input('title');
$description = get_input('description');
$provider_url = get_input('provider_url');
$community_profile_url = get_input('community_profile_url');
$expires = get_input('expires');

elgg_make_sticky_form('service_provider');

if ($guid) {
	$provider = get_entity($guid);
	if (!elgg_instanceof($provider, 'object', 'service_provider')) {
		register_error("Invalid object");
		forward(REFERRER);
	}
} else {
	$provider = new ServiceProvider();
}

$required_attrs = array('title', 'description', 'provider_url', 'expires');

foreach ($required_attrs as $req) {
	if (!${$req}) {
		register_error(ucwords($req) . ' is required.');
		forward(REFERRER);
	}
}

$provider->subtype = 'service_provider';
$provider->title = $title;
$provider->description = $description;
$provider->community_profile_url = $community_profile_url;
$provider->provider_url = $provider_url;
if (!$provider->setExpires($expires)) {
	register_error("Invalid expiration");
	forward(REFERRER);
}

$guid = $provider->save();

if (!$guid) {
	register_error("Could not save service provider");
	forward(REFERRER);
}

$picture_data = elgg_extract('picture', $_FILES);

if ($picture_data && $picture_data['error'] !== UPLOAD_ERR_NO_FILE) {
	if ($picture_data['error'] != 0) {
		register_error("Problem uploading picture.");
		forward(REFERER);
	}

	// get the images and save their file handlers into an array
	// so we can do clean up if one fails.
	$files = array();
	$error = false;
	foreach (ServiceProvider::$iconSizes as $name => $size) {
		// pass huge height so we're only looking at width
		$resized = get_resized_image_from_uploaded_file('picture', $size, 10000, false, true);

		if ($resized) {
			$file = new ElggFile();
			$file->owner_guid = $guid;
			$filename = $provider->getIconFilename($name);
			if (!$filename) {
				$error = true;
				break;
			}
			$file->setFilename($filename);
			if (!$file->open('write')) {
				$error = true;
				break;
			}
			if (!$file->write($resized)) {
				$error = true;
				break;
			}
			$file->close();
			$files[] = $file;
		}
	}

	if ($error) {
		// cleanup on fail
		foreach ($files as $file) {
			$file->delete();
		}

		$provider->delete();

		register_error("Could not save picture");
		forward(REFERER);
	}

	$provider->icon_ts = time();
}

elgg_clear_sticky_form('service_provider');
forward($provider->getURL());