--TEST--
Release MBID

--FILE--
<?php
	// Dependencies
	require_once dirname(dirname(__FILE__)) . '/musicbrainz.class.php';

	// Instantiate class
	$brainz = new MusicBrainz();
	$brainz->test_mode(true);

	// Get the URL to request
	var_dump($brainz->release('f2b8f8ef-c431-4bdc-b15d-2183b1bde3f7', array(
		'inc' => MUSICBRAINZ_DATA_RELEASE
	)));
?>

--EXPECT--
string(220) "http://musicbrainz.org/ws/1/release/f2b8f8ef-c431-4bdc-b15d-2183b1bde3f7?type=xml&inc=artist+counts+release-events+discs+tracks+artist-rels+label-rels+release-rels+track-rels+url-rels+track-level-rels+labels+tags+ratings"
