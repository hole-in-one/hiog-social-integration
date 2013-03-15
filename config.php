<?php
/**
*
* @package 			HIOG
* @version $Id:		config.php 2012/12/10 10:01:45 PM
* @copyright		(c) 2013 Hole In One Golf
* @link					http://hiog.mobi/
* @author				R P du Plessis <renduples@gmail.com>
* @description	Configuration settings
*
*/


// Admin notifications
adminEmail = renduples@gmail.com


// Database
mobiPort = 3306
mobiUser = root
mobiPwrd = toor
mobiHost = localhost
mobiDb = hioc


// Contact page
senderEmail = noreply@hioc.mobi
supportEmail = enduples@gmail.com


// Timezone see http://www.php.net/manual/en/timezones.php for supported timezones
timeZone = Africa/Johannesburg		 


// Available languages eng,por,afr (must correspond with headings in language.csv)
langDefault = eng																


// Allow language switching by users
langSwitch = 0


// Display system errors - not recommended for production env
debugMe = 1


// General interface logging
keepLog = 0


// Keeping vital stats
keepStats = 0


// Browser cookies - 60*60*24*360 days by default
cookieExpire = 31536000 
cookiePath = /


// Body
bodyFontColor = #000
bodyFontSize = 0.75EM
bodyFontFamily = arial
bodyBackgroundColor = #FFF


// Mast
mastHeight = 2.5EM
mastImage = masthead2.jpg
mastImageWidth = 120
mastImageHeight = 34
mastBackgroundImage = mastbg.jpg


// Menu
menuLinkColor = #000
menuLinkFontSize = 0.75EM
menuFontSize = 1EM
menuBorderBottomWidth = 0.25EM
menuBorderBottomColor = #999999
menuPaddingBottom = 0.25EM
menuPaddingLeft = 0.25EM


// Heading
headingFontColor = #000
headingFontFamily = arial
headingFontSize = small
headingFontWeight = bold
headingPaddingTop = 0.25EM
headingPaddingRight = 0EM
headingPaddingBottom = 0.25EM
headingPaddingLeft = 0EM


// Footer
footerPaddingTop = 0.25EM
footerBorderTopWidth = 0EM
footerBorderTopStyle = solid
footerBorderTopColor = #666666

?>
