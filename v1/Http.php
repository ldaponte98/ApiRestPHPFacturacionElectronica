<?php 
	
	class Http
	{
		public $authorization = "";
		public $content_type = "application/json";
		public $accept = "application/json";
		
		public function get($url)
		{
            $context = stream_context_create([
                "ssl"=>[

                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ],
                "http" => [
                    "method" => "GET",
                    "header" => "Authorization: ".$this->authorization."\r\n"."Content-type: ".$this->content_type."\r\n"."Accept: ".$this->accept."\r\n",
                ]
            ]);

            $response = file_get_contents($url, false, $context);
            $response = json_decode($response); 
            return $response;
		}

		public function post($url, $data = null)
		{
			$context = stream_context_create([
                "ssl"=>[

                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ],
                "http" => [
                    "method" => "POST",
                    "header" => "Authorization: ".$this->authorization."\r\n"."Content-type: ".$this->content_type."\r\n"."Accept: ".$this->accept."\r\n",
                    "content" => $data
                ]
            ]);

            $response = file_get_contents($url, false, $context);
            $response = json_decode($response);
            return $response;
		}
	
	}
 ?>