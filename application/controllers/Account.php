<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("content-type: application/json");


class Account extends MY_Controller {
	 public function __construct() {
        parent::__construct(true);
        
    }

    public function index() {
        echo 'Unauthorized Link !!';
    }


    public function registration(){
        $json           = file_get_contents('php://input');
        $data           = json_decode($json,1);
        $user_mobile    = isset($data['user_mobile']) ? trim($data['user_mobile']) : '';
        $user_type    = isset($data['user_type']) ? trim($data['user_type']) : '';
        $resData = array();




        if(!empty($user_mobile) && !empty($user_type) ) {

	        		$userId='';
	            	$insData = array(
				                        'mobile'            =>      $user_mobile,
				                        'user_type'         =>      $user_type,
                                    );

            		$checkExistUser = $this->Common_Model->get_data('_gta_users_gta_',array('mobile'=>$user_mobile, 'user_type'=>$user_type));
                    if(!empty($checkExistUser))
                    {
                    	$updated =$this->Common_Model->update_data('_gta_users_gta_',$insData, array('mobile'=>$user_mobile,'user_type'=>$user_type,'status'=>'1'));
                    	if ($updated) {
                    			$userId=$checkExistUser[0]['user_id'];
                    		}	
                    }
                    else
                    $userId = $this->Common_Model->set_data('_gta_users_gta_',$insData);



                    if($userId)
                    {

	                        $otp_code = sendsms($userId,$user_mobile);
	                        if($otp_code != '0'){   //otp sent success

	               				$result = $this->Common_Model->get_data('_gta_users_gta_',array('user_id' => $userId, 'status'=>'1'));

                                
	                            $resData = array(
	                                    'user_id'=> $userId,
                                        'user_type'=> $user_type,
	                                    'is_new_user'=> $result[0]['is_new_user'],
                                        'otp_code'=>$otp_code,
                                        'otp_status' => 'OTP sent Successfully',
                                        

	                            				);
	                            $response = array(
	                                    'status'    =>  true,
	                                    'message'      =>  "success",
	                                    'data'      =>  $resData
	                            				);
	                            http_response_code(200);
	                            exit(json_encode($response));
	                        }
	                        else{
	                            $response = array(
	                                'status'    =>  false,
	                                'message'   =>  'Error in sending OTP',
	                                
	                            
	                            				);
	                           http_response_code(200);
	                           exit(json_encode($response));
	                        }

			                    	
			                        
                    }
                    else{
                        $response = array(
                        'status'    =>  false,
                        'message'   =>  'Error',
                        
                        
                        );
                        http_response_code(200);
                        exit(json_encode($response));
                    }
			                
            
        }//first if end
        else{
            $response = array(
                'status'    => false,
                'message'   => "Missing Parameter !!",
                
            );
            http_response_code(200);
            exit(json_encode($response));
        }
    }//eof registration




    public function verifyOtp(){
        $json           = file_get_contents('php://input');
        $data           = json_decode($json,1);
        $user_uid       = isset($data['user_id']) ? trim($data['user_id']) : '';
        $user_type       = isset($data['user_type']) ? trim($data['user_type']) : '';
        $otp            = isset($data['otp']) ? trim($data['otp']) : '';
        // $jwtToken            = isset($data['jwtToken']) ? trim($data['jwtToken']) : '';
        // $jwtData = $this->objOfJwt->DecodeToken($jwtToken);


        if(!empty($user_uid) && !empty($user_type) && !empty($otp)) {
            $otpData = $this->Common_Model->get_row_count('_gta_otp_verification_gta_',array('user_id' => $user_uid,'otp_code' => $otp,'status' => '1'));

            if(!empty($otpData)){
                $this->Common_Model->update_data('_gta_users_gta_',array('is_mobile_verified' => 1),array('user_id' => $user_uid, 'status' => '1'));

                
                $issuedAt = time();
                // jwt valid for 60 days (60 seconds * 60 minutes * 24 hours * 60 days)
                $expirationTime = $issuedAt + 60*60*24;
                $payload = array(
                  'user_id' => $user_uid,
                  'user_type' => $user_type,
                  'iat' => $issuedAt,
                  'exp' => $expirationTime,
                );
                // $key = "xxxx";
                // $alg = 'xxxxx';
                // $tokens = JWT::encode($payload, $key, $alg);
                

                try
                {
                $jwtToken = $this->objOfJwt->GenerateToken($payload);
                }
                catch (Exception $e)
                {
                http_response_code('401');
                echo json_encode(array( "status" => false, "message" => $e->getMessage()));exit;
                }

                $response = array(
                        'status'    =>  true,
                        'message'   =>  'Mobile Number Verified',
                        'jwtToken'  =>  $jwtToken
                    );
                http_response_code(200);
                exit(json_encode($response));
            }
            else{
                $response = array(
                        'status'    =>  false,
                        'message'   =>  'OTP is Incorrect'
                    
                    );
                http_response_code(200);
                exit(json_encode($response));
            }

        }   
        else{
            $response = array(
                'status'    => false,
                'message'   => "Missing Parameter !!",
            );
            http_response_code(200);
            exit(json_encode($response));
        }
    }// eof verify otp




}//eof controller
