--TEST--
Artist Search

--FILE--
<?php
	// Dependencies
	require_once dirname(dirname(__FILE__)) . '/musicbrainz.class.php';

	// Instantiate class
	$brainz = new MusicBrainz();
	$brainz->test_mode(true);

	// Get the URL to request
	var_dump($brainz->artist(null, array(
		'name' => 'Red Hot Chili Peppers',
		'inc' => MUSICBRAINZ_DATA_ARTIST
	)));
?>

--EXPECT--
string(202) "http://musicbrainz.org/ws/1/artist/?type=xml&name=Red+Hot+Chili+Peppers&inc=aliases+release-groups+artist-rels+label-rels+release-rels+track-rels+url-rels+tags+ratings+counts+release-events+discs+labels"
