<?php
echo '<meta http-equiv="refresh" content="5">';
$log = json_decode(file_get_contents('log'), true);
echo '<table>';
for ($i = count($log) - 1; $i >= 0; $i--) {
	echo '<tr><td>', $log[$i]['uri'];
	echo '</td><td>', $log[$i]['class'];
	echo '</td><td>', $log[$i]['function'];
	echo '</td><td>', date('m-d H:i:s', $log[$i]['time']);
	echo '</td><td>', htmlspecialchars(json_encode($log[$i]['data']));
	echo '</td></tr>';
}
echo '</table>';

