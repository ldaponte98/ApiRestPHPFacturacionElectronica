<?php 
	
	class Http
	{
		public $authorization = "";
		public $content_type = "application/json";
		public $accept = "application/json";
        public $header_extra = "";
        public $error = false;
		
		public function get($url)
		{
            $context = stream_context_create([
                "ssl"=>[

                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ],
                "http" => [
                    "method" => "GET",
                    "ignore_errors" => true,
                    "header" => "Authorization: ".$this->authorization."\r\n"."Content-type: ".$this->content_type."\r\n"."Accept: ".$this->accept."\r\n".$this->header_extra,
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
                    "ignore_errors" => true,
                    "header" => "Content-Type: ".$this->content_type."\r\n".$this->header_extra,
                    "content" => $data
                ]
            ]);

            $response = file_get_contents($url, false, $context);
            $status_line = $http_response_header[0];

            preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);

            $status = $match[1];

            if ($status !== "200") $this->error = true;
                       
            
            //$response = json_decode($response);
            return $response;
		}
	
	}
 ?>