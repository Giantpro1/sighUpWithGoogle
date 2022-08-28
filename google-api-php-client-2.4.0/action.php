<?php
require 'dbc.php';


require './vendor/autoload.php';

$dbs = new Dbc();
// Creating new google client instance
$client = new Google_Client();

// Enter your Client ID
$client->setClientId('YOUR_Client_Id');
// Enter your Client Secrect
$client->setClientSecret('YOUR_ClientSecret');
// Enter the Redirect URL
$client->setRedirectUri('YOUR_RedirectURl');

// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");


if(isset($_GET['code'])):

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if(!isset($token["error"])){

        $client->setAccessToken($token['access_token']);

        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        // check if user exits 
        $fetchUser = $dbs->fetchUser($google_id);
        if($fetchUser){
            echo "user already exits";
        }else{
            // Storing data into database
            $google_id = $dbs->test_input($_POST[$google_account_info->id]);
            $name = $dbs->test_input($_POST[$google_account_info->name]);
            $email = $dbs->test_input($_POST[$google_account_info->email]);
            $profile_image = $dbs->test_input($_POST[$google_account_info->picture]);
    
                $insert =  $dbs->saveUserFromGoogleInDb($google_id, $name, $email, $profile_image);
    
                if($insert){
                 echo "successful";
                }
                else{
                    echo "Sign up failed!(Something went wrong).";
                }
        }
    }
    else{
       echo "";
    }
    
else: 
    // Google Login Url = $client->createAuthUrl(); 


    

 endif; 