<?php
/**
 * Icon display
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$guid = get_input('guid');
$provider = get_entity($guid);

if (!($provider instanceof ServiceProvider)) {
	header("HTTP/1.1 404 Not Found");
	exit;
}

$size = strtolower(get_input('size'));
if (!array_key_exists($size, ServiceProvider::$iconSizes)) {
	$size = "medium";
}

// If is the same ETag, content didn't changed.
$etag = $provider->icon_ts . $guid . $size;
if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == "\"$etag\"") {
	header("HTTP/1.1 304 Not Modified");
	exit;
}

$success = false;

$filehandler = new ElggFile();
$filehandler->owner_guid = $provider->guid;
$filename = $provider->getIconFilename($size);
$filehandler->setFilename($filename);

if ($filehandler->open("read")) {
	$contents = $filehandler->grabFile();
	if ($contents) {
		$success = true;
	}
}

if (!$success) {
	header("HTTP/1.1 404 Not Found");
	exit;
}

header("Content-type: image/jpeg");
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+10 days")), true);
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));
header("ETag: \"$etag\"");
echo $contents;
