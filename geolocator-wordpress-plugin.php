<?php
/********************************************************************/
/**
	\brief This is a gelocator tool plugin.
	
	This reads in the index.html file that implements a standalone geocoder, and parses
	it to provide this plugin.
	
	It will strip the returned code down to an optimal HTTP stream,
	an allows you to add an API key for a deployment into a server.
	
Plugin Name: Geocoder WordPress Plugin
Plugin URI: http://magshare.org/geolocator-tool/
Description: This is a WordPress plugin implementation of the BMLT Tools Geolocator Tool, which is highly useful for many purposes.
Version: 1.2.3
Install: Drop this directory into the "wp-content/plugins/" directory and activate it.
You need to specify "<!--GEOLOCATOR-->" in the code section of a page or a post.
*/ 
/**
	\class GoogleMapsGecoderPlugin
	
	\brief This is the class that implements and encapsulates the plugin functionality. A single instance of this is created, and manages the plugin.
*/

class GoogleMapsGecoderPlugin
	{
	static $options_title = 'Geolocator Plugin Options';	///< This is the title that is displayed over the options.
	static $menu_string = "Geolocator Options";				///< The string shown in the settings menu.
	static $adminOptionsName = "GeoLocatorAdminOptions";	///< The name, in the database, for the options for this plugin.
	static $default_gkey = 'localhost';						///< This is the default Google Maps API key (localhost).
	static $default_show_map = true;						///< Set this to false if you want the map hidden (may still show the long/lat fields).
	static $default_show_debug_checkbox = true;				///< Set this to false to hide the raw Google response data.
	static $default_show_long_lat_info = true;				///< Set this to false to hide the long/lat displays, as well as the map.
	static $default_long_lat_zoom = array ( 'latitude' => 37.0, 'longitude' => -96.0, 'zoom' => 4 );	///< The initial view of the Google Map.

	/**
		\brief This echoes the appropriate SendHeadStuff element stuff for this plugin.
	*/
	static function SendHeadStuff ( )
		{
		$options = self::GetGeocoderOptions ( );
		$head_string = '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />';
		$head_string .= '<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='.htmlspecialchars ( $options['gKey'] ).'" type="text/javascript"></script>';
		$head_string .= '<style type="text/css">/* <![CDATA[ */'.self::GetOptimizedFileContents ( dirname ( __FILE__ ).'/index.html', '/*##START_CSS##*/', '/*##END_CSS##*/' ).'#bmlt_tools_outer_container{text-align:center;clear:both;float:none}#bmlt_tools_main_container{position:static;margin-top:8px;margin-bottom:8px;margin-left:auto;margin-right:auto}/* ]]> */</style>';
		echo "<!-- Added by Geolocator plugin -->\n$head_string";
		}

	/**
		\brief Is the "meat" of the filter. It processes the content. If the page contains, anywhere, the "trigger" string ("<!--GEOLOCATOR-->"), then the entire page is replaced with the geolocator tool.
		
		\returns a string, containing the processed page content.
	*/
	static function FilterContent (
									$in_content	///< A string. The content to be filtered.
									)
		{
		$options = self::GetGeocoderOptions ( );
		$the_new_content = '<script type="text/javascript">/* <![CDATA[ */';
		$the_new_content .= self::GetOptimizedFileContents ( dirname ( __FILE__ ).'/index.html', '/*##START_JAVASCRIPT_ALL##*/', '/*##END_JAVASCRIPT_ALL##*/' );

		if ( $options['show_map'] )
			{
			$the_new_content .= self::GetOptimizedFileContents ( dirname ( __FILE__ ).'/index.html', '/*##START_JAVASCRIPT_MAP##*/', '/*##END_JAVASCRIPT_MAP##*/' );
			}
		else
			{
			$the_new_content = preg_replace ( '|var\s?g_show_map_checkbox\s?=\s?true\s*?;|', 'var g_show_map_checkbox = false;', $the_new_content );
			}
		
		if ( $options['show_debug'] )
			{
			$the_new_content .= self::GetOptimizedFileContents ( dirname ( __FILE__ ).'/index.html', '/*##START_JAVASCRIPT_DEBUG##*/', '/*##END_JAVASCRIPT_DEBUG##*/' );
			}
		else
			{
			$the_new_content = preg_replace ( '|var\s?g_show_debug_checkbox\s?=\s?true\s*?;|', 'var g_show_debug_checkbox = false;', $the_new_content );
			}

		if ( !$options['show_long_lat'] )
			{
			$the_new_content = preg_replace ( '|var\s?g_show_long_lat_info\s?=\s?true\s*?;|', 'var g_show_long_lat_info = false;', $the_new_content );
			}
		
		$the_new_content .= '/* ]]> */</script>';
		$the_new_content .= self::GetOptimizedFileContents ( dirname ( __FILE__ ).'/index.html', '<!--##START_HTML##-->', '<!--##END_HTML##-->' );
		$the_new_content .= '<script type="text/javascript">/* <![CDATA[ */ GeocodeInitializeOnLoad(); /* ]]> */</script>';

		return preg_replace ( "|(\<p[^>]*>)?\<\!\-\-GEOLOCATOR\-\-\>(\<\/p[^>]*>)?|", $the_new_content, $in_content );
		}

	/**
		\brief This echoes the admin page.
	*/
	static function printAdminPage ( )
		{
		$options = self::GetGeocoderOptions ( );
		
		$report = '';
		
		if ( isset ( $_POST['save_geolocator_settings'] ) )
			{
			$options['gKey'] = $_POST['bmlt_geolocator_admin_form_api_key'];
			$options['show_map'] = (intval ($_POST['bmlt_geolocator_admin_form_show_map']) == 1) ? 1: 0;
			$options['show_debug'] = (intval ($_POST['bmlt_geolocator_admin_form_show_debug']) == 1) ? 1: 0;
			$options['show_long_lat'] = (intval ($_POST['bmlt_geolocator_admin_form_show_longlat']) == 1) ? 1: 0;
			if ( !$options['show_long_lat'] )
				{
				$options['show_map'] = 0;
				}
			update_option ( self::$adminOptionsName, $options );
			$report = '<h4 style="color:green;font-style:italic;text-align:center">Options Saved</h4>';
			}
		
		$wrapper_head ='<div id="bmlt_geolocator_container" style="margin-top:8px;margin-bottom:8px;text-align:center">';
		
		$wrapper_tail = '<script type="text/javascript">';
		$wrapper_tail .= 'document.getElementById(\'bmlt_geolocator_admin_form\').action=\''.htmlspecialchars ( $_SERVER["REQUEST_URI"] ).'\';';
		$wrapper_tail .= 'document.getElementById(\'bmlt_geolocator_admin_form_api_key\').value=\''.htmlspecialchars ( $options['gKey'] ).'\';';
		$wrapper_tail .= 'document.getElementById(\'bmlt_geolocator_admin_form_show_map\').checked='.(($options['show_map']==1)&&($options['show_long_lat']==1)?'true':'false').';';
		$wrapper_tail .= 'document.getElementById(\'bmlt_geolocator_admin_form_show_map\').disabled='.($options['show_long_lat']==1?'false':'true').';';
		$wrapper_tail .= 'document.getElementById(\'bmlt_geolocator_admin_form_show_debug\').checked='.($options['show_debug']==1?'true':'false').';';
		$wrapper_tail .= 'document.getElementById(\'bmlt_geolocator_admin_form_show_longlat\').checked='.($options['show_long_lat']==1?'true':'false').';';
		$wrapper_tail .= '</script>';

		echo "$wrapper_head$report".self::GetOptimizedFileContents ( dirname ( __FILE__ ).'/geolocator_admin_form.html' )."$wrapper_tail.</div>";
		}
	
	/**
		\brief TOOL: Read in a file, and clean (optimize) it before returning its contents as a string.
		
		Depending on the type of file, different parts of this will work on the data.
		
		This will optimize any type of file it gets. It will remove any PHP, for safety and security.
		
		NOTE: If you use HTML comments to enclose JavaScript and CSS, then the JS/CSS will be deleted. Use CDATA, or don't use any comments to delimit (This adds CDATA).
		Also, you MUST precede "single line" (//) comments with whitespace (start of a line, or a space or tab).
		
		This uses comment blocks, embedded in the HTML file, to parse it. This allows us to re-use the original HTML file from the tools project.
		
		\returns a string, with the file contents cleaned and optimized. Null if the file could not be found.
	*/
	static function GetOptimizedFileContents (
												$in_file_path,		///< The pathname to the file to be read.
												$in_start = null,	///< The comment that indicates the start block.
												$in_end = null		///< The comment that indicates the end block.
												)
	{
		$opt = null;
		
		if ( file_exists($in_file_path) )
			{
			// Get the file contents as a string.
			$opt = file_get_contents($in_file_path);
			
			//Remove the parts we don't want.
			if ( $in_start )
				{
				$opt = explode ( $in_start, $opt );
				$opt = $opt[1];
				}
			
			if ( $in_end )
				{
				$opt = explode ( $in_end, $opt );
				$opt = $opt[0];
				}

			// Remove all PHP (safety and security)
			$opt = preg_replace('/\<\?php(.|\s)*?\?\>/', '', $opt);
			// Remove HTML comments.
			$opt = preg_replace('/<!--(.|\s)*?-->/', '', $opt);
			// Remove JavaScript and CSS comments
			$opt = preg_replace('/\/\*(.|\s)*?\*\//', '', $opt);
			// Remove JavaScript "single line" comments.
			$opt = preg_replace( "|\s+\/\/.*|", " ", $opt );
			// Add our API key.
			// Reduce sequential whitespace (including line breaks) to a single space.
			$opt = preg_replace( "/\s+/", " ", $opt );
			}
		
		return $opt;
	}
	
	/**
		\brief TOOL: This gets the admin options from the database.
	*/
	static function GetGeocoderOptions ( )
		{
		$GeoLocatorOptions = array (
									'gKey' => self::$default_gkey,
									'longitude' => self::$default_long_lat_zoom['longitude'],
									'latitude' => self::$default_long_lat_zoom['latitude'],
									'zoom' => self::$default_long_lat_zoom['zoom'],
									'show_map' => self::$default_show_map,
									'show_debug' => self::$default_show_debug_checkbox,
									'show_long_lat' => self::$default_show_long_lat_info
									);

		$old_GeoLocatorOptions = get_option ( self::$adminOptionsName );
		
		if ( is_array ( $old_GeoLocatorOptions ) && count ( $old_GeoLocatorOptions ) )
			{
	 		foreach ( $old_GeoLocatorOptions as $key => $value )
				{
		  		$GeoLocatorOptions[$key] = $value;
				}
			}

		return $GeoLocatorOptions;
		}
		
	static function GoogleMapsGecoderPlugin_ap ( )
		{
		add_options_page ( self::$options_title, self::$menu_string, 10, basename ( __FILE__ ), array ( "GoogleMapsGecoderPlugin", 'printAdminPage' ) );
		}	
};

add_action ( 'admin_menu', array ( 'GoogleMapsGecoderPlugin', 'GoogleMapsGecoderPlugin_ap' ) );
add_filter ( 'the_content', array ( 'GoogleMapsGecoderPlugin', 'FilterContent' )  );
add_filter ( 'wp_head', array ( "GoogleMapsGecoderPlugin", 'SendHeadStuff' ) );
?>