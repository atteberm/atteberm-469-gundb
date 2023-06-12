<!DOCTYPE html>
<html>
<head>
	<title>GunDB Webapp - Edit</title>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>
    <?php
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        //echo "URL identified as: $url <br>";
        $link = str_replace("edit-page.php", "", $url);
        $link = $link . "index.php";
    ?>
    <div class="tabs">
        <h1 id="generate"><?php echo "<a href=\"" . $link . "\">Generate</a>" ?></h1><h1 id="current">Edit</h1>
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

		<select id="select-csv" onchange="displayTable()">
			<option value = "0"></option>
			<option value = "1">Pistol</option>
			<option value = "2">Sniper</option>
			<option value = "3">Shotgun</option>
			<option value = "4">Rifle</option>
			<option value = "5">SMG</option>
		</select>

		<br>
		
		<table id="csv-ref"></table>

		<br>

		<button type="button" id="submit-btn">Submit</button>

		<script>
			var passedArray;

			function displayTable() {
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
				}

				var content = "";
				var rowct = 0;
				passedArray.forEach(function(row) {
					var colct = 0;

					content += "<tr>";
					row.forEach(function(cell) {
						if(rowct > 0) {
							if(passedArray[rowct][colct]) {
								content += "<td><div class=\"container\"><textarea wrap=\"soft\">" + cell + "</textarea></div></td>";
							}
						} else {
							content += "<td><div class=\"container\">" + cell + "</div></td>";
						}
						colct++;
					});
					content += "</tr>";

					rowct++;
				});
				document.getElementById("csv-ref").innerHTML = content;

				
			}
			function submitCSV() {
				var resCSV = [[]];
				var data = [[]];
				var rows = document.getElementsByTagName("tr");

				for(var i = 0; i < rows.length; i++) {
					var row = [];
					if(i == 0) {
						var cols = rows[i].getElementsByTagName("td");
						for (var j = 0; j < cols.length; j++) {
							var clean = cols[j].innerText;
							console.log(i, j, cols[j], cols[j].innerText);
							if(passedArray[i][j]) {
								if(!clean) {
									alert("One or more fields are left blank, please make sure all randomization values are filled in.");
									return;
								}
							}
							else {
								//don't check for blank
							}
							row.push(clean.replaceAll(",",";"));
						}
					} else {
						var cols = rows[i].getElementsByTagName("textarea");
						for (var j = 0; j < cols.length; j++) {
							var clean = cols[j].value;
							console.log(i, j, cols[j], cols[j].value);
							if(passedArray[i][j]) {
								if(!clean) {
									alert("One or more fields are left blank, please make sure all randomization values are filled in.");
									return;
								}
							}
							else {
								//don't check for blank
							}
							row.push(clean.replaceAll(",",";"));
						}
					}
					
					console.log(row);
					if(i == 0) {
						data[0] = row;
					} else {
						data.push(row);
					}
				}

				resCSV = JSON.stringify(data);
				var thisCSV = document.getElementById("select-csv");
				var selectCSV = thisCSV.options[thisCSV.selectedIndex].text;
				var type = selectCSV.toLowerCase();
				type += ".csv";
				console.log(type);

				$.ajax({
					method: "POST",
					url: "submit.php",
					data: { csv: resCSV, flag: JSON.stringify(type) },
					success: function(msg) {
						alert("Data Saved For Weapon: " + msg);
					},
					error: function(e) {
						alert("Error: " + e);
					}
				});

				//window.location.replace('/edit-page.php');
				location.reload();
			}

			document.getElementById("submit-btn").addEventListener("click", function () {
				submitCSV();
			});
		</script>
	</div>
</body>
</html>