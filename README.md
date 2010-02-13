# MusicBrainz

This API will construct the appropriate MusicBrainz API URL to query, and use RequestCore and SimpleXML to retrieve and parse the data.

It does NOT currently support *posting* data to the service.

## Requirements

This MusicBrainz class is built on top of [ServiceCore](http://github.com/skyzyx/servicecore), and therefore shares it's requirements.

## Setup

	git clone git://github.com/skyzyx/servicecore.git
	git submodule update --init --recursive

The `--recursive` option was added in a 1.6.x version of Git, so make sure you're running the latest version.

## Example usage

To learn how to use this API, look through the unit tests that are included. These specific tests use "Test Mode," meaning that they return the URL rather than requesting the URL and returning the parsed response.

You would also put this API in Test Mode if you wanted to use your own HTTP and parsing classes.

## License & Copyright

This code is Copyright (c) 2009-2010, Ryan Parman. However, I'm licensing this code for others to use under the [MIT license](http://www.opensource.org/licenses/mit-license.php).