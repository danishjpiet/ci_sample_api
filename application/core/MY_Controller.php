<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/ImplementJwt.php';

class MY_Controller extends CI_Controller {

	
	public function __construct($skip_jwt=false) {

        parent::__construct();
        $this->objOfJwt = new ImplementJwt();
        $this->load->model('Common_Model');
        $headers = (object) array();
        foreach (getallheaders() as $name => $value) {
             $headers->$name = $value;

        }

        if(!empty($headers) && !empty($headers->accesskey) ){
            if($headers->accesskey != 'G3448R10at9mD3209etRA20d8iNgla3p'){
            							
                $response = array(
                    'status'    => true,
                    'message'   => "Invalid Access !!",
                    
                );
                http_response_code(200);
                header('Content-type: application/json');
                echo json_encode($response);
                exit();
            }
            if (!$skip_jwt) {
            	
            $this->jwtVerify($headers->jwt_token);	

            }



            
        }
        else{
            $response = array(
                'status'    => false,
                'message'   => "Invalid Request !!"
            );
            http_response_code(200);
            header('Content-type: application/json');
            echo json_encode($response);
            exit();

        }

        
    }



	public function index()
	{
		
	}


	public function jwtVerify($jwtToken) {

		$json           = file_get_contents('php://input');

        $data           = json_decode($json,1);

        $user_id       = isset($data['user_id']) ? trim($data['user_id']) : '';

        $user_type       = isset($data['user_type']) ? trim($data['user_type']) : '';



        if(isset($jwtToken) && !empty($jwtToken)) {

                    try

                    {

                    $jwtData = $this->objOfJwt->DecodeToken($jwtToken);

                    }

                    catch (Exception $e)

                    {

                    $response=array( "status" => false,  "message" => $e->getMessage());



                    http_response_code(401);
                    exit(json_encode($response));

                    }



                	if(empty($user_id) || empty($user_type))
                	{

				        $response = array(

				            'status'    => false,

				            'message'   => "Missing Parameter !!",


				        );

				        http_response_code(200);
				        exit(json_encode($response));

				    }

					if ($jwtData['user_id']===$user_id && $jwtData['user_type']===$user_type) {
						    	
						    	return $jwtData;
					}
					else
					{
						    $response = array(

					            'status'    => false,

					            'message'   => "Unauthorized Access!!",


					        );

					        http_response_code(200);
					        exit(json_encode($response));

					    
					}	    

       
    }
    else{

        $response = array(

            'status'    => false,

            'message'   => "Missing Token !!",


        );

        http_response_code(200);
        exit(json_encode($response));

    }
         

}//eof jwtVerify



	    

}
