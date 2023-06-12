<!DOCTYPE html>
<html>
<head>
	<title>GunDB Webapp - Generate</title>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>
	<?php
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        //echo "URL identified as: $url <br>";
        $link = str_replace("index.php", "", $url);
        $link = $link . "edit-page.php";
    ?>
    <div class="tabs">
        <h1 id="current">Generate</h1><h1 id="edit"><?php echo "<a href=\"" . $link . "\">Edit</a>" ?></h1>
    </div>
	<div class="info">
		<h2 id="info-h">Select a weapon type from the dropdown list and hit generate to create a randomized weapon</h2>
		<p id="info-p"> You may also optionally add a "luck" modifier from -100 to 100 to influence the stats rolled on the randomized weapon. </p>
	</div>
	<div class="rng-csv-test">
		<?php
			error_reporting(E_ALL);
			$pistolarray = array(array());
			//echo "<html><body><table>\n\n";
			$f = fopen("pistol.csv", "r");
			$i = 0;
			while (($line = fgetcsv($f)) !== false) {
					//echo "<tr>";
					$j = 0;
					foreach ($line as $cell) {
							$pistolarray[$i][$j] = htmlspecialchars($cell);
							//echo "<td>" . $pistolarray[$i][$j] . "</td>";
							
							$j++;
					}
					//echo "</tr>\n";
					$i++;
			}
			fclose($f);
			//echo "\n</table></body></html><br>";

			$sniperarray = array(array());
			//echo "<html><body><table>\n\n";
			$f = fopen("sniper.csv", "r");
			$i = 0;
			while (($line = fgetcsv($f)) !== false) {
					//echo "<tr>";
					$j = 0;
					foreach ($line as $cell) {
							$sniperarray[$i][$j] = htmlspecialchars($cell);
							//echo "<td>" . $sniperarray[$i][$j] . "</td>";
							
							$j++;
					}
					//echo "</tr>\n";
					$i++;
			}
			fclose($f);
			//echo "\n</table></body></html><br>";

			$shotgunarray = array(array());
			//echo "<html><body><table>\n\n";
			$f = fopen("shotgun.csv", "r");
			$i = 0;
			while (($line = fgetcsv($f)) !== false) {
					//echo "<tr>";
					$j = 0;
					foreach ($line as $cell) {
							$shotgunarray[$i][$j] = htmlspecialchars($cell);
							//echo "<td>" . $shotgunarray[$i][$j] . "</td>";
							
							$j++;
					}
					//echo "</tr>\n";
					$i++;
			}
			fclose($f);
			//echo "\n</table></body></html><br>";

			$riflearray = array(array());
			//echo "<html><body><table>\n\n";
			$f = fopen("rifle.csv", "r");
			$i = 0;
			while (($line = fgetcsv($f)) !== false) {
					//echo "<tr>";
					$j = 0;
					foreach ($line as $cell) {
							$riflearray[$i][$j] = htmlspecialchars($cell);
							//echo "<td>" . $riflearray[$i][$j] . "</td>";
							
							$j++;
					}
					//echo "</tr>\n";
					$i++;
			}
			fclose($f);
			//echo "\n</table></body></html><br>";

			$smgarray = array(array());
			//echo "<html><body><table>\n\n";
			$f = fopen("smg.csv", "r");
			$i = 0;
			while (($line = fgetcsv($f)) !== false) {
					//echo "<tr>";
					$j = 0;
					foreach ($line as $cell) {
							$smgarray[$i][$j] = htmlspecialchars($cell);
							//echo "<td>" . $smgarray[$i][$j] . "</td>";
							
							$j++;
					}
					//echo "</tr>\n";
					$i++;
			}
			fclose($f);
			//echo "\n</table></body></html><br>";
		?>
		
		<div class="selection">
			<select id="select-csv" onchange="display()">
				<option value = "0"></option>
				<option value = "1">Pistol</option>
				<option value = "2">Sniper</option>
				<option value = "3">Shotgun</option>
				<option value = "4">Rifle</option>
				<option value = "5">SMG</option>
			</select>
			<input type="number" id="luck" name="luck">
		</div>
		<br>
		<table id="rng-out"></table>
		<br>
		<button type="button" id="rng-btn">Click to Randomize!</button>
		<script>
			var passedArray;

			function display() {
				$("#rng-out").empty();
				var thisCSV = document.getElementById("select-csv");
				var selectCSV = thisCSV.options[thisCSV.selectedIndex].text;
				switch(selectCSV) {
					case "Pistol":
						passedArray = <?php echo json_encode($pistolarray); ?>;
						break;
					case "Sniper":
						passedArray = <?php echo json_encode($sniperarray); ?>;
						break;
					case "Shotgun":
						passedArray = <?php echo json_encode($shotgunarray); ?>;
						break;
					case "Rifle":
						passedArray = <?php echo json_encode($riflearray); ?>;
						break;
					case "SMG":
						passedArray = <?php echo json_encode($smgarray); ?>;
						break;
					default:
						passedArray = [];
						break;
				}
				/*
				var content = "";
				passedArray.forEach(function(row) {
					content += "<tr>";
					row.forEach(function(cell) {
						content += "<td>" + cell + "</td>";
					});
					content += "</tr>";
				});
				document.getElementById("csv-ref").innerHTML = content;
				*/
			}

			document.getElementById("rng-btn").addEventListener("click", function() {
				if(passedArray.length != 0) {
					$("#rng-out").empty();
					// Display the array elements
					var table = document.getElementById("rng-out");
					var header = table.insertRow(0);
					var c = header.insertCell(0);
					c.innerHTML = passedArray[0][0];
					c.colSpan = 8;
					var row = table.insertRow(1);
					for(var i = 0; i < (passedArray.length - 1); i++) {
						var cell = row.insertCell(i);
						switch(i) {
							case 0:
								cell.innerHTML = "Brand";
								break;
							case 1:
								cell.innerHTML = "Modifier";
								break;
							case 2:
								cell.innerHTML = "Damage";
								break;
							case 3:
								cell.innerHTML = "Range";
								break;
							case 4:
								cell.innerHTML = "Capacity";
								break;
							case 5:
								cell.innerHTML = "Reload";
								break;
							case 6:
								cell.innerHTML = "Misfire";
								break;
							case 7:
								cell.innerHTML = "Accuracy";
								break;
						}
					}

					var row = table.insertRow(2);
					var cellCount = 0;
					for(i = 1; i < passedArray.length; i++) {
						var cell = row.insertCell(cellCount);
						var luck = document.getElementById("luck").value;
						var res = 0;
						if(i > 2) {
							var rng = Math.floor(Math.random() * 100);
							console.log(rng, luck);
							rng += Number(luck);
							console.log(rng);
							if(rng > 100) {
								rng = 100;
							}
							if(rng <= 5) {
								// WORST
								res = 0;
								cell.style.color = "#c30f0e";
							} else if (rng <= 20) {
								// WORSE
								res = 1;
								cell.style.color = "#c45415";
							} else if (rng <= 40) {
								// BAD
								res = 2;
								cell.style.color = "#c5951d";
							} else if (rng <= 60) {
								// MID
								res = 3;
								cell.style.color = "#bac526";
							} else if (rng <= 80) {
								// GOOD
								res = 4;
								cell.style.color = "#899800";
							} else if (rng <= 95) {
								// BETTER
								res = 5;
								cell.style.color = "#6ead22";
							} else {
								// BEST
								res = 6;
								cell.style.color = "#45bf55";
							}
						} else {
							var rng = Math.floor(Math.random() * (passedArray[i].length));
							while(passedArray[i][rng] == "") {
								rng = Math.floor(Math.random() * (passedArray[i].length));
							}
							res = rng;
						}
						cell.innerHTML = passedArray[i][res];
						cellCount++;
					}
				}
			});
		</script>
	</div>
</body>
</html>
