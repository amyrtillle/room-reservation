<?php

require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ACTIONS/config.php";
require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ACTIONS/API.php";

$loginUser = $_SESSION['login'];
$roomId = $_POST['room'];
$startDateRealFormat = $_POST['startDateRealFormat'];
$endDateRealFormat = $_POST['endDateRealFormat'];

$requestAddMessage = new API();

$data = [
    'action' => 'insert',
    'table' => 'reservation',
    'reservation_dateStart' => $startDateRealFormat,
    'reservation_dateEnd' => $endDateRealFormat,
    'reservation_isAccepted' => 0,
    'room_id' => $roomId,
    'user_login' => $loginUser,
];

$response = $requestAddMessage->dataVerification($data);

echo $paraFile->displayHead("messageSender");
echo $paraFile->displayHeader($isAdmin, $isConnected);
if($response['state']) {
    echo "
    <meta http-equiv='refresh' content='2;URL=/'>
    <main style='display: flex; justify-content: center; align-items: center'>
        <h2>Réservé</h2>
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