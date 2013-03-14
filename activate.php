<?php
/*
 * Register the classes
 */

if (get_subtype_id('object', 'service_provider')) {
	update_subtype('object', 'service_provider', 'ServiceProvider');
} else {
	add_subtype('object', 'service_provider', 'ServiceProvider');
}