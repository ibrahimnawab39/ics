<?php

class CallBackController extends ci_controller
{
    
      public function __construct()
    {
        parent::__construct();
        $this->load->model(array('AdminModel', 'AepsModel', 'CommissionSlotModel', 'UserTypeModel', 'AadharPayModel'));
        $this->load->library(array('AEPS','PWAEPS'));
        $this->load->helper('url'); 
        date_default_timezone_set("Asia/Kolkata");
    }


    public function index()
    {
        /** Get callback response and decode the data */
        $data = file_get_contents('php://input');
        
         echo ($data);
        $decode_data = json_decode($data);
        /* if(mail("sachinkumarsingh04@gmail.com","callback Smartbanking",$data)){
          
         }*/
        
        
        
        if ($decode_data->event == 'MERCHANT_ONBOARDING') {
            $arr = [
                "status" => 200,
                "message" => "merchant onboarding success"
            ];

            echo json_encode($arr);
        }
        
        /** *********************************** RECHARGE CALLBACK ******************************* */
         if ($decode_data->event == 'RECHARGE_SUCCESS') {
         $ref_id = $decode_data->param->referenceid;
         $url=base_url()."admin/RechargeController/check_status/". $ref_id ;
       
          echo file_get_contents($url);
     }
     if ($decode_data->event == 'RECHARGE_FAILURE') {
         $ref_id = $decode_data->param->referenceid;
         $url=base_url()."admin/RechargeController/check_status/". $ref_id ;
         echo file_get_contents($url);
     }
     /** *********************************** CMS BALCNE ENQUIRY ******************************* */
        if ($decode_data->event == 'CMS_BALANCE_INQUIRY') {
                
            $ref_id = $decode_data->param->referenceid;
            $amount = $decode_data->param->amount;
            $check_txn = $this->AdminModel->selectAllFromTableOrderBy('cms', 'id', 'desc', ["txn_id" => $ref_id]);
            
            if(empty($check_txn)){
                $arr = [
                    "status" => 400,
                    "message" => "not found"
                ];
                //return false;
                
                echo json_encode($arr);
            }

            $txn_user = $check_txn[0]['user_id'];
             /** If User Balance is lower than the amount, then show the error and block the transaction */
            if (get_balance($txn_user) > ($amount + $this->config->item('min_bal_amount'))) {

                /** debit balance and add to fund list */
                $my_funds = [
                    "channel_id"                =>      $this->config->item('channel_id'),
                    "service_id"                =>      16,
                    "user_id"                   =>      $txn_user,
                    "type"                      =>      'D',
                    "remark"                    =>      "Rs. ". $amount." has been debited from wallet for Airtel CMS Txn: ". $ref_id." ",
                    "amount"                    =>      $amount,
                    "before_bal"                =>      get_balance($txn_user),
                    "updated_bal"               =>      get_balance($txn_user) + $amount,
                    "date"                      =>      date("Y-m-d H:i:s"),
                ];
                $this->AdminModel->insertInto('fund_list', $my_funds);
                
                /** Update balance */
                $update_bal = [
                    "user_balance"  => get_balance($txn_user) - $amount
                ];
                $this->AdminModel->updateWhere("users", $update_bal, array("id" => $txn_user ));

                /** Update response data into db */
                $updateData = [
                    "enquiry_response"  =>      $data,
                    "amount"            =>      $amount,
                    "status"            =>      3,
                    "message"           =>      "Balance Enquiry done. Proceeded to Continue Txn",				
                ];
                $this->AdminModel->updateWhere("cms", $updateData, array("txn_id" => $ref_id));
                $arr = [
                    "status" => 200,
                    "message" => "Txn success"
                ];
                echo json_encode($arr);

            } else if (get_balance($txn_user) < ($amount + $this->config->item('min_bal_amount'))) {
                $updateData = [
                    "enquiry_response"  =>      $data,
                    "amount"            =>      $amount,
                    "status"            =>      0,
                    "message"           =>      "Txn blocked due to insufficien fund in wallet",				
                ];
                $this->AdminModel->updateWhere("cms", $updateData, array("txn_id" => $ref_id));
                $arr = [
                    "status" => 400,
                    "message" => "blocked"
                ];
                echo json_encode($arr);
            }
            
        }
        /** *********************************** END CMS BALCNE ENQUIRY ******************************* */


        /** *********************************** CMS_BALANCE_DEBIT ******************************* */
        if ($decode_data->event == 'CMS_BALANCE_DEBIT') {

            $ref_id = $decode_data->param->referenceid;
            $amount = $decode_data->param->amount;
            $check_txn = $this->AdminModel->selectAllFromTableOrderBy('cms', 'id', 'desc', [ "txn_id" => $ref_id]);
            
            if(empty($check_txn)){
                $arr = [
                    "status" => 400,
                    "message" => "not found"
                ];
                return false;
            }
                /** Update response data into db */
                $updateData = [
                    "debit_response"    =>      $data,			
                ];
                $this->AdminModel->updateWhere("cms", $updateData, array("txn_id" => $ref_id));
                $arr = [
                    "status" => 200,
                    "message" => "continue..."
                ];
                echo json_encode($arr);

        }

        /** *********************************** END CMS_BALANCE_DEBIT ******************************* */



         /** *********************************** CMS_BALANCE_COMMISSON ******************************* */
         if ($decode_data->event == 'CMS_BALANCE_COMMISSON') {

            $ref_id = $decode_data->param->referenceid;
            $biller = $decode_data->param->billerName;
            $ackno = $decode_data->param->ackno;
            $check_txn = $this->AdminModel->selectAllFromTableOrderBy('cms', 'id', 'desc', [ "txn_id" => $ref_id]);
            
            if(empty($check_txn)){
                $arr = [
                    "status" => 400,
                    "message" => "not found"
                ];
                return false;
            } 
            if($biller != '' && $ackno != ''){
                $st =1;
                $msg ="Txn to ".$biller." has been completed successfully";
            } else {
                $st = 2;
                $msg ="Unable to get biller info. please contact admin";
            }
            $updateData = [
                "com_response"      =>      $data,
                "billerName"        =>      $biller,
                "ackno"             =>      $ackno,
                "status"            =>      $st,
                "message"           =>      $msg,				
            ];
            $this->AdminModel->updateWhere("cms", $updateData, array("txn_id" => $ref_id));

        if($biller != '' && $ackno != ''){  
                $txn_user = $check_txn[0]['user_id'];
                //fetch my accunt data
                $my_account = $this->AdminModel->selectAllFromWhere('users', ["id" => $txn_user ]);
                $parent_id = $my_account[0]['parent_id'];
                $user_type = $my_account[0]['user_type'];
                $sender_name = $my_account[0]['name'];

                /** ********************************* SELF & CHAIN COMMISSION **************************** */
                if($biller != '' && $biller != '' ){
        
                        $user_plan_id = $my_account[0]['plan_id'];
                        $txn_amount = $check_txn[0]['amount'];
                        $service_id = 16;
                        $service_name = "Airtel CMS";
                        
                    
                    if (!empty($user_plan_id) && !empty($user_type) || $user_type == 0) {
                        /**
                         * Generate Current User Commission
                         */
                        /** 
                         * check slot for individual user
                         * @param serviceType,user_type,email,amount,plan_id
                         */
       
                        $specific_user_slot_self = $this->CommissionSlotModel->check_specific_user_slot($service_id, $user_type, $my_account[0]['email'], $txn_amount , $user_plan_id,'C');
       
                        if (!empty($specific_user_slot_self)) {
                            $commission_type = $specific_user_slot_self[0]['commission_type'];
                            $chain_type = $specific_user_slot_self[0]['chain_type'];
                            $charges = json_decode($specific_user_slot_self[0]['charges']);
                            $ctype = $specific_user_slot_self[0]['type'];
       
       
                            if ($commission_type == 1) {
                                $commission_amt_with_tds = $specific_user_slot_self[0]['commission_amt'];
                                $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
                                $commission_amt = $specific_user_slot_self[0]['commission_amt'] - $tds;
                                $commission_type_value = $specific_user_slot_self[0]['commission_amt'];
                            } else if ($commission_type == 2) {
       
                                $commission_amt_with_tds = ($txn_amount * $specific_user_slot_self[0]['percentage']) / 100;
                                $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
       
                                $commission_amt = ($txn_amount * $specific_user_slot_self[0]['percentage']) / 100 - -$tds;
                                $commission_type_value = $specific_user_slot_self[0]['percentage'];
                            }
                        } else {
       
                            /**
                             * General Slot
                             * @param serviceType,user_type,amount,plan_id
                             */
                            $general_slot_self = $this->CommissionSlotModel->check_general_slot($service_id, $user_type, $txn_amount , $user_plan_id ,'C');
       
                            // print_r($general_slot_self);
       
                            if (!empty($general_slot_self)) {
       
                                $commission_type = $general_slot_self[0]['commission_type'];
                                $chain_type = $general_slot_self[0]['chain_type'];
                                $charges = json_decode($general_slot_self[0]['charges']);
                                $ctype = $general_slot_self[0]['type'];
       
                                if ($commission_type == 1) {
                                    $commission_amt_with_tds = $general_slot_self[0]['commission_amt'];
                                    $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
       
                                    $commission_amt = $general_slot_self[0]['commission_amt'] - $tds;
                                    $commission_type_value = $general_slot_self[0]['commission_amt'];
                                } else if ($commission_type == 2) {
       
                                    $commission_amt_with_tds = ($txn_amount * $general_slot_self[0]['percentage']) / 100;
                                    $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
       
                                    $commission_amt = ($txn_amount * $general_slot_self[0]['percentage']) / 100 - $tds;
                                    $commission_type_value = $general_slot_self[0]['percentage'];
                                }
                            }
                        }
       
                        // if (!empty($commission_amt) && !empty($commission_type) && !empty($commission_type_value)) {
       
                        if (isset($specific_user_slot_self) || isset($general_slot_self)) {
       
                            $before_balance = get_balance($txn_user);
       
                            if ($ctype == 'C') {
                                
                               $cmsg = "Commission Generated for Airtel CMS Txn For Amount: ".$txn_amount.", Ref Id" . $ref_id . " ,  Biller Name" . $biller . " , Commission Charge ". number_format($commission_amt_with_tds,2). " , TDS ". number_format($tds,2)."  , Total Commission ".number_format($commission_amt,2)."  by SELF ";
                               
                                $updated_balance = $before_balance + $commission_amt;
                            } 
       
       
                            $self_commission = [
                                "channel_id"                =>      $this->config->item('channel_id'),
                                "service_type"              =>      $service_id,
                                "tid"                       =>      $check_txn[0]['id'],
                                "user_id"                   =>      $txn_user,
                                "transaction_value"         =>      $txn_amount,
                                "transaction_type"          =>      1,
                                "earned_amount"             =>      $commission_amt,
                                "tds"                       =>      $tds,
                                "commission_type"           =>      $commission_type,
                                "commission_type_value"     =>      $commission_type_value,
                                "charges"                   =>      $charges->tds_charge,
                                "status"                    =>      1,
                                "type"                      =>      $ctype,
                                "msg"                       =>      $cmsg,
                                "created_by"                =>      $txn_user,
                                "created_at"                =>      date("Y-m-d H:i:s"),
                            ];
       
                            $this->AdminModel->insertInto('commission_log', $self_commission);
       
                            $mfArr = [
                                "channel_id"                =>      $this->config->item('channel_id'),
                                "service_id"                =>      $service_id,
                                "user_id"                   =>      $txn_user,
                                "amount"                    =>      $commission_amt,
                                "type"                      =>      $ctype,
                                "remark"                    =>      $cmsg,
                                "before_bal"                =>      $before_balance,
                                "updated_bal"               =>      $updated_balance,
                                "date"                      =>      date("Y-m-d H:i:s"),
                            ];
       
                            $this->AdminModel->insertInto('fund_list', $mfArr);
       
                            /**
                             * Update balance
                             */
       
                            $dt = [
                                "user_balance"  => $updated_balance
                            ];
       
                            $this->AdminModel->updateWhere("users", $dt, array("id" => $txn_user ));
                        }
                    }
       
                    if (!empty($chain_type)) //if chain type variable exits
                        if (!empty($parent_id) && $chain_type == 'Chain' && $ctype == 'C') {
       
                            if ($user_type > 0) {
                                $loop = $user_type;
                            }
       
       
                            if ($loop >= 1) {
       
                                for ($i = 1; $i <= $loop; $i++) {
                                    $parent_id = $parent_id;
                                    $user = $this->AdminModel->selectAllFromWhere('users', ["id" => $parent_id, "status" => 1]);
                                    $utype = $user[0]['user_type'];
                                    $level_plan_id = $user[0]['plan_id'];
       
                                    /** 
                                     * check slot for individual user
                                     * @param serviceType,user_type,email,amount,plan_id
                                     */
                                    $specific_user_slot = $this->CommissionSlotModel->check_specific_user_slot($service_id, $utype, $user[0]['email'], $txn_amount , $level_plan_id ,'C');
       
                                    /**
                                     * General Slot
                                     * @param serviceType,user_type,amount,plan_id
                                     */
                                    $general_slot = $this->CommissionSlotModel->check_general_slot($service_id, $utype, $txn_amount , $level_plan_id,'C');
       
                                    if (!empty($specific_user_slot)) {
                                        $commission_type_parent = $specific_user_slot[0]['commission_type'];
                                        $ref_chain_type = $specific_user_slot[0]['chain_type'];
                                        $charges = json_decode($specific_user_slot[0]['charges']);
       
       
                                        if ($commission_type_parent == 1) {
       
                                            $commission_amt_with_tds = $specific_user_slot[0]['commission_amt'];
                                            $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
       
                                            $commission_amt_parent = $specific_user_slot[0]['commission_amt'] - $tds;
                                            $commission_type_parent_value = $specific_user_slot[0]['commission_amt'];
                                        } else if ($commission_type_parent == 2) {
       
                                            $commission_amt_with_tds = ($txn_amount * $specific_user_slot[0]['percentage']) / 100;
                                            $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
       
                                            $commission_amt_parent = ($txn_amount * $specific_user_slot[0]['percentage']) / 100  - $tds;
                                            $commission_type_parent_value = $specific_user_slot[0]['percentage'];
                                        }
                                    } else {
       
                                        if (!empty($general_slot)) {
       
                                            $commission_type_parent = $general_slot[0]['commission_type'];
                                            $ref_chain_type = $general_slot[0]['chain_type'];
                                            $charges = json_decode($general_slot_self[0]['charges']);
       
                                            if ($commission_type_parent == 1) {
                                                $commission_amt_with_tds = $general_slot[0]['commission_amt'];
                                                $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
       
                                                $commission_amt_parent = $general_slot[0]['commission_amt'] - $tds;
                                                $commission_type_parent_value = $general_slot[0]['commission_amt'];
                                            } else if ($commission_type_parent == 2) {
       
                                                $commission_amt_with_tds = ($txn_amount * $general_slot[0]['percentage']) / 100;
                                                $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
       
                                                $commission_amt_parent = ($txn_amount * $general_slot[0]['percentage']) / 100 - $tds;
                                                $commission_type_parent_value = $general_slot[0]['percentage'];
                                            }
                                        }
                                    }
       
                                    if (isset($general_slot) || isset($specific_user_slot) && !empty($ref_chain_type)) {
                                        
                                        $chain_msg = "Commission Generated for Airtel CMS Txn Amount" . $txn_amount . " , Biller name: ".$biller.",Ref id: ".$ref.", Commission Charge ". number_format($commission_amt_with_tds,2). " , TDS ". number_format($tds,2)."  , Total Commission ".number_format($commission_amt_parent,2)."  by " . $sender_name. " ";
                                       
                                        $params['service_type'] = $service_id;
                                        $params['user_id'] = $user[0]['id'];
                                        $params['tid'] = $check_txn[0]['id'];
                                        $params['transaction_value'] = $txn_amount;
                                        $params['channel_id'] = $this->config->item('channel_id');
                                        $params['transaction_type'] = 1;
                                        $params['earned_amount'] = $commission_amt_parent;
                                        $params['tds'] = $tds;
                                        $params['commission_type'] = $commission_type_parent;
                                        $params['commission_type_value'] = $commission_type_parent_value;
                                        $params['charges'] = $charges->tds_charge;
                                        $params['status'] = 1;
                                        $params['type'] = 'C';
                                        $params['msg'] = $chain_msg;
                                        $params['created_by'] = $txn_user;
                                        $params['created_at'] = date("Y-m-d H:i:s");
                                        $commission_array[] = $params;
       
                                        /**
                                         * Update balance
                                         */
                                        $dt = [
                                            "user_balance"  => $user[0]['user_balance'] + $commission_amt_parent
                                        ];
       
                                        $this->AdminModel->updateWhere("users", $dt, array("id" => $user[0]['id']));
       
       
                                        $flistArr = [
                                            "channel_id"                =>      $this->config->item('channel_id'),
                                            "service_id"                =>      $service_id,
                                            "user_id"                   =>      $user[0]['id'],
                                            "type"                      =>      'C',
                                            "remark"                    =>      $chain_msg,
                                            "amount"                    =>      $commission_amt_parent,
                                            "before_bal"                =>      $user[0]['user_balance'],
                                            "updated_bal"               =>      $user[0]['user_balance'] + $commission_amt_parent,
                                            "date"                      =>      date("Y-m-d H:i:s"),
                                        ];
       
                                        $this->AdminModel->insertInto('fund_list', $flistArr);
                                    }
       
                                    $parent_id = $user[0]['parent_id'];
       
                                    /** If Parent ID does not exits then break the loop */
                                    if (empty($parent_id) || $ref_chain_type == 'Self') {
                                        break;
                                    }
                                }
       
                                if (isset($commission_array)) {
                                    $this->db->insert_batch('commission_log', $commission_array);
                                }
                            }
                        }
                } // if response code == 1 END


                
                $arr = [
                    "status" => 200,
                    "message" => "success"
                ];
                echo json_encode($arr);

            }
        }

        /** *********************************** END CMS_BALANCE_COMMISSON ******************************* */

        /*** Merchant Onboard Status */
        if ($decode_data->event == 'MERCHANT_STATUS_ONBOARD') {
            
            if ($decode_data->param->merchantcode != '' ) {

                /** Update onboarding status and save the response in log */
                $arr = ["onboarding_status"  => $decode_data->param->status ];
                $this->AdminModel->updateWhere("users", $arr, array("submerchantid" => $decode_data->param->merchantcode));

                $callback = ["callback_response" => $data];
                
                $this->AdminModel->updateWhere("onboarding_log", $callback, array("merchant_id" => $decode_data->param->merchantcode));
               
                    $url = 'admin/OnboardController/start_onboarding';
                    echo'
                    <script>
                    window.location.href = "'.base_url().$url.'";
                    </script>
                    ';
            }
        }
        
        
        /************* MATM CW *********************************/
         /************* MATM CW *********************************/
        
          if ($decode_data->event == 'MATM') {
            
            if ($decode_data->param->status != '' ) {

                /** Update onboarding status and save the response in log */
                
                $data = [
                        "status"            => $decode_data->param->txnstatus,
                        "response_message"  => $decode_data->param->message,
                        "ackno"            => $decode_data->param->ackno,
                        "bankrrn"          => $decode_data->param->bankrrn,
                        "cardnumber"       => $decode_data->param->cardnumber,
                        "bankName"         => $decode_data->param->bankName,
                        "updated_bal"      => $decode_data->param->balance,
                        "json_response"    =>  $data,
                        "updated_at"       => date("Y-m-d H:i:s")
                    ];
                
                $this->AdminModel->updateWhere("microatm", $data, array("referenceno" => $decode_data->param->txnrefrenceNo));

                echo "Data logged";
                
                
             $token = $this->api->create_jwt_token();
             $this->load->library(array('AEPS','MicroAtm'));
                
                  if($decode_data->param->txnstatus == 1 && $decode_data->param->status == true) {
                        $body2 = [
                            "reference" => $decode_data->param->txnrefrenceNo,
                            "status"    => 'success'
                        ];
                        $encrypt_bpdy2 = $this->aeps->encrypt($body2);

                        $cross_verify = $this->microatm->three_way_check($token, $encrypt_bpdy2);

                        if ($cross_verify) {
                            $ap_res = json_decode($cross_verify);

                                $updData = [
                                    "threeway_res" =>      $cross_verify,
                                ];

                            $this->AdminModel->updateWhere("microatm", $updData, array("referenceno" => $decode_data->param->txnrefrenceNo));
                        }
                    } else if($decode_data->param->txnstatus == 3 && $decode_data->param->status == true) {

                        $body2 = [
                            "reference" => $decode_data->param->txnrefrenceNo,
                            "status"    => 'failed'
                        ];
                        $encrypt_bpdy2 = $this->aeps->encrypt($body2);

                        $cross_verify = $this->microatm->three_way_check($token, $encrypt_bpdy2);

                        if ($cross_verify) {
                            $ap_res = json_decode($cross_verify);
                            $updData = [
                                    "threeway_res" =>      $cross_verify,
                                ];

                            $this->AdminModel->updateWhere("microatm", $updData, array("referenceno" => $decode_data->param->txnrefrenceNo));
                        }
                    }
                    
                
                
                
                //commission
                $refno = $decode_data->param->txnrefrenceNo;
                //here transactionId is user id   
                $txn_details = $this->AdminModel->selectAllFromWhere('microatm', ["referenceno" => $refno ]);
                $txn_user = $txn_details[0]['user_id'];
                
                 //fetch my accunt data
                 $my_account = $this->AdminModel->selectAllFromWhere('users', ["id" => $txn_user ]);
                 $parent_id = $my_account[0]['parent_id'];
                 $user_type = $my_account[0]['user_type'];
                 $sender_name = $my_account[0]['name'];
        
                    
                /** check data nd log into d **/
                 if($decode_data->param->txnstatus == 1 && $decode_data->param->status == true) {
                     
                    $my_funds = [
                        "channel_id"                =>      $this->config->item('channel_id'),
                        "service_id"                =>      19,
                        "user_id"                   =>      $txn_user,
                        "type"                      =>      'C',
                        "remark"                    =>      "Rs. ". $txn_details[0]['amount']." credited into wallet for MATM Cash Withdrawal from Card No ". $txn_details[0]['cardnumber']." ",
                        "amount"                    =>      $txn_details[0]['amount'],
                        "before_bal"                =>      get_balance($txn_user),
                        "updated_bal"               =>      get_balance($txn_user) + $txn_details[0]['amount'],
                        "date"                      =>      date("Y-m-d H:i:s"),
                    ];
                    $this->AdminModel->insertInto('fund_list', $my_funds);
        
                    $update_bal = [
                        "user_balance"  => get_balance($txn_user) + $txn_details[0]['amount']
                    ];
                    $this->AdminModel->updateWhere("users", $update_bal, array("id" => $txn_user ));
                }
        
        
                 /** =========================================================  Cash Withdrawal && Mini Statement ================================================================ **/
                 
                 if($decode_data->param->txnstatus == 1 && $decode_data->param->status == true){
        
                     $user_plan_id = $my_account[0]['plan_id'];
                     
                         $txn_amount = $txn_details[0]['amount'];
                         $service_id = 19;
                         $service_name = "Micro ATM";
                         
                     
                     if (!empty($user_plan_id) && !empty($user_type) || $user_type == 0) {
                         /**
                          * Generate Current User Commission
                          */
                         /** 
                          * check slot for individual user
                          * @param serviceType,user_type,email,amount,plan_id
                          */
        
                         $specific_user_slot_self = $this->CommissionSlotModel->check_specific_user_slot($service_id, $user_type, $my_account[0]['email'], $txn_amount , $user_plan_id,'C');
        
                         if (!empty($specific_user_slot_self)) {
                             $commission_type = $specific_user_slot_self[0]['commission_type'];
                             $chain_type = $specific_user_slot_self[0]['chain_type'];
                             $charges = json_decode($specific_user_slot_self[0]['charges']);
                             $ctype = $specific_user_slot_self[0]['type'];
        
        
                             if ($commission_type == 1) {
                                 $commission_amt_with_tds = $specific_user_slot_self[0]['commission_amt'];
                                 $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
                                 $commission_amt = $specific_user_slot_self[0]['commission_amt'] - $tds;
                                 $commission_type_value = $specific_user_slot_self[0]['commission_amt'];
                             } else if ($commission_type == 2) {
        
                                 $commission_amt_with_tds = ($txn_amount * $specific_user_slot_self[0]['percentage']) / 100;
                                 $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
        
                                 $commission_amt = ($txn_amount * $specific_user_slot_self[0]['percentage']) / 100 - -$tds;
                                 $commission_type_value = $specific_user_slot_self[0]['percentage'];
                             }
                         } else {
        
                             /**
                              * General Slot
                              * @param serviceType,user_type,amount,plan_id
                              */
                             $general_slot_self = $this->CommissionSlotModel->check_general_slot($service_id, $user_type, $txn_amount , $user_plan_id ,'C');
        
                             // print_r($general_slot_self);
        
                             if (!empty($general_slot_self)) {
        
                                 $commission_type = $general_slot_self[0]['commission_type'];
                                 $chain_type = $general_slot_self[0]['chain_type'];
                                 $charges = json_decode($general_slot_self[0]['charges']);
                                 $ctype = $general_slot_self[0]['type'];
        
                                 if ($commission_type == 1) {
                                     $commission_amt_with_tds = $general_slot_self[0]['commission_amt'];
                                     $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
        
                                     $commission_amt = $general_slot_self[0]['commission_amt'] - $tds;
                                     $commission_type_value = $general_slot_self[0]['commission_amt'];
                                 } else if ($commission_type == 2) {
        
                                     $commission_amt_with_tds = ($txn_amount * $general_slot_self[0]['percentage']) / 100;
                                     $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
        
                                     $commission_amt = ($txn_amount * $general_slot_self[0]['percentage']) / 100 - $tds;
                                     $commission_type_value = $general_slot_self[0]['percentage'];
                                 }
                             }
                         }
        
                         // if (!empty($commission_amt) && !empty($commission_type) && !empty($commission_type_value)) {
        
                         if (isset($specific_user_slot_self) || isset($general_slot_self)) {
        
                             $before_balance = get_balance($txn_user);
        
                             if ($ctype == 'C') {
                                 
                                $cmsg = "Commission Generated for Micro ATM Withrawal For Amount: ".$txn_details[0]['amount'].", Mobile no" . $txn_details[0]['mobile'] . " ,  Card no" . $txn_details[0]['cardnumber'] . " , Commission Charge ". number_format($commission_amt_with_tds,2). " , TDS ". number_format($tds,2)."  , Total Commission ".number_format($commission_amt,2)."  by SELF ";
                                
                                 $updated_balance = $before_balance + $commission_amt;
                             } else if ($ctype == 'D') {
                                 $cmsg = "";
                                 $updated_balance = $before_balance - $commission_amt;
                             }
        
        
                             $self_commission = [
                                 "channel_id"                =>      $this->config->item('channel_id'),
                                 "service_type"              =>      $service_id,
                                 "tid"                       =>      $txn_details[0]['id'],
                                 "user_id"                   =>      $txn_user,
                                 "transaction_value"         =>      $txn_amount,
                                 "transaction_type"          =>      1,
                                 "earned_amount"             =>      $commission_amt,
                                 "tds"                       =>      $tds,
                                 "commission_type"           =>      $commission_type,
                                 "commission_type_value"     =>      $commission_type_value,
                                 "charges"                   =>      $charges->tds_charge,
                                 "status"                    =>      1,
                                 "type"                      =>      $ctype,
                                 "msg"                       =>      $cmsg,
                                 "created_by"                =>      $txn_user,
                                 "created_at"                =>      date("Y-m-d H:i:s"),
                             ];
        
                             $this->AdminModel->insertInto('commission_log', $self_commission);
        
                             $mfArr = [
                                 "channel_id"                =>      $this->config->item('channel_id'),
                                 "service_id"                =>      $service_id,
                                 "user_id"                   =>      $txn_user,
                                 "amount"                    =>      $commission_amt,
                                 "type"                      =>      $ctype,
                                 "remark"                    =>      $cmsg,
                                 "amount"                    =>      $commission_amt,
                                 "before_bal"                =>      $before_balance,
                                 "updated_bal"               =>      $updated_balance,
                                 "date"                      =>      date("Y-m-d H:i:s"),
                             ];
        
                             $this->AdminModel->insertInto('fund_list', $mfArr);
        
                             /**
                              * Update balance
                              */
        
                             $dt = [
                                 "user_balance"  => $updated_balance
                             ];
        
                             $this->AdminModel->updateWhere("users", $dt, array("id" => $txn_user ));
                         }
                     }
        
                     if (!empty($chain_type)) //if chain type variable exits
                         if (!empty($parent_id) && $chain_type == 'Chain' && $ctype == 'C') {
        
                             if ($user_type == 4) {
                                 $loop = 4;
                             } else if ($user_type == 3) {
                                 $loop = 3;
                             } else if ($user_type == 2) {
                                 $loop = 2;
                             } else if ($user_type == 1) {
                                 $loop = 1;
                             }
                            $loop = $user_type;
        
                             if ($loop >= 1) {
        
                                 for ($i = 1; $i <= $loop; $i++) {
                                     $parent_id = $parent_id;
                                     $user = $this->AdminModel->selectAllFromWhere('users', ["id" => $parent_id, "status" => 1]);
                                     $utype = $user[0]['user_type'];
                                     $level_plan_id = $user[0]['plan_id'];
        
                                     /** 
                                      * check slot for individual user
                                      * @param serviceType,user_type,email,amount,plan_id
                                      */
                                     $specific_user_slot = $this->CommissionSlotModel->check_specific_user_slot($service_id, $utype, $user[0]['email'], $txn_amount , $level_plan_id ,'C');
        
                                     /**
                                      * General Slot
                                      * @param serviceType,user_type,amount,plan_id
                                      */
                                     $general_slot = $this->CommissionSlotModel->check_general_slot($service_id, $utype, $txn_amount , $level_plan_id,'C');
        
                                     if (!empty($specific_user_slot)) {
                                         $commission_type_parent = $specific_user_slot[0]['commission_type'];
                                         $ref_chain_type = $specific_user_slot[0]['chain_type'];
                                         $charges = json_decode($specific_user_slot[0]['charges']);
        
        
                                         if ($commission_type_parent == 1) {
        
                                             $commission_amt_with_tds = $specific_user_slot[0]['commission_amt'];
                                             $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
        
                                             $commission_amt_parent = $specific_user_slot[0]['commission_amt'] - $tds;
                                             $commission_type_parent_value = $specific_user_slot[0]['commission_amt'];
                                         } else if ($commission_type_parent == 2) {
        
                                             $commission_amt_with_tds = ($txn_amount * $specific_user_slot[0]['percentage']) / 100;
                                             $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
        
                                             $commission_amt_parent = ($txn_amount * $specific_user_slot[0]['percentage']) / 100  - $tds;
                                             $commission_type_parent_value = $specific_user_slot[0]['percentage'];
                                         }
                                     } else {
        
                                         if (!empty($general_slot)) {
        
                                             $commission_type_parent = $general_slot[0]['commission_type'];
                                             $ref_chain_type = $general_slot[0]['chain_type'];
                                             $charges = json_decode($general_slot_self[0]['charges']);
        
                                             if ($commission_type_parent == 1) {
                                                 $commission_amt_with_tds = $general_slot[0]['commission_amt'];
                                                 $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
        
                                                 $commission_amt_parent = $general_slot[0]['commission_amt'] - $tds;
                                                 $commission_type_parent_value = $general_slot[0]['commission_amt'];
                                             } else if ($commission_type_parent == 2) {
        
                                                 $commission_amt_with_tds = ($txn_amount * $general_slot[0]['percentage']) / 100;
                                                 $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
        
                                                 $commission_amt_parent = ($txn_amount * $general_slot[0]['percentage']) / 100 - $tds;
                                                 $commission_type_parent_value = $general_slot[0]['percentage'];
                                             }
                                         }
                                     }
        
                                     if (isset($general_slot) || isset($specific_user_slot) && !empty($ref_chain_type)) {
                                         
                                         if($obj->aepsmode == 'WITHDRAW'){
                                            $chain_msg = "Commission Generated for MATM Cash Withdrawal For Amount: ".$txn_details[0]['amount'].", Mobile no" . $txn_details[0]['mobile'] . " , Commission Charge ". number_format($commission_amt_with_tds,2). " , TDS ". number_format($tds,2)."  , Total Commission ".number_format($commission_amt_parent,2)."  by " . $sender_name. " ";
                                         } else {
                                            $chain_msg = "Commission Generated for MATM Mini Statement For Amount" . $txn_details[0]['amount'] . " , Commission Charge ". number_format($commission_amt_with_tds,2). " , TDS ". number_format($tds,2)."  , Total Commission ".number_format($commission_amt_parent,2)."  by " . $sender_name. " ";
                                        }
                                 
                                         $params['service_type'] = $service_id;
                                         $params['user_id'] = $user[0]['id'];
                                         $params['tid'] = $txn_details[0]['id'];
                                         $params['transaction_value'] = $txn_amount;
                                         $params['channel_id'] = $this->config->item('channel_id');
                                         $params['transaction_type'] = 1;
                                         $params['earned_amount'] = $commission_amt_parent;
                                         $params['tds'] = $tds;
                                         $params['commission_type'] = $commission_type_parent;
                                         $params['commission_type_value'] = $commission_type_parent_value;
                                         $params['charges'] = $charges->tds_charge;
                                         $params['status'] = 1;
                                         $params['type'] = 'C';
                                         $params['msg'] = $chain_msg;
                                         $params['created_by'] = $txn_user;
                                         $params['created_at'] = date("Y-m-d H:i:s");
                                         $commission_array[] = $params;
        
                                         /**
                                          * Update balance
                                          */
                                         $dt = [
                                             "user_balance"  => $user[0]['user_balance'] + $commission_amt_parent
                                         ];
        
                                         $this->AdminModel->updateWhere("users", $dt, array("id" => $user[0]['id']));
        
        
                                         $flistArr = [
                                             "channel_id"                =>      $this->config->item('channel_id'),
                                             "service_id"                =>      $service_id,
                                             "user_id"                   =>      $user[0]['id'],
                                             "type"                      =>      'C',
                                             "remark"                    =>      $chain_msg,
                                             "amount"                    =>      $commission_amt_parent,
                                             "before_bal"                =>      $user[0]['user_balance'],
                                             "updated_bal"               =>      $user[0]['user_balance'] + $commission_amt_parent,
                                             "date"                      =>      date("Y-m-d H:i:s"),
                                         ];
        
                                         $this->AdminModel->insertInto('fund_list', $flistArr);
                                     }
        
                                     $parent_id = $user[0]['parent_id'];
        
                                     /** If Parent ID does not exits then break the loop */
                                     if (empty($parent_id) || $ref_chain_type == 'Self') {
                                         break;
                                     }
                                 }
        
                                 if (isset($commission_array)) {
                                     $this->db->insert_batch('commission_log', $commission_array);
                                 }
                             }
                         }
                 } // if response code == 1 END
         
         
         
            }
        }
        
        
         /************* MATM BE *********************************/
        
          if ($decode_data->event == 'MATMBE') {
            
            if ($decode_data->param->status != '' ) {

                /** Update onboarding status and save the response in log */
                
                $data = [
                        "status"            => $decode_data->param->txnstatus,
                        "response_message"  => $decode_data->param->message,
                        "ackno"            => $decode_data->param->ackno,
                        "bankrrn"          => $decode_data->param->bankrrn,
                        "cardnumber"       => $decode_data->param->cardnumber,
                        "bankName"         => $decode_data->param->bankName,
                        "updated_bal"      => $decode_data->param->balance,
                        "json_response"    =>  $data,
                        "updated_at"       => date("Y-m-d H:i:s")
                    ];
                
                $this->AdminModel->updateWhere("microatm", $data, array("referenceno" => $decode_data->param->txnrefrenceNo));

                echo "Data logged";
            }
        }
        
        
        
         /** *********************************** CMS FINO BALCNE FINO_CMS_BALANCE_DEBIT ******************************* */
        if ($decode_data->event == 'FINO_CMS_BALANCE_DEBIT') {

            $ref_id = $decode_data->param->referenceid;
            $amount = $decode_data->param->amount;
            $mobile = $decode_data->param->mobile;
            $uniqueid = $decode_data->param->uniqueid;
            $network = $decode_data->param->network;


            $check_txn = $this->AdminModel->selectAllFromTableOrderBy('fino_cms', 'id', 'desc', ["referenceid" => $ref_id]);

            if (empty($check_txn)) {
                $arr = [
                    "status" => 400,
                    "message" => "Transaction failed"
                ];
                echo json_endode($arr);
                return false;
            }

            $txn_user = $check_txn[0]['user_id'];
            /** If User Balance is lower than the amount, then show the error and block the transaction */
            if (get_balance($txn_user) > ($amount + $this->config->item('min_bal_amount'))) {

                 /** Update balance */
                 $update_bal = [
                    "user_balance"  => get_balance($txn_user) - $amount
                ];
                $this->AdminModel->updateWhere("users", $update_bal, array("id" => $txn_user));

                /** debit balance and add to fund list */
                $my_funds = [
                    "channel_id"                =>      $this->config->item('channel_id'),
                    "service_id"                =>      22,
                    "user_id"                   =>      $txn_user,
                    "type"                      =>      'D',
                    "remark"                    =>      "Rs. " . $amount . " has been debited from wallet for Fino CMS Txn: " . $ref_id . ",Mobile: " . $mobile . " ",
                    "amount"                    =>      $amount,
                    "before_bal"                =>      get_balance($txn_user),
                    "updated_bal"               =>      get_balance($txn_user) - $amount,
                    "date"                      =>      date("Y-m-d H:i:s"),
                ];
                $this->AdminModel->insertInto('fund_list', $my_funds);

                /** Update response data into db */
                $updateData = [
                    "bal_debit_callback" =>      $data,
                    "amount"            =>      $amount,
                    "mobile"            =>      $mobile,
                    "network"           =>      $network,
                    "uniqueid"          =>      $uniqueid,
                    "status"            =>      3,
                    "wallet_debited"    =>      1,
                    "remarks"           =>      "Fino Balance Debit done. Proceeded to Continue Txn",
                    "updated_at"        =>      date("Y-m-d H:i:s"),
                ];
                $this->AdminModel->updateWhere("fino_cms", $updateData, array("referenceid" => $ref_id));
                $arr = [
                    "status" => 200,
                    "message" => "Txn success"
                ];
                echo json_encode($arr);
            } else if (get_balance($txn_user) < ($amount + $this->config->item('min_bal_amount'))) {
                $updateData = [
                    "enquiry_response"  =>      $data,
                    "amount"            =>      $amount,
                    "status"            =>      0,
                    "remarks"           =>      "Txn blocked due to insufficient fund in wallet",
                ];
                $this->AdminModel->updateWhere("fino_cms", $updateData, array("referenceid" => $ref_id));
                $arr = [
                    "status" => 400,
                    "message" => "Transaction failed"
                ];
                echo json_encode($arr);
            }
        }
        /** *********************************** END FINO CMS BAL DEBIT  ******************************* */


        /** ***********************************  FINO TXN SUCCESS CALBACK ******************************* */
        if ($decode_data->event == 'FINO_CMS_TRANSACTION_SUCCESS') {

            $ref_id = $decode_data->param->referenceid;
            $FinoTransactionID = $decode_data->param->FinoTransactionID;
            $ackno = $decode_data->param->ackno;
            $mobile = $decode_data->param->mobile;
            $uniqueid = $decode_data->param->uniqueid;
            $network = $decode_data->param->network;
            $status = $decode_data->param->status;
            $remarks = $decode_data->param->remarks;

            
            $check_txn = $this->AdminModel->selectAllFromTableOrderBy('fino_cms', 'id', 'desc', ["referenceid" => $ref_id]);

            if (empty($check_txn)) {
                $arr = [
                    "status" => 400,
                    "message" => "Transaction failed..."
                ];
                echo json_encode($arr);
                return false;
            }
            $updateData = [
                "txn_success_callback"      =>      $data,
                "FinoTransactionID"         =>      $FinoTransactionID,
                "mobile"                    =>      $mobile,
                "uniqueid"                  =>      $uniqueid,
                "network"                   =>      $network,
                "ackno"                     =>      $ackno,
                "status"                    =>      $status,
                "remarks"                   =>      $remarks,
                "updated_at"                =>      date("Y-m-d H:i:s"),
            ];
            $this->AdminModel->updateWhere("fino_cms", $updateData, array("referenceid" => $ref_id));

            if ($status == 1) {
                $txn_user = $check_txn[0]['user_id'];
                $amount = $check_txn[0]['amount'];
                $my_account = $this->AdminModel->selectAllFromWhere('users', ["id" => $txn_user]);
                $user_plan_id = $my_account[0]['plan_id'];
                $user_type = $my_account[0]['user_type'];
                $user_login_id  = $my_account[0]['email'];
                $user_id = $txn_user;
                $last_id = $check_txn[0]['id'];
                $parent_id = $my_account[0]['parent_id'];

                $txn_detail = [
                    "mobile" => $check_txn[0]['mobile'],
                    "amount" => $check_txn[0]['amount'],
                    "referenceid" => $check_txn[0]['referenceid'],
                    "network" => $check_txn[0]['network'],
                    "FinoTransactionID" => $check_txn[0]['FinoTransactionID'],
                ];
                
                /** * Commission **/
                try {
                    $this->CommissionSlotModel->distribute_commission(22, $last_id, $user_type, $user_id, $user_login_id, $parent_id, $amount, $user_plan_id, 'C', $txn_detail);
                } catch (Exception $e) {
                    $response = [
                        'status' => 405,
                        'message' => $e->getMessage()
                    ];
                    echo json_encode($response);
                    return false;
                }

                $arr = [
                    "status" => 200,
                    "message" => "Transaction Successfull"
                ];
            } else {
                $arr = [
                    "status" => 400,
                    "message" => "Transaction failed!!"
                ];
            }
            echo json_encode($arr);
            return false;
        }

        /** *********************************** END FINO TXN SUCCESS CALLBACK ******************************* */


          /** ***********************************  FINO TXN FAILED CALLBACK ******************************* */
          if ($decode_data->event == 'FINO_CMS_TRANSACTION_FAILED') {

             $ref_id = $decode_data->param->referenceid;
            $FinoTransactionID = $decode_data->param->FinoTransactionID;
            $ackno = $decode_data->param->ackno;
            $mobile = $decode_data->param->mobile;
            $uniqueid = $decode_data->param->uniqueid;
            $network = $decode_data->param->network;
            $status = $decode_data->param->status;
            $remarks = $decode_data->param->remarks;

            $check_txn = $this->AdminModel->selectAllFromTableOrderBy('fino_cms', 'id', 'desc', ["referenceid" => $ref_id]);

            if (empty($check_txn)) {
                $arr = [
                    "status" => 400,
                    "message" => "Transaction failed.."
                ];
                echo json_encode($arr);
                return false;
            }
            $updateData = [
                "txn_failed_callback"       =>      $data,
                "FinoTransactionID"         =>      $FinoTransactionID,
                "mobile"                    =>      $mobile,
                "uniqueid"                  =>      $uniqueid,
                "network"                   =>      $network,
                "ackno"                     =>      $ackno,
                "status"                    =>      $status,
                "remarks"                   =>      $remarks,
                "updated_at"                =>      date("Y-m-d H:i:s"),
            ];
            $this->AdminModel->updateWhere("fino_cms", $updateData, array("referenceid" => $ref_id));

            if ($status == 0) {
                $txn_user = $check_txn[0]['user_id'];
                $amount = $check_txn[0]['amount'];

                 /** Refund balance and add to fund list */
                 $my_funds = [
                    "channel_id"                =>      $this->config->item('channel_id'),
                    "service_id"                =>      22,
                    "user_id"                   =>      $txn_user,
                    "type"                      =>      'D',
                    "remark"                    =>      "Rs. " . $amount . " has been Refunded to wallet for Fino CMS Txn: " . $ref_id . " ",
                    "amount"                    =>      $amount,
                    "before_bal"                =>      get_balance($txn_user),
                    "updated_bal"               =>      get_balance($txn_user) + $amount,
                    "date"                      =>      date("Y-m-d H:i:s"),
                ];
                $this->AdminModel->insertInto('fund_list', $my_funds);

                /** Update balance */
                $update_bal = [
                    "user_balance"  => get_balance($txn_user) + $amount
                ];
                $this->AdminModel->updateWhere("users", $update_bal, array("id" => $txn_user));

                //* update wallet status as refunded */
                $updateData = [
                    "wallet_debited"            =>      2,
                    "updated_at"                =>      date("Y-m-d H:i:s"),
                ];
                $this->AdminModel->updateWhere("fino_cms", $updateData, array("referenceid" => $ref_id));

                $arr = [
                    "status" => 200,
                    "message" => "Transaction Successfull"
                ];

            } else {
                $arr = [
                    "status" => 400,
                    "message" => "Transaction failed!"
                ];
            }
            echo json_encode($arr);
            return false;
        }

        /** *********************************** END FINO TXN FAILED CALLBACK ******************************* */
        

        
    }


     /** Payworld aeps verify **/
     public function pw_aeps_verify(){

        $data = file_get_contents('php://input');
        
        $decode_data = json_decode($data, false);
        
        mail("kanhaiya4it@gmail.com","AEPS API unipay verfied data from production",$data);

        $string =$decode_data->verify_data;
        
        
        
        $decrypted_data = $this->pwaeps->decrypt($string, $this->config->item('contentSecretKey'));
        
         
        
        $obj = json_decode($decrypted_data, false);

         /** If agent not exits in database */
        if (get_user_id_from_agent_id($obj->agentId) == 0 ) {
            echo 'Agent Not Found';
            return false;
        }

        if($obj->transactionType == 'CW'){
            $insertData = [
                "channel_id"            =>      $this->config->item('channel_id'),
                "user_id"               =>      get_user_id_from_agent_id($obj->agentId),
                "mobile_no"             =>      $obj->mobileNumber,
                "aadhar_no"             =>      $obj->cardnumberORUID->adhaarNumber,
                "bank"                  =>      $obj->cardnumberORUID->nationalBankIdentificationNumber,
                "ackno"                 =>      $obj->merchantTransactionId,
                "transaction_type"      =>      $obj->transactionType,
                "amount"                =>      $obj->transactionAmount,
                "status"                =>      2,
                "json_response"         =>      json_encode($decrypted_data),
                "record_type"           =>      1,
                "api"                   =>      2,
                "created_at"            =>      date("Y-m-d H:i:s"),
            ];
        } else {
            $insertData = [
                "channel_id"            =>      $this->config->item('channel_id'),
                "user_id"               =>      get_user_id_from_agent_id($obj->agentId),
                "mobile_no"             =>      $obj->mobileNumber,
                "aadhar_no"             =>      $obj->cardnumberORUID->adhaarNumber,
                "bank"                  =>      $obj->cardnumberORUID->nationalBankIdentificationNumber,
                "ackno"                 =>      $obj->merchantTransactionId,
                "transaction_type"      =>      $obj->transactionType,
                "status"                =>      2,
                "json_response"         =>      json_encode($decrypted_data),
                "record_type"           =>      1,
                "api"                   =>      2,
                "created_at"            =>      date("Y-m-d H:i:s"),
            ];
        }

        $this->AdminModel->insertInto('aeps', $insertData);
        $last_id= $this->db->insert_id();

        $response_data = array(
            "mobileNumber" => $obj->mobileNumber,
            "timestamp" => time(),
            "transactionType" => $obj->transactionType,
            "agentId" => $obj->agentId,
            "merchantTransactionId" => $obj->merchantTransactionId,
            "transactionId" => $last_id,
            "status" => "SUCCESS",
            "failure_desc" => "",
            "description" => "Transaction is successful");
        
        //  mail("abc@gmail.com","AEPS API before Sending data to api ",$response_data);
        
        /// update transaction id
        $updateTxn= [
            "referenceno"           =>      $last_id,
        ];
        $this->AdminModel->updateWhere("aeps", $updateTxn, array("id" => $last_id));
         
        //encrypting data using header secret key
        $enc_parameters = $this->pwaeps->encrypt(json_encode($response_data),$this->config->item('contentSecretKey'), '');
        //making json response array and print it
        $request_data = array("verify_data" => $enc_parameters);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($request_data);

    }

    public function pw_aeps_callback(){
        
        $data = file_get_contents('php://input');
        $decode_data = json_decode($data, false);
        $string = $decode_data->callback_response;
        
        $decrypted_data = $this->pwaeps->decrypt($string, $this->config->item('contentSecretKey'));
        // mail("kk@gmail.com","AEPS Callback data from production",$decrypted_data);
        $obj = json_decode($decrypted_data, false);

        if($obj->TxnStatus == 'Success'){
            $status= 1;
        } else  if($obj->TxnStatus == 'Pending'){
            $status= 2;
        } else  if($obj->TxnStatus == 'Decline'){
            $status= 0;
        } 
        else {
            $status = 2;
        }

         $updateData = [
            // "referenceno"           =>      $obj->transactionId,
            "bankrrn"               =>      $obj->rrn,
            "response_message"      =>      $obj->responsemsg,
            "status"                =>      $status,
            "json_response"         =>      json_encode($decrypted_data),
            "updated_at"            =>      date("Y-m-d H:i:s"),
        ];
        
        $this->AdminModel->updateWhere("aeps", $updateData, array("id" => $obj->transactionId));

        
        //here transactionId is user id   
        $txn_details = $this->AdminModel->selectAllFromWhere('aeps', ["id" => $obj->transactionId ]);
        $txn_user = $txn_details[0]['user_id'];
        
         //fetch my accunt data
         $my_account = $this->AdminModel->selectAllFromWhere('users', ["id" => $txn_user ]);
         $parent_id = $my_account[0]['parent_id'];
         $user_type = $my_account[0]['user_type'];
         $sender_name = $my_account[0]['name'];

            
        /** check data nd log into d **/
        /** If Transaction is success */
         if($obj->TxnStatus == 'Success' && $obj->aepsmode == 'WITHDRAW'){
             
            $my_funds = [
                "channel_id"                =>      $this->config->item('channel_id'),
                "service_id"                =>      4,
                "user_id"                   =>      $txn_user,
                "type"                      =>      'C',
                "remark"                    =>      "Rs. ". $obj->txnamt." credited into wallet for AEPS Cash Withdrawal of Aadhar No ". $obj->aadhar." ",
                "amount"                    =>      $obj->txnamt,
                "before_bal"                =>      get_balance($txn_user),
                "updated_bal"               =>      get_balance($txn_user) + $obj->txnamt,
                "date"                      =>      date("Y-m-d H:i:s"),
            ];
            $this->AdminModel->insertInto('fund_list', $my_funds);

            $update_bal = [
                "user_balance"  => get_balance($txn_user) + $obj->txnamt
            ];
            $this->AdminModel->updateWhere("users", $update_bal, array("id" => $txn_user ));
        }


         /** =========================================================  Cash Withdrawal && Mini Statement ================================================================ **/
         
         if($obj->TxnStatus == 'Success'){
             
            if($obj->aepsmode == 'WITHDRAW' || $obj->aepsmode == 'MINISTATE') {

             $user_plan_id = $my_account[0]['plan_id'];
             
             if($obj->aepsmode == 'WITHDRAW'){
                 $txn_amount = $obj->txnamt;
                 $service_id = 4;
                 $service_name ="AEPS Cash Withdrawal";
                 
             } else if($obj->aepsmode == 'MINISTATE'){
                 $txn_amount = 2;
                 $service_id = 11;
                 $service_name ="AEPS Mini Statement";
             }
             
             if (!empty($user_plan_id) && !empty($user_type) || $user_type == 0) {
                 /**
                  * Generate Current User Commission
                  */
                 /** 
                  * check slot for individual user
                  * @param serviceType,user_type,email,amount,plan_id
                  */

                 $specific_user_slot_self = $this->CommissionSlotModel->check_specific_user_slot($service_id, $user_type, $my_account[0]['email'], $txn_amount , $user_plan_id,'C');

                 if (!empty($specific_user_slot_self)) {
                     $commission_type = $specific_user_slot_self[0]['commission_type'];
                     $chain_type = $specific_user_slot_self[0]['chain_type'];
                     $charges = json_decode($specific_user_slot_self[0]['charges']);
                     $ctype = $specific_user_slot_self[0]['type'];


                     if ($commission_type == 1) {
                         $commission_amt_with_tds = $specific_user_slot_self[0]['commission_amt'];
                         $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;
                         $commission_amt = $specific_user_slot_self[0]['commission_amt'] - $tds;
                         $commission_type_value = $specific_user_slot_self[0]['commission_amt'];
                     } else if ($commission_type == 2) {

                         $commission_amt_with_tds = ($txn_amount * $specific_user_slot_self[0]['percentage']) / 100;
                         $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;

                         $commission_amt = ($txn_amount * $specific_user_slot_self[0]['percentage']) / 100 - -$tds;
                         $commission_type_value = $specific_user_slot_self[0]['percentage'];
                     }
                 } else {

                     /**
                      * General Slot
                      * @param serviceType,user_type,amount,plan_id
                      */
                     $general_slot_self = $this->CommissionSlotModel->check_general_slot($service_id, $user_type, $txn_amount , $user_plan_id ,'C');

                     // print_r($general_slot_self);

                     if (!empty($general_slot_self)) {

                         $commission_type = $general_slot_self[0]['commission_type'];
                         $chain_type = $general_slot_self[0]['chain_type'];
                         $charges = json_decode($general_slot_self[0]['charges']);
                         $ctype = $general_slot_self[0]['type'];

                         if ($commission_type == 1) {
                             $commission_amt_with_tds = $general_slot_self[0]['commission_amt'];
                             $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;

                             $commission_amt = $general_slot_self[0]['commission_amt'] - $tds;
                             $commission_type_value = $general_slot_self[0]['commission_amt'];
                         } else if ($commission_type == 2) {

                             $commission_amt_with_tds = ($txn_amount * $general_slot_self[0]['percentage']) / 100;
                             $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;

                             $commission_amt = ($txn_amount * $general_slot_self[0]['percentage']) / 100 - $tds;
                             $commission_type_value = $general_slot_self[0]['percentage'];
                         }
                     }
                 }

                 // if (!empty($commission_amt) && !empty($commission_type) && !empty($commission_type_value)) {

                 if (isset($specific_user_slot_self) || isset($general_slot_self)) {

                     $before_balance = get_balance($txn_user);

                     if ($ctype == 'C') {
                         
                         if($obj->aepsmode == 'WITHDRAW'){
                             $cmsg = "Commission Generated for AEPS Cash Withdrawal For Amount: ".$obj->txnamt.", Aadhar no" . $obj->aadhar . " , Commission Charge ". number_format($commission_amt_with_tds,2). " , TDS ". number_format($tds,2)."  , Total Commission ".number_format($commission_amt,2)."  by SELF ";
                         } else {
                             $cmsg = "Commission Generated for AEPS Mini Statement For Aadhar no" . $obj->aadhar . " , Commission Charge ". number_format($commission_amt_with_tds,2). " , TDS ". number_format($tds,2)."  , Total Commission ".number_format($commission_amt,2)."  by SELF ";
                         }
                         $updated_balance = $before_balance + $commission_amt;
                     } else if ($ctype == 'D') {
                         $cmsg = "Wallet Debited for AEPS Cash Withdrawal For Amount: ".$obj->txnamt.", Aadhar no" . $obj->aadhar. " by SELF ";
                         $updated_balance = $before_balance - $commission_amt;
                     }


                     $self_commission = [
                         "channel_id"                =>      $this->config->item('channel_id'),
                         "service_type"              =>      $service_id,
                         "tid"                       =>      $obj->transactionId,
                         "user_id"                   =>      $txn_user,
                         "transaction_value"         =>      $txn_amount,
                         "transaction_type"          =>      1,
                         "earned_amount"             =>      $commission_amt,
                         "tds"                       =>      $tds,
                         "commission_type"           =>      $commission_type,
                         "commission_type_value"     =>      $commission_type_value,
                         "charges"                   =>      $charges->tds_charge,
                         "status"                    =>      1,
                         "type"                      =>      $ctype,
                         "msg"                       =>      $cmsg,
                         "created_by"                =>      $txn_user,
                         "created_at"                =>      date("Y-m-d H:i:s"),
                     ];

                     $this->AdminModel->insertInto('commission_log', $self_commission);

                     $mfArr = [
                         "channel_id"                =>      $this->config->item('channel_id'),
                         "service_id"                =>      $service_id,
                         "user_id"                   =>      $txn_user,
                         "amount"                    =>      $commission_amt,
                         "type"                      =>      $ctype,
                         "remark"                    =>      $cmsg,
                         "amount"                    =>      $commission_amt,
                         "before_bal"                =>      $before_balance,
                         "updated_bal"               =>      $updated_balance,
                         "date"                      =>      date("Y-m-d H:i:s"),
                     ];

                     $this->AdminModel->insertInto('fund_list', $mfArr);

                     /**
                      * Update balance
                      */

                     $dt = [
                         "user_balance"  => $updated_balance
                     ];

                     $this->AdminModel->updateWhere("users", $dt, array("id" => $txn_user ));
                 }
             }

             if (!empty($chain_type) ) //if chain type variable exits
                 if (!empty($parent_id) && $chain_type == 'Chain' && $ctype == 'C' && $obj->aepsmode == 'WITHDRAW') {

                     if ($user_type > 0) {
                        $loop = $user_type;
                    }


                     if ($loop >= 1) {

                         for ($i = 1; $i <= $loop; $i++) {
                             $parent_id = $parent_id;
                             $user = $this->AdminModel->selectAllFromWhere('users', ["id" => $parent_id, "status" => 1]);
                             $utype = $user[0]['user_type'];
                             $level_plan_id = $user[0]['plan_id'];

                             /** 
                              * check slot for individual user
                              * @param serviceType,user_type,email,amount,plan_id
                              */
                             $specific_user_slot = $this->CommissionSlotModel->check_specific_user_slot($service_id, $utype, $user[0]['email'], $txn_amount , $level_plan_id ,'C');

                             /**
                              * General Slot
                              * @param serviceType,user_type,amount,plan_id
                              */
                             $general_slot = $this->CommissionSlotModel->check_general_slot($service_id, $utype, $txn_amount , $level_plan_id,'C');

                             if (!empty($specific_user_slot)) {
                                 $commission_type_parent = $specific_user_slot[0]['commission_type'];
                                 $ref_chain_type = $specific_user_slot[0]['chain_type'];
                                 $charges = json_decode($specific_user_slot[0]['charges']);


                                 if ($commission_type_parent == 1) {

                                     $commission_amt_with_tds = $specific_user_slot[0]['commission_amt'];
                                     $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;

                                     $commission_amt_parent = $specific_user_slot[0]['commission_amt'] - $tds;
                                     $commission_type_parent_value = $specific_user_slot[0]['commission_amt'];
                                 } else if ($commission_type_parent == 2) {

                                     $commission_amt_with_tds = ($txn_amount * $specific_user_slot[0]['percentage']) / 100;
                                     $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;

                                     $commission_amt_parent = ($txn_amount * $specific_user_slot[0]['percentage']) / 100  - $tds;
                                     $commission_type_parent_value = $specific_user_slot[0]['percentage'];
                                 }
                             } else {

                                 if (!empty($general_slot)) {

                                     $commission_type_parent = $general_slot[0]['commission_type'];
                                     $ref_chain_type = $general_slot[0]['chain_type'];
                                     $charges = json_decode($general_slot_self[0]['charges']);

                                     if ($commission_type_parent == 1) {
                                         $commission_amt_with_tds = $general_slot[0]['commission_amt'];
                                         $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;

                                         $commission_amt_parent = $general_slot[0]['commission_amt'] - $tds;
                                         $commission_type_parent_value = $general_slot[0]['commission_amt'];
                                     } else if ($commission_type_parent == 2) {

                                         $commission_amt_with_tds = ($txn_amount * $general_slot[0]['percentage']) / 100;
                                         $tds = ($commission_amt_with_tds * $charges->tds_charge) / 100;

                                         $commission_amt_parent = ($txn_amount * $general_slot[0]['percentage']) / 100 - $tds;
                                         $commission_type_parent_value = $general_slot[0]['percentage'];
                                     }
                                 }
                             }

                             if (isset($general_slot) || isset($specific_user_slot) && !empty($ref_chain_type)) {
                                 
                                 if($obj->aepsmode == 'WITHDRAW'){
                                    $chain_msg = "Commission Generated for AEPS Cash Withdrawal For Amount: ".$obj->txnamt.", Aadhar no" . $obj->aadhar . " , Commission Charge ". number_format($commission_amt_with_tds,2). " , TDS ". number_format($tds,2)."  , Total Commission ".number_format($commission_amt_parent,2)."  by " . $sender_name. " ";
                                 } else {
                                    $chain_msg = "Commission Generated for AEPS Mini Statement For Aadhar no" . $obj->aadhar . " , Commission Charge ". number_format($commission_amt_with_tds,2). " , TDS ". number_format($tds,2)."  , Total Commission ".number_format($commission_amt_parent,2)."  by " . $sender_name. " ";
                                }
                         
                                 $params['service_type'] = $service_id;
                                 $params['user_id'] = $user[0]['id'];
                                 $params['tid'] = $obj->transactionId;
                                 $params['transaction_value'] = $txn_amount;
                                 $params['channel_id'] = $this->config->item('channel_id');
                                 $params['transaction_type'] = 1;
                                 $params['earned_amount'] = $commission_amt_parent;
                                 $params['tds'] = $tds;
                                 $params['commission_type'] = $commission_type_parent;
                                 $params['commission_type_value'] = $commission_type_parent_value;
                                 $params['charges'] = $charges->tds_charge;
                                 $params['status'] = 1;
                                 $params['type'] = 'C';
                                 $params['msg'] = $chain_msg;
                                 $params['created_by'] = $txn_user;
                                 $params['created_at'] = date("Y-m-d H:i:s");
                                 $commission_array[] = $params;

                                 /**
                                  * Update balance
                                  */
                                 $dt = [
                                     "user_balance"  => $user[0]['user_balance'] + $commission_amt_parent
                                 ];

                                 $this->AdminModel->updateWhere("users", $dt, array("id" => $user[0]['id']));


                                 $flistArr = [
                                     "channel_id"                =>      $this->config->item('channel_id'),
                                     "service_id"                =>      $service_id,
                                     "user_id"                   =>      $user[0]['id'],
                                     "type"                      =>      'C',
                                     "remark"                    =>      $chain_msg,
                                     "amount"                    =>      $commission_amt_parent,
                                     "before_bal"                =>      $user[0]['user_balance'],
                                     "updated_bal"               =>      $user[0]['user_balance'] + $commission_amt_parent,
                                     "date"                      =>      date("Y-m-d H:i:s"),
                                 ];

                                 $this->AdminModel->insertInto('fund_list', $flistArr);
                             }

                             $parent_id = $user[0]['parent_id'];

                             /** If Parent ID does not exits then break the loop */
                             if (empty($parent_id) || $ref_chain_type == 'Self') {
                                 break;
                             }
                         }

                         if (isset($commission_array)) {
                             $this->db->insert_batch('commission_log', $commission_array);
                         }
                     }
                 }
         } 
         }// if response code == 1 END
         
         echo "success";

    }
    
    
    
    /**
     * APES Callback from Mobile APP
     * 
     */

    public function complete_aeps_transaction()
    {
        $this->load->model(array('AdminModel'));
        $this->load->library(array('AppAeps'));
        $token = $this->api->create_jwt_token();

        $tranid = $_REQUEST['tranid'];
        $pid = $_REQUEST['biodata'];

        $check=  $this->AdminModel->selectAllFromTableOrderBy('app_aeps', 'id', 'desc', ["token" => $tranid]);

        if(empty($check)){
            $this->session->set_flashdata('error', 'No Records found');
            redirect("PublicController/aeps_error/");
            exit;
        }
       
        $update = [
            "pid"  => $pid
        ];
       $this->AdminModel->updateWhere("app_aeps", $update, array("token" => $tranid ));
     
       /** Get data from table */
        $data = $this->AdminModel->selectAllFromTableOrderBy('app_aeps', 'id', 'desc', ["token" => $tranid]);
        
        if($data[0]['transactiontype'] == 'CW'){
            $res= $this->appaeps->withdrawal($data,$token , $tranid);
        } else if($data[0]['transactiontype'] == 'MS'){
            $res= $this->appaeps->miniStatement($data,$token, $tranid);
        } else if($data[0]['transactiontype'] == 'BE'){
            $res= $this->appaeps->balanceEnquiry($data,$token, $tranid);
        } else if($data[0]['transactiontype'] == 'M'){
            $res= $this->appaeps->aadhar_pay_withdrawal($data,$token, $tranid);
        } else {
            $this->session->set_flashdata('error', 'No Transaction type found');
            redirect("PublicController/aeps_error/");
            exit;
        }
        /** send data to controller */
        
    }

    
}
