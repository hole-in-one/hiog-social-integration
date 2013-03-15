<?php
/**
*
* @package 			Hole In one Golf
* @version $Id:		Model.php
* @author			R P du Plessis <renduples@gmail.com>
* @description		Perform some db stuff
*
*/

class Model
{
	protected $debug;
	protected $config;
	
	public function __construct($config) 
	{
		$this->config = $config;
		$this->debug = $config->debugMe;	
	}


   get_winners() #returns last 5 winners


	/**
	* List latest players
	*/	
	function get_latest_members($count)
	{
			$query = 'SELECT * FROM players ORDER BY id DESC LIMIT ' . $count . ';';

			try { 
												    		$mysqli = new mysqli($this->config->mobiHost, $this->config->mobiUser, $this->config->mobiPwrd	, $this->config->mobiDb);
												    		if ($mysqli->connect_errno) 
																{
																		if ($this->debug) echo $mysqli->connect_error;
																		die('<br>E202: Service unavailable');
																}
			} catch (Exception $e) {
			    											die('<br>E201: Service unavailable');
			}	

			if ($result = $mysqli->query($query))
			{
					$data = false;
			
					if ($mysqli->warning_count) 								// Catch cluster warnings
					{
							if ($this->debug) echo $mysqli->get_warnings;
			   			die('<br>E204: Service unavailable');
					}
			
			    while ($row = $result->fetch_object()) 
			    {
			        $data[] = $row;
			    }		
					$result->free();
					$mysqli->close();
			
					return $data;
			}

	
			/**
			* Ok - no data exist
			* Have the controller switch to the 404 view
			*/	
			return false;
	}
	
	
	/**
	* Current Contestant count
	*/	
	function current_contestants()
	{
			$query = 'SELECT count(*) FROM vouchers WHERE `to` > ' . time() . ';';

			try { 
												    		$mysqli = new mysqli($this->config->mobiHost, $this->config->mobiUser, $this->config->mobiPwrd	, $this->config->mobiDb);
												    		if ($mysqli->connect_errno) 
																{
																		if ($this->debug) echo $mysqli->connect_error;
																		die('<br>E202: Service unavailable');
																}
			} catch (Exception $e) {
			    											die('<br>E201: Service unavailable');
			}	

			if ($result = $mysqli->query($query))
			{
					$data = false;
			
					if ($mysqli->warning_count) 								// Catch cluster warnings
					{
							if ($this->debug) echo $mysqli->get_warnings;
			   			die('<br>E204: Service unavailable');
					}
			
				    while ($row = $result->fetch_array()) 
				    {
				        return $row[0];
				    }		
					$result->free();
					$mysqli->close();
			
					return $data;
			}

	
			/**
			* Ok - no data exist
			* Have the controller switch to the 404 view
			*/	
			return false;
	}
	
	
	/**
	* Prizemoney
	* Param: $strokes (1 = hole in one; 2 = two club) 
	*/	
	function prize_money($strokes)
	{
			$query = 'SELECT SUM(amount) - (SELECT SUM(amount) FROM funds WHERE strokes = ' . $strokes . ' AND debit = false)
								FROM funds WHERE strokes = ' . $strokes . ' AND debit = true;';

			try { 
												    		$mysqli = new mysqli($this->config->mobiHost, $this->config->mobiUser, $this->config->mobiPwrd	, $this->config->mobiDb);
												    		if ($mysqli->connect_errno) 
																{
																		if ($this->debug) echo $mysqli->connect_error;
																		die('<br>E202: Service unavailable');
																}
			} catch (Exception $e) {
			    											die('<br>E201: Service unavailable');
			}	

			if ($result = $mysqli->query($query))
			{
			    while ($row = $result->fetch_array()) 
			    {
			        return $row[0];
			    }		
					$result->free();
					$mysqli->close();					
			}



			/**
			* Ok - no data exist
			* Have the controller switch to the 404 view
			*/	
			return false;
	}


	/**
	* Current Claim count
	* Param: $hours (24,48, etc)
	*/	
	function current_claims($hours)
	{
			$duration = time() - 60*60*$hours;
			$query = 'SELECT count(*) FROM claims WHERE `time` > ' . $duration . ';';

			try { 
												    		$mysqli = new mysqli($this->config->mobiHost, $this->config->mobiUser, $this->config->mobiPwrd	, $this->config->mobiDb);
												    		if ($mysqli->connect_errno) 
																{
																		if ($this->debug) echo $mysqli->connect_error;
																		die('<br>E202: Service unavailable');
																}
			} catch (Exception $e) {
			    											die('<br>E201: Service unavailable');
			}	

			if ($result = $mysqli->query($query))
			{
					$data = false;
			
					if ($mysqli->warning_count) 								// Catch cluster warnings
					{
							if ($this->debug) echo $mysqli->get_warnings;
			   			die('<br>E204: Service unavailable');
					}
			
				    while ($row = $result->fetch_array()) 
				    {
				        return $row[0];
				    }		
					$result->free();
					$mysqli->close();
			
					return $data;
			}

	
			/**
			* Ok - no data exist
			* Have the controller switch to the 404 view
			*/	
			return false;
	}
	

	/**
	* Past winners
	* Param: $count
	*/	
	function past_winners($count)
	{
			$query = 'SELECT claims.time, claims.club, vouchers.playerid, players.name, players.handicap 
						FROM claims 
						JOIN vouchers on claims.voucher = vouchers.serial 
						JOIN players on vouchers.playerid = players.id
						WHERE `success` = true ORDER BY claims.id DESC LIMIT ' . $count . ';';

			try { 
												    		$mysqli = new mysqli($this->config->mobiHost, $this->config->mobiUser, $this->config->mobiPwrd	, $this->config->mobiDb);
												    		if ($mysqli->connect_errno) 
																{
																		if ($this->debug) echo $mysqli->connect_error;
																		die('<br>E202: Service unavailable');
																}
			} catch (Exception $e) {
			    											die('<br>E201: Service unavailable');
			}	

			if ($result = $mysqli->query($query))
			{
					$data = false;
			
					if ($mysqli->warning_count) 								// Catch cluster warnings
					{
							if ($this->debug) echo $mysqli->get_warnings;
			   			die('<br>E204: Service unavailable');
					}
			
				    while ($row = $result->fetch_object()) 
				    {
				        $data[] = $row;
				    }		
					$result->free();
					$mysqli->close();
			
					return $data;
			}

	
			/**
			* Ok - no data exist
			* Have the controller switch to the 404 view
			*/	
			return false;
	}

					
}

?>