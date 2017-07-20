<?php
/**
 * Author: Darcey@AllForTheCode.co.uk
 * Date: 03/03/2016
 */

namespace AFTC\Framework\Libraries;


class RestLibrary
{
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function __construct()
	{
		
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	public function fileGetContents($url,$protocol,$method,$headers)
	{
		$options = [
			$protocol => [
				"method" => $method
			]
		];

		if (is_array($headers)){
			foreach ($headers as $key => $value) {
				$options[$protocol][$key] = $value;
			}
		}

		$context = stream_context_create($options);
		$data = file_get_contents($url,false,$context);

		return $data;

		/*
		$options = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>"CustomHeader: yay\r\n" .
					"AnotherHeader: test\r\n"
			)
		);
		$context=stream_context_create($options);
		$data=file_get_contents('http://www.someservice.com/api/fetch?key=1234567890',false,$context);
		*/
	}
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


/*
	function CallAPI($method, $url, $data = false)
	{
		$curl = curl_init();

		switch ($method)
		{
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);

				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_PUT, 1);
				break;
			default:
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}

		// Optional Authentication:
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "username:password");

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($curl);

		curl_close($curl);

		return $result;
	}*/


}