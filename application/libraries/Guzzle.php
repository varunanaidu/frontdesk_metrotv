<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  ===================
 *	----- EXAMPLE -----
 *	===================
 *	$this->load->library('guzzle');
 *	================================================================================================
 *	*** GET EMPLOYEE DATA ***
 *	* return all employee
 *	$guzzle = $this->guzzle->guzzle_HRIS('employee/get);		
 *	* return specific employee
 *	$guzzle = $this->guzzle->guzzle_HRIS('employee/get', ['nip' => string]);
 * 
 * ! DO NOT POST DATA WITH ARRAY KEY NAME = ['prs', 'userkeys']
 * 
 */
class Guzzle
{
	private $CI;
	protected $client;
	protected $cookieJar;
	protected $apiHrisKey;
	protected $apiHris;
	protected $apiFoodCoupon;
	protected $apiMail;
	protected $logPrs;

	function __construct()
	{
		$this->client 			= new \GuzzleHttp\Client();
		$this->cookieJar 		= new \GuzzleHttp\Cookie\CookieJar;
		$this->apiHrisKey 		= 'hris-keys';
		$this->apiHris 			= HRIS_API . 'hris/';
		$this->apiFoodCoupon 	= HRIS_API . 'fc/';
		$this->apiMail 			= 'https://idocs-mail-api.metrotv.co.id/v1/';
		//config
		$this->CI = &get_instance();
		$this->CI->load->library("user");
		// $this->logPrs = $this->CI->user->getPrs();
	}

	function search_HRIS($uri, $params = false)
	{
		$postData['userkeys'] = $this->apiHrisKey;
		// if (!empty($this->logPrs)) $postData['prs'] = $this->logPrs;
		if ($params) $postData += $params;
		try {
			$response = $this->client->request('POST', HRIS_API . 'search/' . $uri, [
				'form_params' => $postData,
				'cookies' => $this->cookieJar
			]);
			return $response->getBody()->getContents();
		} catch (\GuzzleHttp\Exception\ConnectException $e) {
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> '500',
				'message'		=> 'Unable to connect to the server',
				'exception'		=> $e->getMessage()
			]);
		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'Unable to connect to the server'
			]);
		}
	}

	function guzzle_HRIS($uri, $params = false)
	{
		$postData['userkeys'] = $this->apiHrisKey;
		if (!empty($this->logPrs)) $postData['prs'] = $this->logPrs;
		if ($params) $postData += $params;
		try {
			$response = $this->client->request('POST', $this->apiHris . $uri, [
				'form_params' => $postData,
				'cookies' => $this->cookieJar
			]);
			return $response->getBody()->getContents();
		} catch (\GuzzleHttp\Exception\ConnectException $e) {
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> '500',
				'message'		=> 'Unable to connect to the server',
				'exception'		=> $e->getMessage()
			]);
		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'Unable to connect to the server'
			]);
		}
	}

	function guzzle_FC($uri, $params = false)
	{
		$postData['userkeys'] = $this->apiHrisKey;
		if (!empty($this->logPrs)) $postData['prs'] = $this->logPrs;
		if ($params) $postData += $params;
		try {
			$response = $this->client->request('POST', $this->apiFoodCoupon . $uri, [
				'form_params' => $postData,
				'cookies' => $this->cookieJar
			]);
			return $response->getBody()->getContents();
		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'Unable to connect to the server'
			]);
		}
	}

	function guzzle_mail($uri, $method, $params = false)
	{
		try {
			if ($params) {
				$response = $this->client->request($method, $this->apiMail . $uri, [
					'form_params' => $params,
					'cookies' => $this->cookieJar
				]);
			} else {
				$response = $this->client->request($method, $this->apiMail . $uri);
			}
			return $response->getBody()->getContents();
		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'Unable to connect to the server'
			]);
		}
	}

	function guzzle_mail_json($uri, $method, $params = false)
	{
		try {
			$response = $this->client->request($method, $this->apiMail . $uri, [
				'json' => $params
			]);
			return $response->getBody()->getContents();
		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'Unable to connect to the server'
			]);
		}
	}
}
