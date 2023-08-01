<?php
require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ACTIONS/config.php";
require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ACTIONS/API.php";

$api = new API();

$data = [
    'action' => 'select',
    'table' => 'room'
];

$response = $api->dataVerification($data);

if($response['state']){
    $tab = array();
    foreach ($response['data'] as $item){
        $tab[] = (object)[
            "id" => $item['room_id'],
            "title" => $item['room_name']
            ,];
    }

    $jsontab = json_encode($tab);
}

var_dump($_GET);

if($isConnected) {
    echo $paraFile->displayHead("Contact");
    echo $paraFile->displayHeader($isAdmin, $isConnected);
    ?>
    <main>
        <div id="calendar">

        </div>

        <script>



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
                height: '800px',
                headerToolbar: {
                    start: 'prev,next today',
                    center: 'title',
                    end: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek resourceTimeGridDay'
                },
                firstDay: 1,
                scrollTime: "08:00:00",
                slotMinTime: "08:00:00",
                slotMaxTime: "18:30:00",
                allDaySlot: false,
                //dayMaxEvents: mettre fonction pour que ça se limite au nombre de salles de la BD
                hiddenDays: [0, 6],
                buttonText: function (texts) {
                    texts.resourceTimeGridWeek = 'resources';
                    return texts;
                },
                resources: <?php echo $jsontab; ?>,
                events: createEvents(),
                views: {
                    timeGridWeek: {pointer: true},
                    resourceTimeGridWeek: {pointer: true},
                    timeGridDay: {nowIndicator: true},
                    resourceTimeGridDay: {nowIndicator: false}
                },
                dayMaxEvents: true,
                defaultTimedEventDuration: '01:00',
                selectable: true,
                unselectAuto: false,
                //     selectAllow: function(selectInfo) {
                //      var duration = moment.duration(selectInfo.end.diff(selectInfo.start));
                //      return duration.asHours() <= 4;
                // },
                eventStartEditable: false //true pour gestion admin
                // slotEventOverlap : pour empêcher les events d'une meme salle de se superposer
            });


            function createEvents() {
                let days = [];
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
                ];
            }

            function _pad(num) {
                let norm = Math.floor(Math.abs(num));
                return (norm < 10 ? '0' : '') + norm;
            }

        </script>
    </main>
    <?php
    echo $paraFile->displayFooter();
} else {
    header('Location: https://asaed4a.gremmi.fr/RESSOURCES/ACTIONS/login.php');
}