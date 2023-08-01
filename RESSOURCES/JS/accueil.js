setTimeout(() => {
    let calendarSelectZone = document.querySelector("#calendar > .ec > .ec-body")

    /*calendarSelectZone.addEventListener('mouseup', (ev) => {

        console.log('')
        console.log(ev.currentTarget)
    })*/

    let days = document.querySelectorAll(".ec-body .ec-day")
    for (let day of days){
        day.addEventListener('mouseup', () => {
            console.log(day)

            var selectedZone = document.querySelector(".ec-preview");
            var timeSelected = document.querySelector(".ec-preview .ec-event-time").innerText;
            var arrayTimeSelected = timeSelected.split(' - ')
            var startTimeSelected = arrayTimeSelected[0];
            var endTimeSelected = arrayTimeSelected[1];

            console.log("zone selectionné");
            console.log(selectedZone);
            console.log("heures selectionnée",timeSelected);
            console.log("tableau heure selectionné");
            console.log(arrayTimeSelected)
            console.log("debut heure selection", startTimeSelected)
            console.log("fin heure selection", endTimeSelected)

            let test = Array.from(day.parentNode.children).indexOf(day)
            console.log("jour numero : ", test)
            console.log(".ec-header .ec-days:nth-child(" + test + ") ")
            let data = document.querySelector(".ec-header .ec-day:nth-child(" + (test + 1) + ") ").innerText
            console.log(data)
        })
    }


}, 500);
