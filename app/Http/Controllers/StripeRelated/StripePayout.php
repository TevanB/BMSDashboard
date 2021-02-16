<?php
// This is your real test secret API key.
namespace App\Http\Controllers\StripeRelated;
//require __DIR__ . '/vendor/autoload.php';
require_once('stripe-php/init.php');

class StripePayout
{


    public function payoutUser($debug=false){
        \Stripe\Stripe::setApiKey('sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963');
        try{
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);
            $user_email = $json_obj->email;
            $amount = $json_obj->amount;
            $stripe = new \Stripe\StripeClient(
                'sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963'
              );
            $accList = $stripe->accounts->all();
            $accId = "";
            for ($x = 0; $x < count($accList->data); $x++) {
                if($user_email == $accList->data[$x]->email){
                    $accId = $accList->data[$x]->id;
                }
            }
            //echo($accId);
            if($accId != ""){
                //user payout obj exists
                $curAcc = $stripe->accounts->retrieve(
                    $accId,
                    []
                );
                $bank_acc_id = "";
                for ($x = 0; $x < count($curAcc->external_accounts->data); $x++) {
                    if("bank_account" == $curAcc->external_accounts->data[$x]->object){
                        $bank_acc_id = $curAcc->external_accounts->data[$x]->id;
                        break;
                    }
                }
                $stripe->payouts->create([
                    'amount' => $amount,
                    'currency' => 'usd',
                    'destination' => $bank_acc_id,
                    'source_type' => 'bank_account',
                    'stripe_account' => $accId
                ]);
            }else{
                //user payout obj doesn't exist
                echo("false");
            }
        }catch(Error $e){
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function visitPayoutDash($debug=false){
        \Stripe\Stripe::setApiKey('sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963');
        try{
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);
            $stripe = new \Stripe\StripeClient(
                'sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963'
              );
            $accList = $stripe->accounts->all();
            $accId = "";
            for ($x = 0; $x < count($accList->data); $x++) {
                if($json_obj->email == $accList->data[$x]->email){
                    $accId = $accList->data[$x]->id;
                }
            }
            //echo($accId);
            if($accId != ""){
                echo(self::createAccLink($accId));
            }else{
                echo(self::createAcc());
            }
        }catch(Error $e){
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function createAcc($debug=false){
        \Stripe\Stripe::setApiKey('sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963');
        try{
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);


            $stripe = new \Stripe\StripeClient(
                'sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963'
              );
            $newAcc = $stripe->accounts->create([
            'type' => 'express',
            'country' => 'US',
            'email' => $json_obj->email,
            ]);

            echo(self::createAccLink($newAcc->id));

            //echo($account);               //Call createAccLink


        }catch(Error $e){
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function createAccLink($id){
        \Stripe\Stripe::setApiKey('sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963');
        try{
            //$json_str = file_get_contents('php://input');
            //$json_obj = json_decode($json_str);
            $stripe = new \Stripe\StripeClient(
                'sk_test_51I4xTLCBjNIgSDtBbDv1cPl9TO0vag9FwJp5GQ0I1pFlo8n7a16uuYVmN6RUfDBvu6jRwrHcNFZ8qAdQZ4blh4HR000HgbL963'
              );
            $curAcc = $stripe->accounts->retrieve(
                $id,
                []
            );
            //echo(json_encode($curAcc->id));
            if($curAcc->payouts_enabled == false){
                $account_links = \Stripe\AccountLink::create([
                    'account' => $id,
                    'refresh_url' => 'https://bms-backend-setup-payou-rs8qky.herokuapp.com/profile',
                    'return_url' => 'https://bms-backend-setup-payou-rs8qky.herokuapp.com/profile',
                    'type' => 'account_onboarding',
                    'collect' => 'eventually_due'
                ]);
                echo($account_links->url);
            }else{
                $login = $stripe->accounts->createLoginLink(
                    $id,
                    []
                  );
                echo($login->url);
            }

        }catch(Error $e){
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

?> 
