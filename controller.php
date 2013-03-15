<?php
/**
*
* @package 			Hole In one Golf
* @version $Id:		controller.php
* @author			T3MB4
* @description		read and write configuration parameters to file
*
*/


/**
* set timezone
*/
date_default_timezone_set('Africa/Johannesburg');	


/**
* Load config and model
*/
require_once('includes/loadSetup.php');
$conf = new Config('config.php');
require_once('includes/Model.php');	
$Model = new Model($conf);


/**
* Do some stuff
*/
function get_latest_members($count)
{
	$data = $Model->get_latest_members($count);

	// Do some stuff wuth the data
}


?>