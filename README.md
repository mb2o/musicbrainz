# MusicBrainz

This API will construct the appropriate REST API URL to query, and use RequestCore and SimpleXML to retrieve and parse the data (by default). It does NOT currently support *posting* data to the service.

It takes advantage of PHP's magic methods to make a more intuitive interface for developers: rather than learning a new set of methods, you just use the service's native methods.

## Requirements

This class is built on top of [ServiceCore](http://github.com/skyzyx/servicecore), and therefore shares it's requirements.

## Setup

	git clone git://github.com/skyzyx/musicbrainz.git
	cd musicbrainz
	git submodule update --init --recursive

The `--recursive` option was added in a 1.6.x version of Git, so make sure you're running the latest version.

## Example usage

If you want to make a request to lookup a track MBID, you'd do the following. This makes a request using [RequestCore](http://github.com/skyzyx/requestcore), defaults to an XML response, and parses it with SimpleXML.

	$brainz = new MusicBrainz();
	$response = $brainz->track('3596bea8-684c-4b22-ac7b-4feea52be173', array(
		'inc' => MUSICBRAINZ_DATA_TRACK
	));
	print_r($response);

You can look through the response to see how to traverse through the data. This particular `inc` value will pull as much data as possible about the track. Excludes your personal stats.

You can also search for a variety of other parameters:

	$brainz = new MusicBrainz();
	$brainz->release(null, array(
		'artist' => 'Red Hot Chili Peppers',
		'title' => 'By the way',
		'inc' => MUSICBRAINZ_DATA_RELEASE
	));
	print_r($response);

If you want to use a different response format, you'll also want to override the `parse_response()` method.

	class MusicBrainzDom extends MusicBrainz
	{
		public function parse_response($data)
		{
			return DOMDocument::loadXML($data);
		}
	}

	$brainz = new MusicBrainzDom();
	$response = $brainz->track('3596bea8-684c-4b22-ac7b-4feea52be173', array(
		'inc' => MUSICBRAINZ_DATA_TRACK
	));
	print_r($response);

This will give you working PHP data to iterate over. You can also use this override technique to switch from <code>SimpleXML</code> to <code>DOMDocument</code> or anything else you may want to use to parse the XML.

You would also put this API in Test Mode if you wanted to use your own HTTP and parsing classes. To use a different HTTP request/response class, you would override the <code>request()</code> method. To change how the data was parsed, you would override the <code>parse_response()</code> method.

## License & Copyright

This code is Copyright (c) 2009-2010, Ryan Parman. However, I'm licensing this code for others to use under the [MIT license](http://www.opensource.org/licenses/mit-license.php).
