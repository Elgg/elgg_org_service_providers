<?php

/**
 * An Elgg.org service provider.
 */
class ServiceProvider extends ElggObject {
	/**
	 * Save icons with these max width sizes.
	 *
	 * @var array
	 */
	static $iconSizes = array(
		'tiny' => 24, 
		'small' => 38,
		'medium' => 64,
		'large' => 128,
		'huge' => 512
	);
	
	public function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = 'service_provider';
		$this->attributes['access_id'] = ACCESS_PUBLIC;
	}

	public function getURL() {
		$title = elgg_get_friendly_title($this->title);
		return elgg_normalize_url("service_providers/view/$this->guid/$title");
	}

	/**
	 * Converts a date time string and saves as epoch
	 *
	 * @param type $expires
	 */
	public function setExpires($expires) {
		$time = strtotime($expires);

		if (!$time) {
			return false;
		}

		$this->expires = $time;
		return true;
	}

	public function delete() {
		foreach ($this::$iconSizes as $name => $size) {
			$delfile = new ElggFile();
			$delfile->owner_guid = $this->guid;
			$filename = $this->getIconFilename($name);
			if (!$filename) {
				continue;
			}
			$delfile->setFilename($filename);
			$delfile->delete();
		}

		return parent::delete();
	}

	/**
	 * Return the filename of the icon to pass to ElggFile->setFilename().
	 *
	 * @param string $size Friendly size of icon. tiny, small, medium, large, huge.
	 * @return false|string
	 */
	public function getIconFilename($size) {
		if (!array_key_exists($size, $this::$iconSizes)) {
			return false;
		}

		$friendly_title = elgg_get_friendly_title($this->title);

		if (!$friendly_title) {
			return false;
		}

		return "service_providers/$size.jpg";
	}

	public function getIconURL($size) {
		if (!array_key_exists($size, $this::$iconSizes)) {
			return false;
		}

		return elgg_normalize_url("mod/elgg_org_service_providers/icon.php?guid={$this->guid}&size=$size&ts={$this->icon_ts}");
	}
}