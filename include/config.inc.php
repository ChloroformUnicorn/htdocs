<?php

// Preise für den Gebäudeausbau (Formeln)
function calculatePrice() {
	global $price;
	$price =
		["main" => ["holz" => newLevel("main")*2+100, 
					"stein" => newLevel("main")*2+100, 
					"eisen" => newLevel("main")*2+100],
		"barracks" => ["holz" => newLevel("barracks")*2+100, 
					"stein" => newLevel("barracks")*2+100, 
					"eisen" => newLevel("barracks")*2+100],
		"smith" => ["holz" => newLevel("smith")*2+100, 
					"stein" => newLevel("smith")*2+100, 
					"eisen" => newLevel("smith")*2+100],
		"church" => ["holz" => newLevel("church")*2+100, 
					"stein" => newLevel("church")*2+100, 
					"eisen" => newLevel("church")*2+100],
		"res1" => ["holz" => newLevel("res1")*2+100, 
					"stein" => newLevel("res1")*2+100, 
					"eisen" => newLevel("res1")*2+100],
		"res2" => ["holz" => newLevel("res2")*2+100, 
					"stein" => newLevel("res2")*2+100, 
					"eisen" => newLevel("res2")*2+100],
		"res3" => ["holz" => newLevel("res3")*2+100, 
					"stein" => newLevel("res3")*2+100, 
					"eisen" => newLevel("res3")*2+100],
		"store" => ["holz" => newLevel("store")*2+100, 
					"stein" => newLevel("store")*2+100, 
					"eisen" => newLevel("store")*2+100],
		"farm" => ["holz" => newLevel("farm")*2+100, 
					"stein" => newLevel("farm")*2+100, 
					"eisen" => newLevel("farm")*2+100],
		"wall" => ["holz" => newLevel("wall")*2+100, 
					"stein" => newLevel("wall")*2+100, 
					"eisen" => newLevel("wall")*2+100]
		];
}

// Dauer für den Gebäudeausbau (Formeln)
function calculateDuration() {
	global $duration;
	$duration =
		["main" => newLevel("main")*0+10,
		"barracks" => newLevel("barracks")*0+10,
		"smith" => newLevel("smith")*0+10,
		"church" => newLevel("church")*0+10,
		"res1" => newLevel("res1")*0+10,
		"res2" => newLevel("res2")*0+10,
		"res3" => newLevel("res3")*0+10,
		"store" => newLevel("store")*0+10,
		"farm" => newLevel("farm")*0+10,
		"wall" => newLevel("wall")*0+10,
		];
}

// Rohstoffproduktion (Formeln)
function resourceProduction($source1, $source2, $source3, $resource1, $resource2, $resource3) {
	global $update1, $update2, $update3;
	$update1 = $source1 * 20 + $resource1;
	$update2 = $source2 * 20 + $resource2;
	$update3 = $source3 * 20 + $resource3;
}