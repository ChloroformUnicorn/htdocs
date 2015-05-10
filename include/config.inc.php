<?

// Funktion welche die nächste Stufe eines Gebäudes ausgibt
function newLevel($building) {
	global $db, $village, $amountOfOrders;
	$orders = mysqli_query($db, "SELECT * FROM buildOrders WHERE building = '$building'");
	$amountOfOrders = mysqli_num_rows($orders);
	return $village[$building] + $amountOfOrders + 1;
}

// Übersetzungen bzw. Namen der Gebäude
function getName($param) {
	switch ($param) {
		// Gebäude
		case "main":
			return "Hauptgebäude";
			break;
		case "barracks":
			return "Kaserne";
			break;
		case "smith":
			return "Schmiede";
			break;
		case "church":
			return "Tempel";
			break;
		case "res1":
			return "Holzfäller";
			break;
		case "res2":
			return "Steinbruch";
			break;
		case "res3":
			return "Eisenmine";
			break;
		case "farm":
			return "Bauernhof";
			break;
		case "store":
			return "Speicher";
			break;
		case "wall":
			return "Wall";
			break;
		// Truppen
		case "phalanx":
			return "Phalanx";
			break;
		case "swordsman":
			return "Schwertkämpfer";
			break;
		case "archer":
			return "Bogenschütze";
			break;
	}
}

// Preise für den Gebäudeausbau (Formeln)
function calculatePrice() {
	global $price;
	$price =
		// Gebäude
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
					"eisen" => newLevel("wall")*2+100],
		// Truppen
		"phalanx" => ["holz" => 10,
					"stein" => 12,
					"eisen" => 8,
					"farmUnits" => 1,
					"speed" => 1],
		"swordsman" => ["holz" => 10,
					"stein" => 12,
					"eisen" => 8,
					"farmUnits" => 1,
					"speed" => 2],
		"archer" => ["holz" => 10,
					"stein" => 12,
					"eisen" => 8,
					"farmUnits" => 1,
					"speed" => 3]
		];
}

// Dauer für den Gebäudeausbau (Formeln)
function calculateDuration($village = null) {
	global $duration;
	$duration =
		// Gebäude
		["main" => newLevel("main")*2+10,
		"barracks" => newLevel("barracks")*2+10,
		"smith" => newLevel("smith")*2+10,
		"church" => newLevel("church")*2+10,
		"res1" => newLevel("res1")*2+10,
		"res2" => newLevel("res2")*2+10,
		"res3" => newLevel("res3")*2+10,
		"store" => newLevel("store")*2+10,
		"farm" => newLevel("farm")*2+10,
		"wall" => newLevel("wall")*2+10,
		// Truppen
		"phalanx" => $village["barracks"]*0.03,
		"swordsman" => $village["barracks"]*0.04,
		"archer" => $village["barracks"]*0.05
		];
}

// Rohstoff bzw. Bauernhof Kapazitäten in Abhängigkeit zur Stufe des Speichers berechnen
// $cap ist die Rohstoff Kap., $farmCap die Bauernhof Kap., der Programmierer soll sich raussuchen was er will
function capacity($level) {
	global $cap, $farmCap;
	$cap = $level * 1000;
	$farmCap = $level * 500;
}

// Rohstoffproduktion (Formeln)
function resourceProduction($source1, $source2, $source3, $resource1, $resource2, $resource3) {
	global $update1, $update2, $update3;
	$update1 = $source1 * 20 + $resource1;
	$update2 = $source2 * 20 + $resource2;
	$update3 = $source3 * 20 + $resource3;
}