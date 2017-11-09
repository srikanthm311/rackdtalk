<?php

/**
 * CodeIgniter helper for generate share url and buttons (Twitter, Facebook, Buzz, VKontakte)
 *
 * @version 1.0
 * @author Ibragimov Renat <info@mrak7.com> www.mrak7.com
 */

if( !function_exists('time_ago') ){
	/**
	 * Check type of share and return $URL or FALSE
	 * 
	 * @param	string $type	type of share
	 * @return	string|bool
	 */
		function time_ago( $time )
       {
        $out    = ''; // what we will print out
        $now    = time(); // current time
        $diff   = $now - $time; // difference between the current and the provided dates
		//return  $diff;exit;

        if( $diff < 60 ) // it happened now
            return TIMEBEFORE_NOW;

        elseif( $diff < 3600 ) // it happened X minutes ago
            return str_replace( '{num}', ( $out = round( $diff / 60 ) ), $out == 1 ? TIMEBEFORE_MINUTE : TIMEBEFORE_MINUTES );

        elseif( $diff < 3600 * 24 ) // it happened X hours ago
            return str_replace( '{num}', ( $out = round( $diff / 3600 ) ), $out == 1 ? TIMEBEFORE_HOUR : TIMEBEFORE_HOURS );

        elseif( $diff < 3600 * 24 * 2 ) // it happened yesterday
            return TIMEBEFORE_YESTERDAY;
			
	    elseif( $diff < 3600 * 24 * 7 ) // it happened yesterday
            return str_replace( '{num}', ( $out = round( $diff / (3600*24) ) ), $out == 1 ? TIMEBEFORE_DAY : TIMEBEFORE_DAYS );
		
			
	    elseif( $diff < 3600 * 24 * 30) // it happened X weeks ago
            return str_replace( '{num}', ( $out = floor( $diff / (3600*24*7) ) ), $out == 1 ? TIMEBEFORE_WEEK : TIMEBEFORE_WEEKS );
	   	
	   elseif( $diff < 3600 * 24 * 30 * 12) // it happened X months ago
            return str_replace( '{num}', ( $out = floor( $diff / (3600*24*30) ) ), $out == 1 ? TIMEBEFORE_MONTH : TIMEBEFORE_MONTHS );
			
	   else 
			return date('M d, Y',$time);
		

       /* else // falling back on a usual date format as it happened later than yesterday
           return  strftime( date( 'Y', $time ) == date( 'Y' ) ? TIMEBEFORE_FORMAT : TIMEBEFORE_FORMAT_YEAR, $time );*/
    }
	
		
}

// Encrypt Decrypt Function
if( !function_exists('encrypt_decrypt') ){

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'MUZIC';
    $secret_iv = 'secret_muzic';

    // hash
    $key = hash('sha256', $secret_key);
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

}





?>