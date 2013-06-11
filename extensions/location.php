<?php
	// PONGSOCKET TWEET ARCHIVE
	// Location extension
	// Built by Bramus! - http://www.bram.us/
	
	define('GMAPS_API_KEY', '');
	
	class Extension_Location {
		public function displayTweet($d, $tweet){
			if (GMAPS_API_KEY != '')
			{
				$coords = @unserialize($tweet['coordinates']);
				if (isset($coords->coordinates) && ($coords->coordinates[0] != 0 || $coords->coordinates[1] != 0))
				{
					preg_match("/^([\t]+)</", $d, $m); $x = $m[1];
					$ds    = explode("\n", $d, 2);		
					$extra = '<a class="pic map" href="http://maps.google.com/?ie=UTF8&amp;ll='.$coords->coordinates[1].','.$coords->coordinates[0].'"><img src="http://maps.google.com/staticmap?size=150x150&amp;center='.$coords->coordinates[1].','.$coords->coordinates[0].'&amp;maptype=hybrid&amp;zoom=15&amp;markers='.$coords->coordinates[1].','.$coords->coordinates[0].'&amp;key='.GMAPS_API_KEY.'" width="150" height="150" /></a>';
					$d     = implode("\n", array($ds[0], rtrim($extra, "\n"), $ds[1]));
				}
			}
			return array($d, $tweet);
		}
	}
	
	$o = new Extension_Location();