<?php
namespace App\Helpers;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;
use Auth;
use Config;

class Taximail
{
	public static function authen ($value='')
	{
		$user = array(
			'username' => Config::get('constants.TAXIMAIL.USERNAME'),
			'password' => Config::get('constants.TAXIMAIL.PASSWORD'),
		);

		$response = Curl::to(Config::get('constants.TAXIMAIL.ENDPOINT').'user/login')
	        ->withData($user)
	        ->asJson()
	        ->post();

	    $result = array();

	    if ($response->status == 'success') {
	    	$result = $response->data;
	    }

	    return $result;
	}

	public static function sendTransactionalEmail($data)
	{
    	// $data = array(
     //     	'session_id' => 'c7019dc77c086bbcc9eb2d50612f3b5b',
     //     	'message_id' => 'msgid_0000004',
     //     	'transactional_group_name' => 'default',
     //     	'subject' => 'test sending email from system (taximail)',
     //     	'to_name' => 'Khunbiw',
     //     	'to_email' => 'biw@i3gateway.com',
     //     	'from_name' => 'taximail system',
     //     	'from_email' => 'noreply.i3gateway@gmail.com',
     //     	'content_html' => '',
     //    );

		// $result = array();

    	// Send a POST request to: http://www.foo.com/bar with arguments 'foz' = 'baz' using JSON
	    $response = Curl::to(Config::get('constants.TAXIMAIL.ENDPOINT').'transactional')
	        ->withData($data)
	        ->asJson()
	        ->post();

	    return $response;
	}

	public static function getMessageStatus($session_id, $message_id)
	{
		$params = array(
			'session_id' => $session_id,
		);

		$response = Curl::to(Config::get('constants.TAXIMAIL.ENDPOINT').'transactional/'. $message_id)
			->withData($params)
	        ->asJson()
	        ->get();

	    return $response;
	}

	public static function generateMessageId()
	{
		$hash = sha1(rand().microtime());
		$result = substr($hash, 0, 8);
		return 'mid_'.$result;
	}
}
?>