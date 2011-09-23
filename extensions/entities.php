<?php
	// PONGSOCKET TWEET ARCHIVE
	// Link entity display extension

	// pieces inspired by https://github.com/themattharris/tmhOAuth/blob/master/tmhUtilities.php

	class Extension_Entities {
		public function enhanceTweet($tweet){
			return $tweet;
		}
		
		public function displayTweet($d, $tweet){
			@$tweetextra = unserialize($tweet['extra']);
			if(array_key_exists("entities", $tweetextra)){

				foreach($tweetextra['entities']->urls as $u) {

					if(!isset($u->display_url) && empty($u->expanded_url)) continue;

					$url = empty($u->expanded_url) ? $u->url : $u->expanded_url;
					$display = isset($u->display_url) ? $u->display_url : str_replace('http://', '', $url);

					$e = str_replace('k" href="' . $u->url . '"', 'k" href="' . $url . '"', $d);
					$d = str_replace('">' . $u->url . '<', '">' . $display . '<', $e);

				}

			}
			return array($d, $tweet);
		}
	}
	
	$o = new Extension_Entities();
