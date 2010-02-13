<?php
/**
 * File: api-musicbrainz
 * 	Handle the MusicBrainz API.
 *
 * Version:
 * 	2010.02.12
 *
 * Copyright:
 * 	2009-2010 Ryan Parman
 *
 * License:
 * 	MIT License - http://www.opensource.org/licenses/mit-license.php
 */


/*%******************************************************************************************%*/
// INCLUDES

require_once 'lib/servicecore/servicecore.class.php';


/*%******************************************************************************************%*/
// CONSTANTS

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
class MusicBrainz extends ServiceCore
{

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
		$this->const_namespace = 'MUSICBRAINZ';

		if (!defined($this->const_namespace . '_USERAGENT'))
		{
			$this->set_app_info(array(
				$this->const_namespace => array(
					'name' => 'api-musicbrainz',
					'version' => '1.1',
					'url' => 'http://github.com/skyzyx/musicbrainz/',
					'description' => 'MusicBrainz Toolkit',
				)
			));
		}
	}


	/*%******************************************************************************************%*/
	// MAGIC METHODS

	/**
	 * Handle requests to properties
	 */
	public function __get($var)
	{
		// Determine the name of this class
		$class_name = get_class($this);

		// Re-instantiate this class, passing in the subclass value
		return new $class_name($var);
	}

	/**
	 * Handle requests to methods
	 */
	public function __call($name, $args)
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
}
