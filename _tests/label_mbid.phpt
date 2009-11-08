--TEST--
Label MBID

--FILE--
<?php
	// Dependencies
	require_once dirname(dirname(__FILE__)) . '/musicbrainz.class.php';

	// Instantiate class
	$brainz = new MusicBrainz();
	$brainz->test_mode(true);

	// Get the URL to request
	var_dump($brainz->label('50c384a2-0b44-401b-b893-8181173339c7', array(
		'inc' => MUSICBRAINZ_DATA_LABEL
	)));
?>

--EXPECT--
string(160) "http://musicbrainz.org/ws/1/label/50c384a2-0b44-401b-b893-8181173339c7?type=xml&inc=aliases+artist-rels+label-rels+release-rels+track-rels+url-rels+tags+ratings"
