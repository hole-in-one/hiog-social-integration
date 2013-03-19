#!/usr/bin/php
<?php
/**
*
* @package      HIOG
* @version      $Id: controller.php
* @author       Temba Mazingi
* @description  read and write configuration parameters to file
* @resources     https://github.com/dtompkins/fbcmd, https://github.com/dg/twitter-php, http://oauth.googlecode.com/svn/code/php/
*
**/


/**
* set timezone
**/
date_default_timezone_set('Africa/Johannesburg');


/**
* Load config and model
**/
set_time_limit(0);
define('APP_PATH', dirname(__FILE__) . '/');
define('TWITTER_API_MAX_CALLS_PER_INTERVAL', 60);
define('FB_API_MAX_CALLS_PER_INTERVAL', 60);
require_once APP_PATH . 'includes/loadSetup.php';
$conf = new Config('config.php');

require_once APP_PATH . 'includes/Model.php';
$Model = new Model($conf);

require APP_PATH . 'config/twitter.php';
require APP_PATH . 'includes/functions.php';
require APP_PATH . 'includes/twitter/twitter.class.php';

while(true)
{

  // Reset API call counters
  $facebook_api_calls = $twitter_api_calls = 0;
  $facebook_posts = $tweets = array();
  $conversation = '';

  //  Get prize money
  $prize_money = $Model->prize_money(1);
  if(intval($prize_money) > 0)
  {

    $conversation = "The Hole In One prize money has reached R"  . number_format($prize_money) . "!";
    $tweets[] = $conversation;
    $facebook_posts[] = $conversation;

    $conversation =  "Remember, you can only win if you have entered, visit http://hiog.mobi for more information.";
    $tweets[] = $conversation;
    $facebook_posts[] = $conversation;

  }

  // Get latest members.
  $latest_members = $Model->get_latest_members(5);
  if(is_array($latest_members))
  {

    foreach ($latest_members as $latest_member)
    {

      $today = new DateTime("now");
      $date_joined = new DateTime(date('Y-m-d H:i:s', $latest_member->joined));
      $date_joined_formatted = date('d F Y', $latest_member->joined);
      $interval = intval($today->diff($date_joined)->format("%d"));

      if(is_int($interval) && $interval <= 1)
      {

        $conversation = $latest_member->name . ', from ' . $latest_member->club . ' joined the Hole In One Golf competition on ' . $date_joined_formatted;
        $tweets[] = $conversation;
        $facebook_posts[] = $conversation;

      }

    }

    $conversation = "We invite all golfing enthusiasts to join the Hole In One Golf competition!";
    $tweets[] = $conversation;
    $facebook_posts[] = $conversation;

  }

  // Get total number of contestants for current round.
  $current_contestants = $Model->current_contestants();
  if(intval($current_contestants) > 0)
  {

    $conversation = "We have so far "  . $current_contestants . " contestants for the current round of the Hole In One competition";
    $tweets[] = $conversation;
    $facebook_posts[] = $conversation;

    $conversation =  "Have you booked your place yet to win big in the Hole In One competition? Enter now, visit http://hiog.mobi for more information.";
    $tweets[] = $conversation;
    $facebook_posts[] = $conversation;

  }

  // Get claims on prize money
  $current_claims = $Model->current_claims(24);
  if(intval($current_claims) > 0)
  {
    $conversation = $current_claims . " claim(s) have been submitted for the Hole In One jackpot prize in the last 24 hours!";
    $tweets[] = $conversation;
    $facebook_posts[] = $conversation;
    $conversation = "The winners will be announced once the vetting process is completed.";
    $tweets[] = $conversation;
    $facebook_posts[] = $conversation;

  }else{

    $conversation = "Did you hit a hole in one on the course today? If you did, submit your claim for the Hole In One jackpot prize right now! http://hiog.mobi";
    $tweets[] = $conversation;
    $facebook_posts[] = $conversation;
  }

  //  Get last three winners
  $past_winners = $Model->past_winners(3);
  if(is_array($past_winners))
  {

    $conversation = "Congratulations to our last three successful claims on the Hole In One Golf jackpot prize!";
    $tweets[] = $conversation;
    $facebook_posts[] = $conversation;

    foreach ($past_winners as $past_winner)
    {

      $conversation = $past_winner->name . ', from ' . $past_winner->club . ' with a handicap of ' . $past_winner->handicap . '.';
      $tweets[] = $conversation;
      $facebook_posts[] = $conversation;

    }

  }

  // Process Facebook posts
  try
  {

    $fb_cli_check = 'which fbcmd';
    $fb_cli = shell_exec($fb_cli_check);

    if($fb_cli)
    {

      msg('Processing Facebook posts...');

      foreach ($facebook_posts as $facebook_post)
      {

        msg('Facebook post composed: ' . $facebook_post);
        $fb = 'fbcmd as 322799257840557 post "' . $facebook_post . '"';
        $output = shell_exec(escapeshellcmd($fb));
        msg($output);
        sleep (30);

      }

      msg('Processing Facebook posts complete!');

    }else{

      throw new Exception('Error: Facebook Command Line Interface unable. Please go to https://github.com/dtompkins/fbcmd to get more information.');

    }

  }catch(Exception $e){

    msg($e->getMessage());

  }


  // Process tweets
  try
  {

    $twitter = new Twitter(CUSTOMER_TOKEN, CUSTOMER_SECRET, ACCESS_TOKEN, ACCESS_SECRET);

    if($twitter)
    {

      msg('Processing tweets....');

      foreach ($tweets as $tweet)
      {

        msg('Tweet composed: ' . $tweet);
        $status = tweetable($tweet) ? $twitter->send($tweet): false;
        $status ? $twitter_api_calls++ : $twitter_api_calls;
        $status ? msg('Tweet posted!') : msg('Tweet failed! :-(');
        sleep (30);

      }

      msg('Processing tweets complete!');


    }else{

      throw new Exception('Error: Unable to access the Twitter API. Please verify your API access credentials in config/twitter.php.');

    }

  }catch(Exception $e){

    msg($e->getMessage());

  }

  msg('Further processing deferred for the next 18 hours.');
  sleep (64800000);


}
?>