<?php
// http://stackoverflow.com/questions/20642598/detect-country-city-php-with-maxmind-geoip 

	$user_ip= !empty($user_ip) ? $user_ip : $_SERVER['REMOTE_ADDR'];
	spl_autoload_register('func888'); function func888($class){ include_once(str_replace(array('/','\\'), DIRECTORY_SEPARATOR, dirname(__file__)."/$class.php")) ;}
	use GeoIp2\Database\Reader; 
	//you can do it for "city" too.. just everywhere change phrase "country" with "city".
	try{
		$reader = new Reader(dirname(__file__)."/GeoLite2-Country.mmdb");
		$record = $reader->country($user_ip);
		$reader->close();
		$country_name =  $record->raw['country']['names']['en'];
	}
	catch ( GeoIp2\Exception\AddressNotFoundException $e ){    $country_name = 'not_found';  }


