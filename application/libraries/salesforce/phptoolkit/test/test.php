<?

// Session used to store SOAP client attributes
session_start();
 
// Config
$sforceUsername = 'jake@fissionstrategy.co';
$sforcePassword = '35u5JA44';//'tNf5zHWP';
$sforceSecurityToken = 'SDIeeZ1sa90tYO4yO7mDcnbzG';
$sforceWsdl = 'partner.wsdl';

// Initialize Salesforce
require_once '../soapclient/SforcePartnerClient.php';
$sforceClient = new SforcePartnerClient();
$soapClient = $sforceClient->createConnection($sforceWsdl);
if(!empty($_SESSION['sforceLocation']) && !empty($_SESSION['sforceSessionId']))
{
    // Re-initialize connection from session
    $sforceClient->setEndpoint($_SESSION['sforceLocation']);
    $sforceClient->setSessionHeader($_SESSION['sforceSessionId']);
}
else
{
    // Create new connection
    // The password must be the user's password + the security token
    $sforceLogin = $sforceClient->login(
        $sforceUsername,
        $sforcePassword . $sforceSecurityToken
    );
}
 
// Store SOAP client attributes for later use
$_SESSION['sforceLocation'] = $sforceClient->getLocation();
$_SESSION['sforceSessionId'] = $sforceClient->getSessionId();


?>