<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require $_SERVER['DOCUMENT_ROOT'] . '/RESSOURCES/ACTIONS/API.php';

    $UrlAllUsers = "https://iut1-mmi-moodle.univ-grenoble-alpes.fr/webservice/rest/server.php?wstoken=ba545e95bb07afa2256e1dcaa47c07a5&moodlewsrestformat=json&wsfunction=core_enrol_get_enrolled_users&courseid=412";

    // Full Hostname of your CAS Server
    $cas_host = 'cas-uga.grenet.fr';
    // Context of the CAS Server
    $cas_context = '';
    // Port of your CAS server. Normally for a https server it's 443
    $cas_port = 443;
    // url à charger apres l'authetification
    $back_url = $_SERVER['DOCUMENT_ROOT'] . '/RESSOURCES/gestion-user.php';
    // chargement de la librairie CAS : elle est dans les répertoires par défaut
    require_once 'CAS/CAS.php';

    phpCAS::setLogger();
    phpCAS::setVerbose(true);
    phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context, $back_url);
    phpCAS::setNoCasServerValidation();
    phpCAS::setLang(PHPCAS_LANG_FRENCH);

    if( phpCAS::checkAuthentication()){
        // // at this step, the user has been authenticated by the CAS server
        // // and the user's login name can be read with phpCAS::getUser().

        $requestAdmin = new API();

        session_start();
        $_SESSION["login"] = phpCAS::getUser();
        $_SESSION["isConnected"] = true;
        if (sizeof($requestAdmin->getIsAdmin($_SESSION["login"])) != 0) {
            $_SESSION["isAdmin"] = true;
        } else {
            $_SESSION["isAdmin"] = false;
        }

        $allUsers = json_decode(file_get_contents($UrlAllUsers));
        foreach ($allUsers as $userInfos){
            if ($userInfos->{'username'} == $_SESSION['login']){
                $_SESSION["fname"] = $userInfos->{'firstname'};
                $_SESSION["name"] = $userInfos->{'lastname'};
                $_SESSION["email"] = $userInfos->{'email'};
                $_SESSION["pp"] = $userInfos->{'profileimageurl'};
            }
        }
        header('Location: https://asaed4a.gremmi.fr');
    } else {
        phpCAS::forceAuthentication();
    }

    ?>