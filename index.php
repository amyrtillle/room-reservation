<?php
require $_SERVER['DOCUMENT_ROOT'] . "/RESSOURCES/ACTIONS/API.php";
require $_SERVER['DOCUMENT_ROOT'] . "/RESSOURCES/ACTIONS/config.php";

$url = $_SERVER['REQUEST_URI'];

echo $paraFile->displayHead("Accueil");
echo $paraFile->displayHeader($isAdmin, $isConnected);

$api = new API();

$roomSelect = [
    'action' => 'select',
    'table' => 'room',
    'orderBy' => 'room_name'
];

$response = $api->dataVerification($roomSelect);

if ($response['state']) {
    foreach ($response['data'] as $item) {
        $rooms[] = (object)[
            "id" => $item['room_id'],
            "title" => $item['room_name']
            ,];
    }
    $jsonRooms = json_encode($rooms);
}

echo "
<main>
    <div id='calendar'>
        
    </div>
    <div id='cta-container'>
        <a href='/RESSOURCES/PAGES/gestion-user.php' id='cta'>
            <p>Réserver&nbsp;une&nbsp;salle</p>
            <div id='cta-icon'>
                Réserver&nbsp;une&nbsp;salle
                <ion-icon name='arrow-forward-outline'></ion-icon>
            </div>
            <span id='bg-cta'></span>
        </a>
    </div>
</main>
<script type='module' src='https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js'></script>
<script nomodule src='https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js'></script>
";
?>
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
                    end: 'timeGridWeek,timeGridDay,listWeek, resourceTimeGridDay'
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
                    texts.timeGridWeek = 'semaine';
                    texts.listWeek = 'liste des évènements';
                    texts.resourceTimeGridDay = 'salles';
                    texts.today = 'aujourdhui';
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
                selectable: false,
                unselectAuto: false,
                //     selectAllow: function(selectInfo) {
                //      var duration = moment.duration(selectInfo.end.diff(selectInfo.start));
                //      return duration.asHours() <= 4;
                // },
                eventStartEditable: true, //true pour gestion admin
                // slotEventOverlap : pour empêcher les events d'une meme salle de se superposer
                eventResizeStop: function (evt) {
                    console.log("resize stop")
                    console.log(evt)
                }
            });
            console.log(ec)

            async function createEvents(jsonRooms) {
                selectUrl = "./RESSOURCES/ACTIONS/API.php?action=select&table=reservation&leftJoin[tableToJoin]=room&leftJoin[argToJoin]=room_id";
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
