--TEST--
Release Search

--FILE--
<?php
	// Dependencies
	require_once dirname(dirname(__FILE__)) . '/musicbrainz.class.php';

	// Instantiate class
	$brainz = new MusicBrainz();
	$brainz->test_mode(true);

	// Get the URL to request
	var_dump($brainz->release(null, array(
		'artist' => 'Red Hot Chili Peppers',
		'title' => 'By the way',
		'inc' => MUSICBRAINZ_DATA_RELEASE
	)));
?>

--EXPECT--
string(230) "http://musicbrainz.org/ws/1/release/?type=xml&artist=Red+Hot+Chili+Peppers&title=By+the+way&inc=artist+counts+release-events+discs+tracks+artist-rels+label-rels+release-rels+track-rels+url-rels+track-level-rels+labels+tags+ratings"
