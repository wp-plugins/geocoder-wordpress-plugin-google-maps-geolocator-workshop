=== Geolocator WordPress Plugin ===
Contributors: magblogapi
Tags: google maps,map,geocode,reverse geocode,longitude,latitude,address
Requires at least: 2.0
Tested up to: 2.9.1
Stable tag: 1.1.8

This is a plugin that displays a "worksheet" for verifying and researching addresses with Google Maps.

== Description ==

This plugin is really meant to be an aid to folks doing data entry, and trying to find locations with Google Maps.
It shows two forms: One on the left, and one on the right. The left form allows you to enter address information, or a longitude/latitude pair, and the right form shows the result of a geocode lookup or a reverse geocode.
It is possible to display an interactive map, and also to examine the raw JSON data sent back from the geocode/reverse geocode lookup.
This is an extension of a utility that was written in order to help data entry personnel enter accurate address information.
It has administration options ("Geolocator Options", in "Settings"), and can have the ability to see the map and the raw dump checkboxes limited.
The plugin outputs highly optimized code that is XHTML 1.0 Strict compliant, as wel as WAI AAA.

== Installation ==
1. Upload the `geolocator-wordpress-plugin` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. You need to get a Google Maps API Key (http://code.google.com/apis/maps/signup.html) for the domain of your site.
1. Go to the settings (in the Admin->Settings Menu), and add the Google Maps API key (you don't need it if you are running as localhost, but almost no CMS is ever run that way).
1. Place `<!--GEOLOCATOR-->` in the HTML view of a page or a post. It will be replaced by the plugin output.

== Screenshots ==

1. The simplest form of the plugin
2. The plugin with the two checkboxes enabled
3. The interactive map
4. The response data from Google
5. Reverse geocode and response data
6. The administration options

== Changelog ==

1.1.8 -February 5, 2010
	- Fixed a positioning bug in the gradient.

1.1.7 -February 5, 2010
	- Added accuracy bar indicator to search results.

1.1.6 -February 4, 2010
	- Initial release.