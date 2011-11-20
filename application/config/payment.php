<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//
// Payment/Donation configuration
//
$config['payment']= array();

$config['payment']['secure_url'] = "https://icheckgateway.com/Fission/QuestForMeaning/Default.aspx?V7=";

$config['payment']['purchase'] = array(
    'ChurchOnline' => array('name' => 'Church OnLine (COL)', 'amt' => 0.00, 'cost' => '299.00'),
    'NewUUClass'   => array('name' => 'Congregational New UU Class', 'amt' => 0.00, 'cost' => '250.00'),
    'GiftOfQuest'  => array('name' => 'Gift of Quest', 'amt' => 0.00, 'cost' => '50.00')
);    

$config['payment']['donations'] = array(
    'GeneralGift' => array('name' => 'General Gift', 'amt' => 0.00, 'cost' => '0'),
    'PledgePayment'   => array('name' => 'Pledge Payment', 'amt' => 0.00, 'cost' => '0'),
    'PrisonMinistry'  => array('name' => 'Prison Ministry', 'amt' => 0.00, 'cost' => '0'),
    'MilitaryMinistry'  => array('name' => 'Military Ministry', 'amt' => 0.00, 'cost' => '0'),
    'CYFGift'  => array('name' => 'CYF Gift', 'amt' => 0.00, 'cost' => '0'),
    'CYFSponsor'  => array('name' => 'CYF Sponsor', 'amt' => 0.00, 'cost' => '0')
);    


