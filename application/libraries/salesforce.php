<?php

require_once 'salesforce/phptoolkit/soapclient/SforcePartnerClient.php';

class Salesforce {

    var $sforceUsername = 'jake@fissionstrategy.com';
    var $sforcePassword = '35u5JA44';//'tNf5zHWP';
    var $sforceSecurityToken = 'SDIeeZ1sa90tYO4yO7mDcnbzG';
    var $sforceWsdl = '';
    var $sForceClient = null;

    function Salesforce() {
        // Session used to store SOAP client attributes
        //        session_start();
 
        $this->sforceWsdl = dirname(__FILE__) . '/salesforce/partner.wsdl';
        $this->sforceClient = new SforcePartnerClient();
        $soapClient = $this->sforceClient->createConnection($this->sforceWsdl);
        if(!empty($_SESSION['sforceLocation']) && !empty($_SESSION['sforceSessionId'])) {
            // Re-initialize connection from session
            $this->sforceClient->setEndpoint($_SESSION['sforceLocation']);
            $this->sforceClient->setSessionHeader($_SESSION['sforceSessionId']);
        }
        else {
            // Create new connection
            // The password must be the user's password + the security token
            $sforceLogin = $this->sforceClient->login(
                $this->sforceUsername,
                $this->sforcePassword . $this->sforceSecurityToken
            );
        }

        // Store SOAP client attributes for later use
        $_SESSION['sforceLocation'] = $this->sforceClient->getLocation();
        $_SESSION['sforceSessionId'] = $this->sforceClient->getSessionId();
    }


    function add_contact($contact) {
        $c = new sObject();
        $c->type = 'Contact';
        $c->fields = array('FirstName' => $contact['FirstName'],
                     'LastName' => $contact['LastName'],
                     'Email' => $contact['Email']);

        $result = $this->sforceClient->create(array($c), 'Contact');
        error_log("adding contact " . var_dump($contact));
        error_log("adding contact " . $result);
        //$contactQuery = "insert into Contact (FirstName,LastName,Email) VALUES ('Cindy','M','cindy@fissionstrategy.com')";
        //$contactResponse = $this->sforceClient->query($contactQuery);
    }

    function list_contacts() {
        $contactQuery = "SELECT Contact.FirstName, Contact.LastName,Contact.Email FROM Contact ORDER BY Contact.LastName ASC";
        $contactResponse = $this->sforceClient->query($contactQuery);
        foreach($contactResponse->records as $contact)
            {
                // Print
                echo ' First name: ' . (string) $contact->fields->FirstName . '';
                echo ' Last name: ' .  (string) $contact->fields->LastName . '';
                echo ' Email: ' .  (string) $contact->fields->Email . '';
                echo '<br />';
            }
    }
}


?>