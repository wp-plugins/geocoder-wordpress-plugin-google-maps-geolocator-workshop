=== Geolocator WordPress Plugin ===
Contributors: magblogapi
Tags: google maps,map,geocode,reverse geocode,longitude,latitude,address
Requires at least: 2.0
Tested up to: 2.9.1
Stable tag: 1.1.9

This is a plugin that displays a "worksheet" for verifying and researching addresses with Google Maps.

== Description ==

This plugin is really meant to be an aid to folks doing data entry, and trying to find locations with Google Maps.
It shows two forms: One on the left, and one on the right. The left form allows you to enter address information, or a longitude/latitude pair, and the right form shows the result of a geocode lookup or a reverse geocode.
It is possible to display an interactive map, and also to examine the raw JSON data sent back from the geocode/reverse geocode lookup.
This is an extension of a utility that was written in order to help data entry personnel enter accurate address information.
It has administration options ("Geolocator Options", in "Settings"), and can have the ability to see the map and the raw dump checkboxes limited.
The plugin outputs highly optimized code that is XHTML 1.0 Strict compliant, as wel as WAI AAA.

== Installation ==

1. Upload the `geocoder-wordpress-plugin-google-maps-geolocator-workshop` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. You need to get a Google Maps API Key (http://code.google.com/apis/maps/signup.html) for the domain of your site.
1. Go to the settings (in the Admin->Settings Menu), and add the Google Maps API key (you don't need it if you are running as localhost, but almost no CMS is ever run that way).
1. Place `<!--GEOLOCATOR-->` in the HTML view of a page or a post. It will be replaced by the plugin output.

== Usage ==

To use this utility, you simply enter address information into the fields in the left-hand form. You can enter all the information in one line, if you wish.
The string that is displayed above the entry is what is actually sent to Google Maps to be geocoded. Once you have filled in the address, click on "Address Lookup". This will send a geocode request to Google Maps.
The response is parsed, and shown in the right-hand (gray) box. A set of arrow links will appear between the two forms. These allow you to easily transfer results into the entry form.
If you enter a longitude and latitude value into the bottom two boxes in the entry form, you can do a reverse geocode. This asks Google Maps to figure out an address, based on the values in these boxes.
In many cases, Google Maps will return more than one response, and you can cycle through these responses.
Each response shows an "accuracy" number in a scale, above the response. The more accurate (confident) the result, the closer the scale marker will be to the right.
In the interactive map, there are two markers shown. The yellow one reflects the long/lat pair in the left window, and can be moved around. Clicking in the map will move/create the marker, and fill in the long/lat fields.
The gray marker reflects the position of the current response, and cannot be moved.
The raw data window shows the entire response from Google Maps, presented in a hierarchical fashion. If there are more than one placemark, each mark will have a link that will bring that mark into focus in the gray form.

== Screenshots ==

1. The simplest form of the plugin
2. The plugin with the two checkboxes enabled
3. The interactive map
4. The response data from Google
5. Reverse geocode and response data
6. A basic lookup (Note entire address in one line)
7. A reverse geocode from just the longitude and latitude
8. The administration options

== Changelog ==

1.1.9 -February 6, 2010
	- Worked on optimizing and improving the appearance of the accuracy bar.

1.1.8 -February 5, 2010
	- Fixed a positioning bug in the gradient.

1.1.7 -February 5, 2010
	- Added accuracy bar indicator to search results.

1.1.6 -February 4, 2010
	- Initial release.