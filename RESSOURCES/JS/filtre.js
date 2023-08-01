var selectTypeRoom = document.getElementById('room');
selectElementRoom.addEventListener('change', filtreChange);

function filtreChange() {
    const rooms = document.querySelectorAll('[class*=room-]');
    for (room of rooms) {
    room.classList.add('hidden');
}

var selectElementRoomValue = document.getElementById('room').value;

if (selectElementRoomValue == '*') {
    for (room of rooms) {
    room.classList.remove('hidden');
}
}

else {
    let elts=document.querySelectorAll("." + selectElementRoomValue);
    for (let elt of elts) {
    elt.classList.remove('hidden');
}
}
}