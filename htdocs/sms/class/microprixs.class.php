<?php

Class microprixs {
	public $number = "OALERT";
	public $url;
	public function SmsSenderList()
	{
		$sender = array();
		$sender[0] = (object)array('number' => $this->number);

		return $sender;
	}

	public function httpGet($url)
    {
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $head = curl_exec($ch); 
        curl_close($ch);
        return $head;
    }

	public function SmsSend()
	{
		$output = $this->httpGet($this->url);
		return $output;
	}
}