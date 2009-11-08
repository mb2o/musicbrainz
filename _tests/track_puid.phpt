--TEST--
Track PUID

--FILE--
<?php
	// Dependencies
	require_once dirname(dirname(__FILE__)) . '/musicbrainz.class.php';

	// Instantiate class
	$brainz = new MusicBrainz();
	$brainz->test_mode(true);

	// Get the URL to request
	var_dump($brainz->track(null, array(
		'puid' => 'aa6f70d7-96b2-83f9-c7f0-b1f348985a9b',
		'inc' => MUSICBRAINZ_DATA_TRACK
	)));
?>

--EXPECT--
string(178) "http://musicbrainz.org/ws/1/track/?type=xml&puid=aa6f70d7-96b2-83f9-c7f0-b1f348985a9b&inc=artist+releases+puids+artist-rels+label-rels+release-rels+track-rels+url-rels+tags+isrcs"
