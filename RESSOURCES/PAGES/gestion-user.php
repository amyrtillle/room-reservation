<?php
require $_SERVER['DOCUMENT_ROOT'] . "/RESSOURCES/ACTIONS/config.php";
require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ACTIONS/API.php";

if($isConnected) {
    echo $paraFile->displayHead("Gestion");
    echo $paraFile->displayHeader($isAdmin, $isConnected);
    echo '
    <main>
        <div id="content-error">
            <h3>Une erreur est survenue</h3>
            <p id="errorMsg">fgxfh</p>
        </div>
        <ul id="nav">
            <li class="active" id="btnReserver">Réserver</li>
            <li class="" id="btnMyReservation">Mes réservations</li>
        </ul>
        <div id="formReservation">
            <div id="form-container">
                <form action="/RESSOURCES/ACTIONS/reservationForm.php" method="post" name="reservation" class="formReservation" id="form">
                    <h2>Demande de réservation</h2>
                    <div class="formElement">
                        <label for="nom">Nom : <span class="infoLabel">(non modifiable)</span></label>
                        <input id="nom" type="text" name="nom" value="' . strtoupper($_SESSION['name']) . ' ' . $_SESSION['fname'] . '" disabled>
                    </div>
                    <div class="formElement">
                        <label for="room">Salle : <span class="infoLabel">*</span></label>
                        <select id="room" name="room" required>
                            <option value="selection">Sélectionnez une salle</option>';
    $api = new API();

    $roomSelect = [
        'action' => 'select',
        'table' => 'room',
        'orderBy' => 'room_name'
    ];

    $response = $api->dataVerification($roomSelect);

    if ($response['state']) {
        foreach ($response['data'] as $item) {
            echo '<option value="' . $item['room_id'] . '">' . $item['room_name'] . '</option>';
            $rooms[] = (object)[
                "id" => $item['room_id'],
                "title" => $item['room_name']
                ,];
        }
        $jsonRooms = json_encode($rooms);
    }
    ?>
                        </select>
                    </div>
                    <div class="formElement">
                        <label for="datedebut">Date de début : <span class="infoLabel">*</span></label>
                        <input type="text" id="datedebut" name="datedebut" value="Selectionnez sur le calendrier (maintenir pour une selection sur mobile)" required disabled>
                        <input type="text" id="startDateRealFormat" name="startDateRealFormat" value="" hidden>
                    </div>
                    <div class="formElement">
                        <label for="datefin">Date de fin <span class="infoLabel">*</span></label>
                        <input type="text" id="datefin" name="datefin" value="Selectionnez sur le calendrier (maintenir pour une selection sur mobile)" required disabled>
                        <input type="text" id="endDateRealFormat" name="endDateRealFormat" value="" hidden="">
                    </div>
                    <div id="formFilter">
                        <button type="button" id="filterButton"><ion-icon name="funnel-outline"></ion-icon> Filtres</button>
                        <div id="backgroundFilterList"></div>
                        <div id="filterPage">
                            <div id="cross">
                                <ion-icon name="close-outline"></ion-icon>
                            </div>
                            <div id="filterTitle">
                                <h2>Choisir un filtre</h2>
                            </div>
                            <div id="filterList">
                                <div class="filterElement">
                                    <input type="checkbox" id="teacherComputer" name="teacherComputer">
                                    <label for="teacherComputer">Ordinateur prof</label>
                                </div>
                                <div class="filterElement">
                                    <input type="checkbox" id="projector" name="projector">
                                    <label for="projector">Video projecteur</labelTeacherComputer>
                                </div>
                                <div class="filterElement">
                                    <input type="checkbox" id="studentComputer" name="studentComputer">
                                    <label for="studentComputer">Ordinateurs étudiant</label>
                                </div>
                                <div class="filterElement">
                                    <input type="checkbox" id="adobe" name="adobe">
                                    <label for="adobe">Suite adobe</label>
                                </div>
                                <div class="filterElement">
                                    <input type="checkbox" id="linux" name="linux">
                                    <label for="linux">Système linux</label>
                                </div>
                                <div class="filterElement">
                                    <input type="checkbox" id="drowingRoom" name="drowingRoom">
                                    <label for="drowingRoom">Salle de dessin</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="formElement">
                        <label for="boutonsubmit" id="label-boutonsubit">
                            <div id="content-btn">
                                <span id="icon-btn"><ion-icon name="checkmark-outline"></ion-icon></span>
                                <span>Réserver</span>
                            </div>
                        </label>
                        <input type="button" value="Connexion" id="boutonsubmit"/>
                    </div>
                    <div class="formElement">
                        <p id="msg-infoObligatoire">* : infos obligatoires</p>
                    </div>
                </form>
            </div>
            <div id="calendar">
            
            </div>
        </div>
    <div id="myReservation">
        <table>
            <tbody>
            <tr>
                <td>Salle</td>
                <td>Début</td>
                <td>Fin</td>
                <td>Accepté</td>
                <td>Action</td>
            </tr>
            <?php
            $api = new API();

            $data = [
                'action' => 'select',
                'table' => 'reservation',
                'user_login' => $_SESSION['login'],
                'orderBy' => 'reservation_dateStart',
                'leftJoin' => ['tableToJoin' => 'room', 'argToJoin' => 'room_id']
            ];

            $response = $api->dataVerification($data);


            if($response['state']){
//                $tab = array();
                foreach ($response['data'] as $item){
                    echo '
                    <tr>
                    <td>' . $item['room_name'] . '</td>
                    <td>' . $item['reservation_dateStart'] . '</td>
                    <td>' . $item['reservation_dateEnd'] . '</td>
                    ';
                    if ($item['reservation_isAccepted'] == 1) {
                        echo '<td>Oui</td>';
                    } else {
                        echo '<td>Non</td>';
                    }
                    echo '<td>Supprimer</td>
</tr>';}
            }
            ?>
            </tbody>
        </table>
    </div>
    </main>
    <script src="/RESSOURCES/JS/gestion-user.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        async function displayCalendar(jsonRooms) {
            let events
            events = await createEvents(jsonRooms);

            let evt1 = {
                allDay: false,
                resourceId: 2,
                start: new Date('2023-06-12 08:00'), // reservation_debut
                end: new Date('2023-06-12 09:00'), // reservation fin
                title: 'test titre',
                titleHTML: 'test <b>titre</b>',  //nom prenom
                editable: false, //true pour gestion admin
                startEditable: false, //true pour gestion admin
                durationEditable: false, //true pour gestion admin
                display: 'auto',
                backgroundColor: '#000000', //couleur différente par salle?
                textColor: '#FFFFFF',
                // extendedProps: { arg1: 'test', arg2: 42}
            }

            let ec = new EventCalendar(document.getElementById('calendar'), {
                view: 'timeGridWeek',
                headerToolbar: {
                    start: 'prev,next today',
                    center: 'title',
                    end: 'timeGridWeek'
                },
                firstDay: 1,
                scrollTime: "08:00:00",
                slotMinTime: "08:00:00",
                slotMaxTime: "18:30:00",
                allDaySlot: false,
                //dayMaxEvents: mettre fonction pour que ça se limite au nombre de salles de la BD
                hiddenDays: [0, 6],
                buttonText: function (texts) {
                    texts.timeGridDay = 'jour';
                    texts.timeGridWeek = 'Semaine';
                    texts.listWeek = 'liste des évènements';
                    texts.resourceTimeGridDay = 'salles';
                    texts.today = 'Aujourd\'hui';
                    return texts;
                },
                resources: jsonRooms,
                events: events,
                views: {
                    timeGridWeek: {pointer: true},
                    resourceTimeGridWeek: {pointer: true},
                    timeGridDay: {nowIndicator: true},
                    resourceTimeGridDay: {nowIndicator: false}
                },
                dayMaxEvents: true,
                defaultTimedEventDuration: '01:00',
                selectable: true,
                selectLongPressDelay: 150,
                eventDidMount: checkSlotUpdate,
                unselectAuto: false,
                //     selectAllow: function(selectInfo) {
                //      var duration = moment.duration(selectInfo.end.diff(selectInfo.start));
                //      return duration.asHours() <= 4;
                // },
                eventStartEditable: false //true pour gestion admin
                // slotEventOverlap : pour empêcher les events d'une meme salle de se superposer
            });

            async function createEvents(jsonRooms) {
                selectUrl = "https://asaed4a.gremmi.fr/RESSOURCES/ACTIONS/API.php?action=select&table=reservation&leftJoin[tableToJoin]=room&leftJoin[argToJoin]=room_id";
                let arrayReservation = []

                let rooms = []
                jsonRooms.forEach((room) => {
                    rooms.push(room.id)
                })

                return fetch(selectUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw Error(response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.state){
                            allReservation = data.data
                            allReservation.forEach((reservation) => {
                                if (rooms.includes(reservation.room_id)) {
                                    if (reservation.reservation_isAccepted != 2) {
                                        if (reservation.reservation_isAccepted == 1) {
                                            colorToDisplay = "#349140"
                                        } else if (reservation.reservation_isAccepted == 0) {
                                            colorToDisplay = "#e07d1a"
                                        } else {
                                            colorToDisplay = "#e01a1a"
                                        }

                                        arrayReservation.push(
                                            {
                                                start: new Date(reservation.reservation_dateStart),
                                                end: new Date(reservation.reservation_dateEnd),
                                                resourceId: reservation.room_id,
                                                title: reservation.room_name,
                                                color: colorToDisplay
                                            })
                                    }
                                }
                            })
                            return arrayReservation;
                        } else {
                            console.log('request error')
                        }
                    })
                    .catch(error => console.log(error));

                /*let days = [];
                for (let i = 0; i < 7; ++i) {
                    let day = new Date();
                    let diff = i - day.getDay();
                    day.setDate(day.getDate() + diff);
                    days[i] = day.getFullYear() + "-" + _pad(day.getMonth()+1) + "-" + _pad(day.getDate());
                }

                return [
                    evt1,
                    {start: days[0] + " 00:00", end: days[0] + " 09:00", resourceId: 1, display: "background"},
                    {start: days[1] + " 12:00", end: days[1] + " 14:00", resourceId: 2, display: "background"},
                    {start: days[2] + " 17:00", end: days[2] + " 24:00", resourceId: 1, display: "background"},
                    {start: days[0] + " 10:00", end: days[0] + " 14:00", resourceId: 1, title: "The calendar can display background and regular events", color: "#FE6B64"},
                    {start: days[1] + " 16:00", end: days[2] + " 08:00", resourceId: 2, title: "An event may span to another day", color: "#B29DD9"},
                    {start: days[2] + " 09:00", end: days[2] + " 13:00", resourceId: 2, title: "Events can be assigned to resources and the calendar has the resources view built-in", color: "#779ECB"},
                    {start: days[3] + " 14:00", end: days[3] + " 20:00", resourceId: 1, title: "", color: "#FE6B64"},
                    {start: days[3] + " 15:00", end: days[3] + " 18:00", resourceId: 1, title: "Overlapping events are positioned properly", color: "#779ECB"},
                    {start: days[5] + " 10:00", end: days[5] + " 16:00", resourceId: 2, titleHTML: "You have complete control over the <i><b>display</b></i> of events…", color: "#779ECB"},
                    {start: days[5] + " 14:00", end: days[5] + " 19:00", resourceId: 2, title: "…and you can drag and drop the events!", color: "#FE6B64"},
                    {start: days[5] + " 18:00", end: days[5] + " 21:00", resourceId: 2, title: "", color: "#B29DD9"},
                ];*/
            }

            function _pad(num) {
                let norm = Math.floor(Math.abs(num));
                return (norm < 10 ? '0' : '') + norm;
            }
        }

        displayCalendar(<?php echo $jsonRooms; ?>);
    </script>
    <?php
    echo $paraFile->displayFooter();
} else {
    header('Location: https://asaed4a.gremmi.fr/RESSOURCES/ACTIONS/login.php');
}