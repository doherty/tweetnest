<?php
	// PONGSOCKET TWEET ARCHIVE
	// Link entity display extension

	// pieces inspired by https://github.com/themattharris/tmhOAuth/blob/master/tmhUtilities.php

	class Extension_Entities {
		public function enhanceTweet($tweet){
		// url -> expanded_url
		    if (!isset($tweet['extra']['entities'])) {
		      return $tweet;
		    }

		    $keys = array();

		    foreach($tweet['extra']['entities']->urls as $u) {

			if(!isset($u->display_url) && empty($u->expanded_url)) continue;

			$url = empty($u->expanded_url) ? $u->url : $u->expanded_url;

		        $keys[$u->indices['0']] = substr(
		          $tweet['text'],
		          $u->indices['0'],
		          $u->indices['1'] - $u->indices['0']
		        );
		        $replacements[$u->indices['0']] = $url;

		    }

		    ksort($replacements);
		    $replacements = array_reverse($replacements, true);
		    $entified_tweet = $tweet['text'];
		    foreach ($replacements as $k => $v) {
		      $entified_tweet = substr_replace($entified_tweet, $v, $k, strlen($keys[$k]));
		    }
		    $replacements = array(
		      'replacements' => $replacements,
		      'keys' => $keys
		    );
		    $tweet['text'] = $entified_tweet;

			return $tweet;
		}
		
		public function displayTweet($d, $tweet){
		// (probably) unnecessary if enhanceTweet() has run already
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
