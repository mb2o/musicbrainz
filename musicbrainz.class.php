<?php
/**
 * File: api-musicbrainz
 * 	Handle the MusicBrainz API.
 *
 * Version:
 * 	2009.11.07
 *
 * Copyright:
 * 	2009 Ryan Parman
 *
 * License:
 * 	Simplified BSD License - http://opensource.org/licenses/bsd-license.php
 */


/*%******************************************************************************************%*/
// CONSTANTS

/**
 * Constant: MUSICBRAINZ_NAME
 * 	Name of the software.
 */
define('MUSICBRAINZ_NAME', 'api-musicbrainz');

/**
 * Constant: MUSICBRAINZ_VERSION
 * 	Version of the software.
 */
define('MUSICBRAINZ_VERSION', '1.0');

/**
 * Constant: MUSICBRAINZ_BUILD
 * 	Build ID of the software.
 */
define('MUSICBRAINZ_BUILD', gmdate('YmdHis', strtotime(substr('$Date$', 7, 25)) ? strtotime(substr('$Date$', 7, 25)) : filemtime(__FILE__)));

/**
 * Constant: MUSICBRAINZ_URL
 * 	URL to learn more about the software.
 */
define('MUSICBRAINZ_URL', 'http://github.com/skyzyx/musicbrainz/');

/**
 * Constant: MUSICBRAINZ_USERAGENT
 * 	User agent string used to identify the software
 */
define('MUSICBRAINZ_USERAGENT', MUSICBRAINZ_NAME . '/' . MUSICBRAINZ_VERSION . ' (MusicBrainz Toolkit; ' . MUSICBRAINZ_URL . ') Build/' . MUSICBRAINZ_BUILD);

/**
 * Constant: MUSICBRAINZ_DATA_ARTIST
 * 	Shortcut for parameters that pull the max amount of data for artists
 */
define('MUSICBRAINZ_DATA_ARTIST', 'aliases+release-groups+artist-rels+label-rels+release-rels+track-rels+url-rels+tags+ratings+counts+release-events+discs+labels');

/**
 * Constant: MUSICBRAINZ_DATA_RELEASE
 * 	Shortcut for parameters that pull the max amount of data for releases (albums)
 */
define('MUSICBRAINZ_DATA_RELEASE', 'artist+counts+release-events+discs+tracks+artist-rels+label-rels+release-rels+track-rels+url-rels+track-level-rels+labels+tags+ratings');

/**
 * Constant: MUSICBRAINZ_DATA_TRACK
 * 	Shortcut for parameters that pull the max amount of data for tracks
 */
define('MUSICBRAINZ_DATA_TRACK', 'artist+releases+puids+artist-rels+label-rels+release-rels+track-rels+url-rels+tags+isrcs');

/**
 * Constant: MUSICBRAINZ_DATA_LABEL
 * 	Shortcut for parameters that pull the max amount of data for tracks
 */
define('MUSICBRAINZ_DATA_LABEL', 'aliases+artist-rels+label-rels+release-rels+track-rels+url-rels+tags+ratings');


/*%******************************************************************************************%*/
// CLASS

/**
 * Class: MusicBrainz
 */
class MusicBrainz
{
	/**
	 * Property: subclass
	 * 	The API subclass (e.g. search, lookup) to point the request to.
	 */
	var $subclass;

	/**
	 * Property: test_mode
	 * 	Whether we're in test mode or not.
	 */
	var $test_mode;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	The constructor.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	subclass - _string_ (Optional) Don't use this. This is an internal parameter.
	 *
	 * Returns:
	 * 	MusicBrainz $this
	 */
	public function __construct($subclass = null)
	{
		// Set default values
		$this->subclass = $subclass;
		$this->test_mode = false;
	}


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * Method: test_mode()
	 * 	Enables test mode within the API. Enabling test mode will return the request URL instead of requesting it.
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	subclass - _string_ (Optional) Don't use this. This is an internal parameter.
	 *
	 * Returns:
	 * 	void
	 */
	public function test_mode($enabled = true)
	{
		// Set default values
		$this->test_mode = $enabled;
	}


	/*%******************************************************************************************%*/
	// MAGIC METHODS

	/**
	 * Handle requests to properties
	 */
	function __get($var)
	{
		// Determine the name of this class
		$class_name = get_class($this);

		// Re-instantiate this class, passing in the subclass value
		return new $class_name($var);
	}

	/**
	 * Handle requests to methods
	 */
	function __call($name, $args)
	{
		// Change the names of the methods to match what the API expects
		$name = strtolower(str_replace('_', '-', $name));

		// Get the MBID, if any
		$mbid = $args[0];

		// API Parameters
		$params = $args[1];
		$clean_params = array();

		// Convert any array values to strings
		foreach ($params as $k => $v)
		{
			if (is_array($v))
			{
				$clean_params[$k] = implode('+', str_replace(' ', '+', $v));
			}
			else
			{
				$clean_params[$k] = str_replace(' ', '+', $v);
			}
		}

		// Construct the rest of the query parameters with what was passed to the method
		$fields = urldecode(http_build_query((count($clean_params) > 0) ? $clean_params : array(), '', '&'));

		// Construct the URL to request
		$api_call = sprintf('http://musicbrainz.org/ws/1/' . $name . '/' . $mbid . '?type=xml&%s', $fields);

		// Return the value
		return $this->request($api_call);
	}


	/*%******************************************************************************************%*/
	// REQUEST/RESPONSE

	/**
	 * Method: request()
	 * 	Requests the XML data, parses it, and returns it. Requires RequestCore and SimpleXML.
	 *
	 * Parameters:
	 * 	url - _string_ (Required) The web service URL to request.
	 *
	 * Returns:
	 * 	ResponseCore object
	 */
	public function request($url)
	{
		if (!$this->test_mode)
		{
			if (class_exists('RequestCore'))
			{
				$http = new RequestCore($url);
				$http->set_useragent(MUSICBRAINZ_USERAGENT);
				$http->send_request();

				$response = new stdClass();
				$response->header = $http->get_response_header();
				$response->body = new SimpleXMLElement($http->get_response_body(), LIBXML_NOCDATA);
				$response->status = $http->get_response_code();

				return $response;
			}

			throw new Exception('This class requires RequestCore. http://requestcore.googlecode.com');
		}

		return $url;
	}
}
