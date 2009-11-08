--TEST--
Artist MBID

--FILE--
<?php
	// Dependencies
	require_once dirname(dirname(__FILE__)) . '/musicbrainz.class.php';

	// Instantiate class
	$brainz = new MusicBrainz();
	$brainz->test_mode(true);

	// Get the URL to request
	var_dump($brainz->artist('8bfac288-ccc5-448d-9573-c33ea2aa5c30', array(
		'inc' => MUSICBRAINZ_DATA_ARTIST
	)));
?>

--EXPECT--
string(211) "http://musicbrainz.org/ws/1/artist/8bfac288-ccc5-448d-9573-c33ea2aa5c30?type=xml&inc=aliases+release-groups+artist-rels+label-rels+release-rels+track-rels+url-rels+tags+ratings+counts+release-events+discs+labels"
