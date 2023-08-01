// Gestion des réservations
const resetContainer = (containerId) => {
  var container = document.getElementsByClassName(`${containerId}-data`);

  while (container[0]) {
    container[0].parentNode.removeChild(container[0]);
  }
};

const insertData = (data, type) => {
  if (type == "requests") {
    let amount = document.getElementById("requestAmount");
    resetContainer("request");
    if (!data.length) {
      amount.innerHTML = 0;
    } else {
      amount.innerHTML = data.length;
      let table = document.getElementById("request-body");
      data.forEach((element) => {
        table.insertAdjacentHTML(
          "beforeend",
          "<div class='request-data data'>"
        );
        let container = document.querySelector(".request-data:last-child");
        container.insertAdjacentHTML(
          "beforeend",
          "<span>" + element.reservation_id + "</span>"
        );
        container.insertAdjacentHTML(
          "beforeend",
          "<span>" + element.user_login + "</span>"
        );
        container.insertAdjacentHTML(
          "beforeend",
          "<span>" + element.reservation_dateStart + "</span>"
        );
        container.insertAdjacentHTML(
          "beforeend",
          "<span>" + element.reservation_dateEnd + "</span>"
        );
        container.insertAdjacentHTML(
          "beforeend",
          "<span>" + element.room_id + "</span>"
        );
        if (element.reservation_isAccepted == 1) {
          container.insertAdjacentHTML(
            "beforeend",
            "<span>Demande acceptée</span>"
          );
          container.insertAdjacentHTML(
            "beforeend",
            `<span><button class="${element.reservation_id} manage" onclick="manageRequest(2,${element.reservation_id})">Annuler la reservation</button></span>`
          );
        } else if (element.reservation_isAccepted == 2) {
          container.insertAdjacentHTML(
            "beforeend",
            "<span>Demande refusée</span>"
          );
          container.insertAdjacentHTML(
            "beforeend",
            `<span><button class='${element.reservation_id} manage' onclick="removeRequest(${element.reservation_id})">Supprimer</button>`
          );
        } else {
          container.insertAdjacentHTML("beforeend", "<span>En attente</span>");
          container.insertAdjacentHTML(
            "beforeend",
            `<span><button class='accept ${element.reservation_id} manage' onclick="manageRequest(1,${element.reservation_id})">Accepter</button>
            <button class="${element.reservation_id} manage" onclick="manageRequest(2,${element.reservation_id})">Refuser</button></span>`
          );
        }
      });
    }
  } else {
    let amount = document.getElementById("supportAmount");
    resetContainer("support");
    if (!data.length) {
      amount.innerHTML = 0;
    } else {
      amount.innerHTML = data.length;
      let table = document.getElementById("support-body");
      data.forEach((element) => {
        table.insertAdjacentHTML(
          "beforeend",
          "<div class='support-data data'>"
        );
        let container = document.querySelector(".support-data:last-child");
        container.insertAdjacentHTML(
          "beforeend",
          "<span>" + element.message_id + "</span>"
        );
        container.insertAdjacentHTML(
          "beforeend",
          "<span>" + element.message_email + "</span>"
        );
        element.message_subject = element.message_subject.length
          ? element.message_subject.replace(/(.{40})/g, "$1\n")
          : null;
        container.insertAdjacentHTML(
          "beforeend",
          "<span class='subject'>" + element.message_subject + "</span>"
        );
        element.message_message = element.message_message.length
          ? element.message_message.replace(/(.{40})/g, "$1\n")
          : null;
        container.insertAdjacentHTML(
          "beforeend",
          "<span class='message'>" + element.message_message + "</span>"
        );
      });
    }
  }
};

const getTable = async (type) => {
  if (type === "reservation") {
    try {
      const datas = ["select", "reservation"];
      const response = await fetch(
        `../ACTIONS/API.php?action=${datas[0]}&table=${datas[1]}`,
        {
          method: "GET",
        }
      );
      const data = await response.json();
      insertData(data.data, "requests");
    } catch (e) {
      console.log(e);
    }
  } else {
    try {
      const datas = ["select", "message"];
      const response = await fetch(
        `../ACTIONS/API.php?action=${datas[0]}&table=${datas[1]}`,
        {
          method: "GET",
        }
      );
      const data = await response.json();

      insertData(data.data, "support");
    } catch (e) {
      console.log(e);
    }
  }
  managers = document.querySelectorAll(".manage");
};

const manageRequest = async (status, id) => {
  try {
    const args = ["reservation", status, id];
    const datas = ["update", args];

    const response = await fetch(
      `../ACTIONS/API.php?action=${datas[0]}&table=${datas[1][0]}&reservation_isAccepted=${datas[1][1]}&reservation_id=${datas[1][2]}`,

      {
        method: "GET",
      }
    );
    const data = await response.json();
    getTable(args[0]);
  } catch (e) {
    console.log(e);
  }
};

const removeRequest = async (id) => {
  try {
    const args = ["reservation", id];
    const datas = ["delete", args];

    const response = await fetch(
      `../ACTIONS/API.php?action=${datas[0]}&table=${datas[1][0]}&reservation_id=${datas[1][1]}`,
      {
        method: "PUT",
      }
    );
    getTable(args[0]);
  } catch (e) {
    console.log(e);
  }
};

document.querySelectorAll(".refresh").forEach((but) => {
  but.addEventListener("click", (evt) => {
    if (but.id == "message") {
      getTable(but.id);
    } else {
      getTable(but.id);
    }
  });
});

// Navigation

/* ================================------------------ partie navigation ------------------================================ */
let btnManager = document.getElementById("btnManager");
let btnRequest = document.getElementById("btnRequest");
let btnSupport = document.getElementById("btnSupport");
let booking = document.getElementById("booking");
let request = document.getElementById("request");
let support = document.getElementById("support");

btnManager.addEventListener("click", () => {
  booking.style.display = "flex";
  request.style.display = "none";
  support.style.display = "none";
  btnManager.classList.add("active");
  btnRequest.classList.remove("active");
  btnSupport.classList.remove("active");
});

btnRequest.addEventListener("click", () => {
  request.style.display = "flex";
  booking.style.display = "none";
  support.style.display = "none";
  btnManager.classList.remove("active");
  btnRequest.classList.add("active");
  btnSupport.classList.remove("active");
});

btnSupport.addEventListener("click", () => {
  support.style.display = "flex";
  booking.style.display = "none";
  request.style.display = "none";
  btnManager.classList.remove("active");
  btnRequest.classList.remove("active");
  btnSupport.classList.add("active");
});

window.onload = () => {
  getTable("reservation");
  getTable("message");
  booking.style.display = "none";
  request.style.display = "flex";
  support.style.display = "none";
};
