=== Geolocator WordPress Plugin ===
Contributors: magblogapi
Tags: google maps,map,geocode,reverse geocode,longitude,latitude,address
Requires at least: 2.0
Tested up to: 2.9.1
Stable tag: 1.1.6

This is a plugin that displays a "worksheet" for verifying and researching addresses with Google Maps.

== Description ==

This plugin is really mean to be an aid to folks doing data entry, and trying to find locations with Google Maps.
It shows two forms: One on the left, and one on the right. The left form allows you to enter address information, or a longitude/latitude pair, and the right form shows the result of a geocode lookup or a reverse geocode.
It is possible to display an interactive map, and also to examine the raw JSON data sent back from the geocode/reverse geocode lookup.
This is an extension of a utility that was written in order to help data entry personnel enter accurat address information.
It has administration options ("Geolocator Options", in "Settings"), and can have the ability to see the map and the raw dump checkboxes limited.

== Installation ==
1. Upload `the bmlt-wordpress-satellite-plugin` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<!--GEOLOCATOR-->` in the HTML view of a page. It will be replaced by the plugin.

== Screenshots ==

1. The simplest form of the plugin
2. The plugin with the two checkboxes enabled
3. The interactive map
4. The administration options

== Changelog ==

1.1.6 -February 4, 2010
	- Initial release.