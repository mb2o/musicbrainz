--TEST--
Track Search - Artist ID

--FILE--
<?php
	// Dependencies
	require_once dirname(dirname(__FILE__)) . '/musicbrainz.class.php';

	// Instantiate class
	$brainz = new MusicBrainz();
	$brainz->test_mode(true);

	// Get the URL to request
	var_dump($brainz->track(null, array(
		'artistid' => '8bfac288-ccc5-448d-9573-c33ea2aa5c30',
		'release' => 'By the way',
		'title' => 'This is the place',
		'inc' => MUSICBRAINZ_DATA_TRACK
	)));
?>

--EXPECT--
string(225) "http://musicbrainz.org/ws/1/track/?type=xml&artistid=8bfac288-ccc5-448d-9573-c33ea2aa5c30&release=By+the+way&title=This+is+the+place&inc=artist+releases+puids+artist-rels+label-rels+release-rels+track-rels+url-rels+tags+isrcs"
