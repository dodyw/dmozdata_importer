<?php  
	$file = "Japanese_listing.txt";
	$limit = 20000;

	/*************** do not edit here ***************/

	$new_filename = substr($file, 0, -4);
	$lines = file($file);
	$files = array();

	while ($i<count($lines)) {
		$j=ceil(($i+1)/$limit);

		if (!in_array($j, $files)) $files[] = $j;

		$data[$j][]=$lines[$i];

		$i++;
	}

	foreach ($files as $k => $v) {
		print "writing $new_filename"."_".$v.".txt ...<br>";
		flush();
		file_put_contents($new_filename.'_'.$v.'.txt', join("",$data[$v]));
		unset($data[$v]);
	}	

?>