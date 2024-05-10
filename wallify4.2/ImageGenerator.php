<?php  
    class ImageGenerator{
        public $error;
        public $prompt;
        public $headers;
        public $data;

        public function errors(){
            return $this->error;
        }

        public function setApiHeader(){
            $this->headers = [
                'Authorization: Bearer ' .API_TOKEN,
                'Content-Type: application/json'
            ];
        }

        public function setApiData(){
            $this->data = [
                'prompt' => $this->prompt
            ];
        }

        public function generate(){
            $apiUrl= "https://api.openai.com/v1/images/generations";
            $this->setApiHeader();
            $this->setApiData();

            $ch = curl_init($apiUrl);

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            // var_dump($response);
            curl_close($ch);

            if($response){
                $responseData = json_decode($response, true);
                $file = $this->saveImage($responseData['data'][0]['url']);
                return $file;
            }else{
                $this->error = "API Request Failed";
                return false;
            }

        }

        public function saveImage($response){
            $imageUrl = $response;
            $uploadDir = 'frontend/uploads/images/';
            $filename = $uploadDir.md5(time()).'_.png';
            file_put_contents($filename, file_get_contents($imageUrl));
            return $filename;
        }
    }