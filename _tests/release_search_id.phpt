--TEST--
Release Search ID

--FILE--
<?php
	// Dependencies
	require_once dirname(dirname(__FILE__)) . '/musicbrainz.class.php';

	// Instantiate class
	$brainz = new MusicBrainz();
	$brainz->test_mode(true);

	// Get the URL to request
	var_dump($brainz->release(null, array(
		'artistid' => '8bfac288-ccc5-448d-9573-c33ea2aa5c30',
		'title' => 'By the way',
		'inc' => MUSICBRAINZ_DATA_RELEASE
	)));
?>

--EXPECT--
string(247) "http://musicbrainz.org/ws/1/release/?type=xml&artistid=8bfac288-ccc5-448d-9573-c33ea2aa5c30&title=By+the+way&inc=artist+counts+release-events+discs+tracks+artist-rels+label-rels+release-rels+track-rels+url-rels+track-level-rels+labels+tags+ratings"
