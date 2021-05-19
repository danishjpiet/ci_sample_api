<?php

defined('BASEPATH') OR exit('No direct script access allowed');

header("content-type: application/json");

class Users extends MY_Controller {

	 public function __construct() {

        parent::__construct();

        
    }



    public function index() {

        echo 'Unauthorized Link !!';

    }


        public function updateProfilePic(){

        $user_id=$this->input->post('user_id');
        $user_type=$this->input->post('user_type');
        
        $user_id=isset($user_id) ? $this->security->xss_clean(trim($user_id) )  : '';
        $user_type=isset($user_type) ? $this->security->xss_clean(trim($user_type) )  : '';           

        if(isset($_FILES['profilePic']['name']) && !empty($_FILES['profilePic']['name']) && !empty($user_id) && !empty($user_type) ){

                    $oldPic='';

                    $img_url='';

                    $whereArr['user_id']=$user_id;
                    $whereArr['user_type']=$user_type;



                    if (isset($_FILES['profilePic']['name']) && !empty($_FILES['profilePic']['name'])) {



                        $existPic= $this->Common_Model->get_data('_gta_users_gta_', $whereArr, null, array('profile_pic'));

                        if (!empty($existPic)) {

                            

                            $oldPic=$existPic[0]['profile_pic'];

                        }

                        $path = 'assets/images';

                            if (!file_exists($path)) {
                                mkdir("assets/images" , 0777);  
                            } 

                        

                        $allowedType = 'png|jpeg|JPEG|jpg|JPG|PNG';

                        $profilePic = $this->input->post('profilePic');



                        

                        $uploadProfilePic = uploadFunc($path, $allowedType, $profilePic, 'profilePic', 50000000, 5000000, 500000);

                        

                        if (isset($uploadProfilePic['error'])) {

                            $error = array('error' => $uploadProfilePic['error']);

                            $response = array(

                                'status'    => false,

                                'message'   => $error,

                            );

                            http_response_code(200);
                            exit(json_encode($response));

                        }

                        else{

                            $img_url = 'assets/images/profile_pics/'.$uploadProfilePic['success']['file_name'];



                        }



                    }

                        

                    if (!empty($img_url)) {

                        

                        $dataArr['profile_pic']=$img_url;



                             if (file_exists($oldPic)) 

                            {

                                 unlink($oldPic);

                                 

                            }

                    }



                            $updateRes= $this->Common_Model->update_data('_gta_users_gta_', $dataArr, $whereArr);


                                if (!empty($updateRes)) {

                                
                                        $response = array(

                                            'status'    =>  ture,
                                            'message'   => 'Updated Successfully' ,

                                        );

                                    http_response_code(200);
                                    exit(json_encode($response));




                                }

                                else

                                {



                                    $response = array(

                                            'status'    =>  false,
                                            'message'   =>  'Data Already Exist'

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

        

    }// eof sellerUpdateProfilePic









    public function updateProfile(){

    	$json           = file_get_contents('php://input');

        $data           = json_decode($json,1);

        $user_id       = isset($data['user_id']) ? trim($data['user_id']) : '';

        $user_type       = isset($data['user_type']) ? trim($data['user_type']) : '';

        $about       = isset($data['about']) ? trim($data['about']) : '';

        $name       = isset($data['name']) ? trim($data['name']) : '';

        $email       = isset($data['email']) ? trim($data['email']) : '';

        $location       = isset($data['location']) ? trim($data['location']) : '';

        $age       = isset($data['age']) ? trim($data['age']) : '';

        $gender       = isset($data['gender']) ? trim($data['gender']) : '';

        $bank       = isset($data['bank']) ? trim($data['bank']) : '';


        $distanceCovered       = isset($data['distanceCovered']) ? trim($data['distanceCovered']) : '';


        if( !empty($user_id) && !empty($user_type) && (!empty($about) || !empty($name) || !empty($email) || !empty($location) || !empty($age) || !empty($gender) || !empty($bank) || !empty($distanceCovered) )   ) {

            

            
                    $whereArr['user_id']=$user_id;

                    $whereArr['user_type']=$user_type;

                    $whereArr['status']='1';

             
                    if (isset($about) && !empty($about)) {

                        

                        $dataArr['about']=$about;

                    }

                    if (isset($name) && !empty($name)) {

                        

                        $dataArr['name']=$name;

                    }

                    if (isset($email) && !empty($email)) {

                        

                        $dataArr['email']=$email;

                    }

                    if (isset($location) && !empty($location)) {

                        

                        $dataArr['address']=$location;

                    }

                    if (isset($age) && !empty($age)) {

                        

                        $dataArr['age']=$age;

                    }

                    if (isset($gender) && !empty($gender)) {

                        

                        $dataArr['gender']=$gender;

                    }

                    if (isset($bank) && !empty($bank)) {

                        

                        $dataArr['bank']=$bank;

                    }


                    if (isset($distanceCovered) && !empty($distanceCovered)) {

                        

                        $dataArr['distanceCovered']=$distanceCovered;

                    }

            
                            $updateRes= $this->Common_Model->update_data('_gta_users_gta_', $dataArr, $whereArr);


                                if (!empty($updateRes)) {

                                

                                        $response = array(

                                            'status'    =>  true,

                                            'message'   => 'Updated Successfully' ,

                                        );

                                    http_response_code(200);
                                    exit(json_encode($response));
                                }
                                else
                                {



                                    $response = array(

                                            'status'    =>  false,
                                            'message'   =>  'Data Already Exist'

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
        

    }// eof sellerUpdateProfile







    public function getProfile(){

        $json           = file_get_contents('php://input');

        $data           = json_decode($json,1);

        $user_id       = isset($data['user_id']) ? trim($data['user_id']) : '';

        $user_type       = isset($data['user_type']) ? trim($data['user_type']) : '';


        if(!empty($user_id) && !empty($user_type) ) {
            

                    $whereArr=[];

                    $whereArr['user_id']=$user_id;

                    $whereArr['user_type']=$user_type;

                    $whereArr['status']=1;



                            $dataArr= $this->Common_Model->get_data('_gta_users_gta_', $whereArr);



                                if (!empty($dataArr)) {

                                	$dataArr=array(
                                					'user_id'=>$dataArr[0]['user_id'],
                                					'user_type'=>$dataArr[0]['user_type'],
                                					'name'=>$dataArr[0]['name'],
                                					'email'=>$dataArr[0]['email'],
                                					'city'=>$dataArr[0]['city'],
                                					'state'=>$dataArr[0]['states'],
                                					'address'=>$dataArr[0]['address'],
                                					'latitude'=>$dataArr[0]['latitude'],
                                					'longitude'=>$dataArr[0]['longitude'],
                                					'distance_covered'=>$dataArr[0]['distance_covered'],
                                					'profile_pic'=>base_url($dataArr[0]['profile_pic']),
                                					'about'=>$dataArr[0]['about'],
                                					'age'=>$dataArr[0]['age'],
                                					'gender'=>$dataArr[0]['gender'],
                                					'total_earning'=>$dataArr[0]['total_earning'],
                                					'total_withdrawal'=>$dataArr[0]['withdrawal'],
                                					'balance_amount'=>$dataArr[0]['balance_amount'],
                                					'is_mobile_verified'=>$dataArr[0]['is_mobile_verified'],
                                					'app_token'=>$dataArr[0]['app_token'],
                                					'credibility_score'=>$dataArr[0]['credibility_score'],
                                					'notification'=>$dataArr[0]['notification'],

                                					);

                                

                                        $response = array(

                                            'status'    =>  true,
                                            'message' => "get profile data Successfully",
                                            'data'   => $dataArr ,

                                        );

                                    http_response_code(200);
                                    exit(json_encode($response));



                                }

                                else

                                {



                                    $response = array(

                                            'status'    =>  false,
                                            'message'   =>  'Data Not Found'

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

        

    }// eof sellerGetProfile











}//eof controller

        