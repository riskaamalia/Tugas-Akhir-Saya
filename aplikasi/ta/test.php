<?php

require_once ("lib/LangDetector.php");

set_time_limit(-1);

$l = new LangDetector(TRUE);

test_lang("","en");

function test_lang($txt,$expected)
{
    global $l;
    $out = $l->get_lang($txt);
    $first = array_shift($out);

    if ($first["lang"]==$expected) {
	echo "OK: $expected [",$first["ratio"],"]\n";
    } else {
	echo "KO: $expected, given: ",$first["lang"], " [", $first["ratio"],"]\n";
    }
	return $first;
}
