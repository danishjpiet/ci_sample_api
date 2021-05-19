<?php





function sendsms($user_id,$mobile){



		$ci=&get_instance();

        $random = rand(1000,9999);

        $message=urlencode("Your OTP code is ".$random);

        $checkExistVerification = $ci->Common_Model->get_row_count('_gta_otp_verification_gta_',array('user_id' => $user_id,'status' => '1'));

        if(!empty($checkExistVerification)){

            $ci->Common_Model->unset_data('_gta_otp_verification_gta_',array('user_id' => $user_id, 'status'=>'1'));

        }

        

            // $url = "http://anysms.in/api.php?username=".SMS_username."&password=".SMS_password."&sender=".SMS_senderid."&sendto=".$mobile."&message=".$message;

            // $send_sms = file_get_contents($url);

            $insOtpLog = array(

                    'user_id'       =>  $user_id,

                    'otp_code'      =>  $random,

                    //'url_response'  =>  $send_sms,

                        );

            $response=$ci->Common_Model->set_data('_gta_otp_verification_gta_',$insOtpLog);

            if($response){

                return $random;
            }
            else{
                return '0';
            }

        
    }



function uploadFunc($path, $allowedType, $fileName, $name, $size, $width, $height)
    {

        $ci= & get_instance();

        $config['upload_path'] = $path;



        $config['allowed_types'] = $allowedType;



        if ($name=='profilePic')
        $config['file_name'] = rand(1000000000,9999999999)."_gta_profile_pic_gta_".rand(1000000000,9999999999);


        $config['max_size'] = $size;



        $config['max_width'] = $width;



        $config['max_height'] = $height;







        $ci->upload->initialize($config);







        if (!$ci->upload->do_upload($name)) {



            $data = array('error' => $ci->upload->display_errors());



        } else {



            $data = array('success' => $ci->upload->data());



        }



        return $data;



    }






?>





