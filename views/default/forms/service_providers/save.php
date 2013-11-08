<?php
/**
 * Save a service provider
 *
 * @note - The date is displayed in y-m-d but stored in epoch time.
 */

extract($vars);

?>
<div>
	<label>Provider Name</label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'title',
		'value' => $title
	));
	?>
</div>

<div>
	<label>Blurb (No more than 4 sentences)</label><br />
	<?php
	echo elgg_view('input/longtext', array(
		'name' => 'description',
		'value' => $description
	));
	?>
</div>

<div>
	<label>Service Provider URL (The Elgg-specific page)</label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'provider_url',
		'value' => $provider_url
	));
	?>
</div>

<div>
	<label>Community Profile URL</label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'community_profile_url',
		'value' => $community_profile_url
	));
	?>
</div>

<div>
	<label>Logo (leave empty to keep)</label><br />
	<?php
	if ($entity) {
		echo elgg_view_entity_icon($entity, 'large');
	}
	echo elgg_view('input/file', array(
		'name' => 'picture'
	));
	?>
</div>

<div>
	<label>Expires (listings that have expired will not show up except to admins)</label><br />
	<?php
	echo elgg_view('input/date', array(
		'name' => 'expires',
		'value' => $expires
	));
	?>
</div>

<div class="elgg-foot">
<?php

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => 'Save'));

?>
</div>