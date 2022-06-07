<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\Ec2\Ec2Client;
use Atymic\Twitter\Facade\Twitter;
use File;
use TwitterStreamingApi;


class HerOkuController extends Controller
{
    public function twitterUserTimeLine()
    {
    	// $data = Twitter::getUserTimeline(['count' => 100, 'format' => 'array']);
    	// return view('tweets', compact('data'));

        TwitterStreamingApi::publicStream()
        ->whenHears('#laravel', function(array $tweet) {
            echo "{$tweet['user']['screen_name']} tweeted {$tweet['text']}";
        })
        ->startListening();


    }
  
  
  
  public function getTweetsFromServer()
    {
        $url = public_path().'/tweets/tweets.json';
        $response = file_get_contents($url);

        $tweets = array();

        $da = json_decode($response);

        foreach ($da as $key) {
            array_push($tweets,
                    [
                        'tweetId' => $key->tweetId,
                        'text' => $key->text
                    ]
                );
        }
        
        return $tweets;
    }
}
