<?php

echo '<H2>'.$PageOptions['SGSTitle'].'</H2>';

$output = shell_exec('/usr/local/bin/sgsremote '.$PageOptions['SGSServer'].' list all');
$oparray = preg_split('/\n+/', $output);
unset($oparray[0]);	#get rid of the header
array_pop($oparray);	#get rid of the last element

echo "<table class='listingtable' cellpadding='3'><tr><th>Logon</th><th>Logoff</th><th>Channel</th><th>Description</th><th>Status</th><th>Reflector</th><th>Timeout</th></tr>\n";

$bg = "#F1FAFA"; 
foreach ($oparray as $array) {
	$logon   = substr($array, 0, 6);
	$logoff  = substr($array, 9, 8);
	$channel = substr($array, 18, 8);
	$desc    = substr($array, 27, 20);
	$status  = substr($array, 48, 8);
	$refl    = substr($array, 57, 8);
	$refl	 = "XLX" . substr($refl,3);
	$timeout = substr($array, 69, 4);

	if ($bg == "#FFFFFF") { $bg = "#F1FAFA"; } else { $bg = "#FFFFFF"; }
	echo '<tr bgcolor="'.$bg.'"><td>'.$logon.'</td><td>'.$logoff.'</td><td>'.$channel.'</td><td>'.$desc.'</td><td>'.$status.'</td><td>'.$refl.'</td><td align="right">'.$timeout.'</td></tr>';
	}
echo "</table>";

foreach ($oparray as $confs) {
	$login = substr($confs, 0, 6);
	$desc  = substr($confs, 27, 20);

	$output = shell_exec('/usr/local/bin/sgsremote "'.$PageOptions['SGSServer'].'" list "'.$login.'" | grep User\ = | cut -d "=" -f2- | cut -d " " -f2-');

	$oparray = preg_split('/\n+/', trim($output));

	echo "<H4>$login - $desc</H4>\n\n";
	echo "<table class='listingtable' cellpadding='3'><tr><th>Callsign</th><th>Last Heard</th></tr>";

	if ($output) {
		foreach($oparray as $array) {
			if ($bg == "#FFFFFF") { $bg = "#F1FAFA"; } else { $bg = "#FFFFFF"; }
			$line = preg_split('/,\s+/', $array);
			[$callsign, $timer] = $line;
			preg_match_all('!\d+!', $timer, $min);
			$minutes = $min[0][0];
			$timer = "$minutes minutes ago";

			$basecs = substr($callsign, 0, strpos($callsign, ' '));
			echo '<tr bgcolor="'.$bg.'"><td><a href="https://www.qrz.com/db/'.$basecs.'">'.$callsign.'</a></td><td align="right">'.$timer.'</td></tr>';
		}
	}
	else {
		if ($bg == "#FFFFFF") { $bg = "#F1FAFA"; } else { $bg = "#FFFFFF"; }
		echo '<tr bgcolor="'.$bg.'"><td>Quiet</td><td>Now</td></tr>';
	}

	echo "</table>\n";
}

$now = date('Y-m-d H:i:s');
echo "<BR><BR><I>Last updated: $now</I>\n";

?>
