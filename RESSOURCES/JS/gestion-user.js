/* ================================------------------ partie navigation ------------------================================ */
let btnReserver = document.getElementById("btnReserver");
let btnMyReservation = document.getElementById("btnMyReservation");
let formReservation = document.getElementById("formReservation");
let myReservation = document.getElementById("myReservation");

btnReserver.addEventListener('click', () => {
    formReservation.style.display = 'flex';
    myReservation.style.display = 'none';
    btnReserver.classList.add("active");
    btnMyReservation.classList.remove("active");
})

btnMyReservation.addEventListener('click', () => {
    myReservation.style.display = 'flex';
    formReservation.style.display = 'none';
    btnMyReservation.classList.add("active");
    btnReserver.classList.remove("active");
})

/* ================================------------------ partie navigation ------------------================================ */


/* ================================------------------ partie filtre ------------------================================ */
let filterButton = document.getElementById("filterButton");
let cross = document.getElementById("cross");
let backgroundFilterList = document.getElementById("backgroundFilterList");
let body = document.querySelector("body");
let filterPage = document.getElementById("filterPage");
var valScroll = 0;

var filterIsOpen = false;

filterButton.addEventListener('click', () => {
    if(filterIsOpen){
        filterIsOpen = false;
        filterPage.style.display = 'none';
        backgroundFilterList.style.display = 'none';
        body.style.overflowY = 'scroll';
        setInterval(
            getRoomWithFilter(), 500
        );
        setDays()
        window.scroll(0, valScroll)
    } else {
        filterIsOpen = true;
        filterPage.style.display = 'block';
        backgroundFilterList.style.display = 'block';
        body.style.overflowY = 'hidden';
        valScroll = window.scrollY;
        window.scroll(0, 0)
    }
})

cross.addEventListener('click', () => {
    if(filterIsOpen){
        filterIsOpen = false;
        filterPage.style.display = 'none';
        backgroundFilterList.style.display = 'none';
        body.style.overflowY = 'scroll';
        setInterval(
            getRoomWithFilter(), 500
        );
        setDays()
        window.scroll(0, valScroll)
    } else {
        filterIsOpen = true;
        filterPage.style.display = 'block';
        backgroundFilterList.style.display = 'block';
        body.style.overflowY = 'hidden';
        valScroll = window.scrollY;
    }
})

backgroundFilterList.addEventListener('click', () => {
    if(filterIsOpen){
        filterIsOpen = false;
        filterPage.style.display = 'none';
        backgroundFilterList.style.display = 'none';
        body.style.overflowY = 'scroll';
        setInterval(
            getRoomWithFilter(), 500
        );
        setDays()
        window.scroll(0, valScroll)
    } else {
        filterIsOpen = true;
        filterPage.style.display = 'block';
        backgroundFilterList.style.display = 'block';
        body.style.overflowY = 'hidden';
        valScroll = window.scrollY;
    }
})

let roomSelector = document.getElementById("room");

function getRoomWithFilter(){
    if (document.getElementById("teacherComputer").checked){
        var teacherComputer = 1;
    } else {
        var teacherComputer =  0;
    }
    if (document.getElementById("projector").checked){
        var projector = 1;
    } else {
        var projector =  0;
    }
    if (document.getElementById("studentComputer").checked){
        var studentComputer = 1;
    } else {
        var studentComputer =  0;
    }
    if (document.getElementById("adobe").checked){
        var adobe = 1;
    } else {
        var adobe =  0;
    }
    if (document.getElementById("linux").checked){
        var linux = 1;
    } else {
        var linux =  0;
    }
    if (document.getElementById("drowingRoom").checked){
        var drowingRoom = 1;
    } else {
        var drowingRoom =  0;
    }

    selectUrl = "https://asaed4a.gremmi.fr/RESSOURCES/ACTIONS/API.php?action=select&table=room";

    if (teacherComputer) { selectUrl = selectUrl + "&room_teacherComputer=" + teacherComputer }
    if (studentComputer) { selectUrl = selectUrl + "&room_studentComputer=" + studentComputer }
    if (projector) { selectUrl = selectUrl + "&room_projector=" + projector }
    if (adobe) { selectUrl = selectUrl + "&room_adobe=" + adobe }
    if (linux) { selectUrl = selectUrl + "&room_linux=" + linux }
    if (drowingRoom) { selectUrl = selectUrl + "&room_drawing=" + drowingRoom }
    selectUrl = selectUrl + "&orderBy=room_name"

    fetch(selectUrl)
        .then(response => {
            if (!response.ok) {
                throw Error(response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.state){
                let htmlToDisplay = "<option value='selection'>Sélectionnez une salle</option>"
                let rooms = data.data;
                var dataForCalendar = []
                rooms.forEach((room) => {
                    htmlToDisplay = htmlToDisplay + "<option value='" + room.room_id + "'>" + room.room_name + "</option>"
                    dataForCalendar.push({
                        id : room.room_id,
                        title : room.room_name
                    })
                })
                roomSelector.innerHTML = htmlToDisplay
                document.getElementById("calendar").innerHTML = ""
                displayCalendar(dataForCalendar)
            } else {
                console.log('request error')
            }
        })
        .catch(error => console.log(error));
}

function displayRoom(data){
    data.forEach((room) => {
        console.log(room.room_name);
    })
}
/* ================================------------------ partie filtre ------------------================================ */

/* ================================------------------ partie calendar ------------------================================ */

function setDays() {
    setTimeout(() => {
        let calendar = document.getElementById("calendar")
        let days = document.querySelectorAll(".ec-body .ec-day")
        for (let day of days) {
            day.addEventListener('touchend', () => {
                handleSelectionEnd(day);
            })

            day.addEventListener('mouseup', () => {
                handleSelectionEnd(day);
            })
        }
    }, 500);

    function handleSelectionEnd(day) {
        var timesSelected = document.querySelectorAll(".ec-preview .ec-event-time");
        if (timesSelected.length < 1) { return; }

        // var timeSelected = document.querySelector(".ec-preview .ec-event-time").innerText;
        var arrayTimeSelected = timesSelected[0].innerHTML.split(' - ')
        var startTimeSelected = arrayTimeSelected[0];
        arrayTimeSelected = timesSelected[timesSelected.length-1].innerHTML.split(' - ')
        var endTimeSelected = arrayTimeSelected[1];

        day = timesSelected[0].parentNode.parentNode.parentNode.parentNode;
        let numberOfDay = Array.from(day.parentNode.children).indexOf(day);

        // let numberOfDay = Array.from(day.parentNode.children).indexOf(day)
        let dateSelected = document.querySelector(".ec-header .ec-day:nth-child(" + (numberOfDay + 1) + ") ").innerText
        var arrayDateSelected = dateSelected.split('. ')
        var dateSelectedToSplit = arrayDateSelected[1];
        var arrayDateToConstruct = dateSelectedToSplit.split('/')
        var monthSelected = arrayDateToConstruct[1];
        var daySelected = arrayDateToConstruct[0];
        var finalDateStart = new Date("2023-" + monthSelected + "-" + daySelected + "T" + startTimeSelected + ":00");


        day = timesSelected[timesSelected.length-1].parentNode.parentNode.parentNode.parentNode;
        numberOfDay = Array.from(day.parentNode.children).indexOf(day);

        dateSelected = document.querySelector(".ec-header .ec-day:nth-child(" + (numberOfDay + 1) + ") ").innerText
        arrayDateSelected = dateSelected.split('. ')
        dateSelectedToSplit = arrayDateSelected[1];
        arrayDateToConstruct = dateSelectedToSplit.split('/')
        monthSelected = arrayDateToConstruct[1];
        daySelected = arrayDateToConstruct[0];
        var finalDateEnd = new Date("2023-" + monthSelected + "-" + daySelected + "T" + endTimeSelected + ":00");

        var stringStartDate = daySelected + "-" + monthSelected + "-2023 à " + startTimeSelected
        var stringEndDate = daySelected + "-" + monthSelected + "-2023 à " + endTimeSelected

        // console.log(finalDateStart + " -|- " + finalDateEnd)
        /*addDateInInput(stringStartDate, stringEndDate, finalDateStart, finalDateEnd);*/

        handleSlotEnd(finalDateStart, finalDateEnd);
    }
}

setDays()

/* ================================------------------ partie calendar ------------------================================ */

/* ================================------------------ partie envoie ------------------================================ */
let nameUser = document.getElementById("nom")
let selectRoom = document.getElementById("room")
let form = document.getElementById("form")
let boutonsubmit = document.getElementById("boutonsubmit")
let divMsgError = document.getElementById("content-error")
let msgError = document.getElementById("errorMsg")


boutonsubmit.addEventListener('click', () => {
    if (
        nameUser.value === null ||
        nameUser.value === "" ||
        selectRoom.value === "selection" ||
        datedebut.value === "Selectionnez sur le calendrier (maintenir pour une selection sur mobile)" ||
        datefin.value === "Selectionnez sur le calendrier (maintenir pour une selection sur mobile)"
    ) {
        setTimeout(() => {
            divMsgError.style.top = '-30%'
        }, 5000);
        if (selectRoom.value === "selection"){
            window.scroll(0, valScroll)
            msgError.innerText = "Veuillez choisir une salle"
            selectRoom.style.backgroundColor = "var(--red-clear)"
            selectRoom.style.color = "var(--white)"
            setTimeout(() => {
                selectRoom.style.backgroundColor = "var(--white)"
                selectRoom.style.color = "var(--black)"
            }, 10000);
        } else if (datedebut.value === "Selectionnez sur le calendrier (maintenir pour une selection sur mobile)") {
            window.scroll(0, valScroll)
            msgError.innerText = "Veuillez selectionner une zone de réservation"
        } else if (nameUser.value === null || nameUser.value === "") {
            window.scroll(0, valScroll)
            msgError.innerText = "Vos nom et prénom ne sont pas reconnus, veuillez contacter le support"
        }
        divMsgError.style.top = '-0px'
        return false
    } else {
        console.log("bbbbbbbbbbbbbbbbbbbh")
        form.submit()
    }
})



/* ================================------------------ partie envoie ------------------================================ */
let cur_selection = { in: false, s: null, e: null };

function updateTimeSlot(start, end) {
    if (start.getDate() == end.getDate()) {
        return { start: start, end: end };
    }

    let s, e;
    // console.log(cur_selection, start, end)
    if (cur_selection.s.getDate() == start.getDate()) {
        s = new Date(end);
        s.setHours(8,0,0,0);
        e = new Date(end);
    } else if (cur_selection.e.getDate() == end.getDate()) {
        s = new Date(start);
        e = new Date(start);
        e.setHours(18,30, 0,0);
    }

    return { start: s, end: e };
}

function checkSlotUpdate(infos) {
    if (infos.event.id == '{select}') {
        if (!cur_selection.in) {
            cur_selection = { in: true, s: new Date(infos.event.start), e: new Date(infos.event.end) }
        } else {
            let cur_sel = updateTimeSlot(new Date(infos.event.start), new Date(infos.event.end));
            updateCSS(cur_sel);
            updateForm(cur_sel);
        }
    } else {
        cur_selection.in = false;
    }
}

function handleSlotEnd(startDate, endDate) {
    let cur_sel = updateTimeSlot(startDate, endDate);
    updateCSS(cur_sel);
    updateForm(cur_sel);
}

function updateCSS(sel) {

    let timesSelected = document.querySelectorAll(".ec-preview");
    let day = timesSelected[0].parentNode.parentNode;
    let numberOfDay = Array.from(day.parentNode.children).indexOf(day);
    let dateSelected = document.querySelector(".ec-header .ec-day:nth-child(" + (numberOfDay + 1) + ") ").innerText
    var arrayDateSelected = dateSelected.split('. ')
    var dateSelectedToSplit = arrayDateSelected[1];
    var arrayDateToConstruct = dateSelectedToSplit.split('/')
    var daySelected = arrayDateToConstruct[0];

    timesSelected.forEach((div) => {
        div.classList.remove('hide-preview');
    })

    timesSelected.forEach((div, k) => {
        if (daySelected == sel.start.getDate()) {
            if (k != 0) {
                div.classList.add('hide-preview');
            }
        }
        if (daySelected != sel.start.getDate()) {
            if (k != timesSelected.length -1) {
                div.classList.add('hide-preview');
            }
        }

    })
}

let datedebut = document.getElementById("datedebut");
let datefin = document.getElementById("datefin");
let datedebutRealFormat = document.getElementById("startDateRealFormat");
let datefinRealFormat = document.getElementById("endDateRealFormat");

function updateForm(sel) {
    var startDay = new Date(sel.start).getDate()
    if (startDay < 10) {
        startDay = "0" + startDay
    }
    var startMonth = new Date(sel.start).getMonth() + 1
    if (startMonth < 10) {
        startMonth = "0" + startMonth
    }
    var startYear = new Date(sel.start).getFullYear()
    var startHour = new Date(sel.start).getHours()
    if (startHour < 10) {
        startHour = "0" + startHour
    }
    var startMinute = new Date(sel.start).getMinutes()
    if (startMinute < 10) {
        startMinute = "0" + startMinute
    }
    var endDay = new Date(sel.end).getDate()
    if (endDay < 10) {
        endDay = "0" + endDay
    }
    var endMonth = new Date(sel.end).getMonth() + 1
    if (endMonth < 10) {
        endMonth = "0" + endMonth
    }
    var endYear = new Date(sel.end).getFullYear()
    var endHour = new Date(sel.end).getHours()
    if (endHour < 10) {
        endHour = "0" + endHour
    }
    var endMinute = new Date(sel.end).getMinutes()
    if (endMinute < 10) {
        endMinute = "0" + endMinute
    }
    var startString = startDay + "/" + startMonth + "/" + startYear + " à " + startHour + ":" + startMinute
    var endString = endDay + "/" + endMonth + "/" + endYear + " à " + endHour + ":" + endMinute
    var startRealFormat = startYear + "-" + startMonth + "/" + startDay + " " + startHour + ":" + startMinute + ":00"
    var endRealFormat = endYear + "-" + startMonth + "/" + endDay + " " + endHour + ":" + endMinute + ":00"

    datedebut.value = startString
    datefin.value = endString
    datedebutRealFormat.value = startRealFormat
    datefinRealFormat.value = endRealFormat
}