<?php
/**
* Detect whether interface is CLI or web.
*/
define("CLI", !isset($_SERVER['HTTP_USER_AGENT']) );


/**
* Display CLI output
*/
function msg($message)
{
    if (!CLI)
    {
      print("\n\t[" . date('d/m Y H:i') . '] ' . $message . ' (' . strlen($message) . ')');
    }
}


/**
* Email message from app.
*/
function send_mail($recipient = EMAIL_TO, $subject, $message)
{
  $from = "From: " . EMAIL_FROM . "\r\n";
  $subject = 'Social Integration Engine Notification';
  $message = date("l, F j, Y, g:i a") . "[EST]" . "\n\n" . stripcslashes($message) . "\n\n";
  $sent = mail($email, $subject, $message, $from);
  return $sent;
}

/**
* Pause making API calls for a set period.
*/
define('SLEEP_INTERVAL', 60);

function pause_api_calls()
{

  msg('------------------------------------------------------------------------------------------');
  msg('Time-out: Avoiding getting blacklisted for making too many API calls');
  msg('------------------------------------------------------------------------------------------');

  time_sleep_until(microtime(true) + SLEEP_INTERVAL);

  msg('------------------------------------------------------------------------------------------');
  msg('Back to work: API time-out interval over.');
  msg('------------------------------------------------------------------------------------------');

}

function tweetable($msg)
{

  $tweetable = false;

  if(strlen($msg) <= 140)
  {
    $tweetable = true;
  }

  return $tweetable;

}

?>