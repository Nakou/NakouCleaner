<?php

/**
*
* Nakou PHP Cleaner
* Clean a line in all your project.
* 
* by Nakou : @Nakou on Twitter or Nakou on GitHub
* Licence CC
*
*/


/*

FUNCTIONS

*/

/**
*cleanFile
* @param $file ressource file target
* @param $toDelete string to delete on files
*/
function cleanFile($file, $toDelete){
	$textFlux = fopen($file, 'r') or die("File missing (1)");
	$actualContent = file_get_contents($file);
	$newContent = str_replace($toDelete, "", $actualContent);
	fclose($textFlux);

	$textFlux2 = fopen($file, "w+") or die("File missing (2)");
	fwrite($textFlux2, $newContent);
	fclose($textFlux2);
}


/**
*cleanDir
* @param $dir ressource directory target
* @param $toDelete string to delete on files
*/
function cleanDir($dirString, $toDelete){
	echo "Enter CleanDir : $dirString";
	if($dirRess = opendir($dirString)){
		while(false != ($entry = readdir($dirRess))){
			if($entry != ".." && $entry != "." && $entry != basename(__FILE__)){
				if(is_dir( $dirString . '/' . $entry)){
					//echo "DIR : " . $dirString . '/' . $entry."\n";
					cleanDir( $dirString . '/' . $entry . "/", $toDelete);
				} else if(is_file($dirString . '/' . $entry)){
					//echo "FILE :" . $dirString . '/' . $entry."\n";
					cleanFile($dirString . '/' . $entry, $toDelete);
				} else {
					//echo "\n".$entry."\n";
				}
			}
		}
	}
}

/*

PAGE

*/

echo "\nPHPCleaner\n";

if(empty($argv)){
	echo "\nYou need to specify argument. Type -h for help.\n";
} else {
	if(in_array("-h", $argv))
		echo "\nHere the correct syntax : /usr/bin/php NakouCleaner.php YourStringToSupress /target/dir
			  \nIf you have a string with \"\" or spaces, dont forget to use simple quote
			  \nYou cannot specify the target folder, you have to place the script into the main folder.";
	elseif($argc == 3){
		$stringToDelete = $argv[1];
		$dir = dirname($argv[2]);
		echo "\nCheck of ".$stringToDelete." in \"".$dir['dirname']."/\" and his subtree\n";
		//echo "\nDEBUG TEST : \n";
		//cleanFile("/dns/net/internethic/Users/abo/Sites/test/www.bck.130305/holiday-rental-2.html",$stringToDelete);
		cleanDir($dir['dirname']."/",$stringToDelete);
	}
}
?>