--TEST--
Label Search

--FILE--
<?php
	// Dependencies
	require_once dirname(dirname(__FILE__)) . '/musicbrainz.class.php';

	// Instantiate class
	$brainz = new MusicBrainz();
	$brainz->test_mode(true);

	// Get the URL to request
	var_dump($brainz->label(null, array(
		'name' => 'Atlantic',
		'inc' => MUSICBRAINZ_DATA_LABEL
	)));
?>

--EXPECT--
string(138) "http://musicbrainz.org/ws/1/label/?type=xml&name=Atlantic&inc=aliases+artist-rels+label-rels+release-rels+track-rels+url-rels+tags+ratings"
