<?php

require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ACTIONS/config.php";
require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ACTIONS/API.php";

$subject = $_POST['sujet'];
$message = $_POST['msg'];
$email = $_SESSION['email'];

$requestAddMessage = new API();

$data = [
    'action' => 'insert',
    'table' => 'message',
    'message_email' => $email,
    'message_subject' => $subject,
    'message_message' => $message
];

$response = $requestAddMessage->dataVerification($data);

echo $paraFile->displayHead("messageSender");
echo $paraFile->displayHeader($isAdmin, $isConnected);
if($response['state']) {
    echo "
    <meta http-equiv='refresh' content='2;URL=/'>
    <main style='display: flex; justify-content: center; align-items: center'>
        <h2>Message bien envoyé</h2>
    </main>
    ";
} else {
    echo "
    <main style='display: flex; justify-content: center; align-items: center'>
        <h2>Un probleme est survenu</h2><br>
        <p>Veuillez contacter le support</p><br>
        <p>uneAdresseMailDeSupport@gmail.com</p>
    </main>
    ";
}
echo $paraFile->displayFooter();