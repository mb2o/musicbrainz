--TEST--
Track MBID

--FILE--
<?php
	// Dependencies
	require_once dirname(dirname(__FILE__)) . '/musicbrainz.class.php';

	// Instantiate class
	$brainz = new MusicBrainz();
	$brainz->test_mode(true);

	// Get the URL to request
	var_dump($brainz->track('3596bea8-684c-4b22-ac7b-4feea52be173', array(
		'inc' => MUSICBRAINZ_DATA_TRACK
	)));
?>

--EXPECT--
string(172) "http://musicbrainz.org/ws/1/track/3596bea8-684c-4b22-ac7b-4feea52be173?type=xml&inc=artist+releases+puids+artist-rels+label-rels+release-rels+track-rels+url-rels+tags+isrcs"
