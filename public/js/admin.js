function addUserEventListeners() {
  let usersTable = document.getElementById("users_table");
  if (usersTable) {
    usersTable.addEventListener("click", function (event) {
      let userId = event.target.getAttribute("user_id");

      if (event.target.classList.contains("promote-btn")) {
        promoteUser(userId);
      } else if (event.target.classList.contains("demote-btn")) {
        demoteUser(userId);
      } else if (event.target.classList.contains("ban-btn")) {
        banUser(userId);
      } else if (event.target.classList.contains("unban-btn")) {
        unbanUser(userId);
      }
    });
  }
}
function addPopupEventListeners() {
  let popup = document.getElementById("pop");
  if (popup) {
    popup.addEventListener("click", function (event) {
      let userId = event.target.getAttribute("user_id");
      if (event.target.classList.contains("disable-btn")) {
        disableUser(userId);
      }
    });
  }
}



function addTransferEventListeners() {
  let transfersTable = document.getElementById("transfers_table");
  if (transfersTable) {
    transfersTable.addEventListener("click", function (event) {
      let transferId = event.target.getAttribute("transfer_id");
      let view = event.target.getAttribute("view");
      if (event.target.classList.contains("approve-btn")) {
        approveTransfer(transferId, view);
      } else if (event.target.classList.contains("reject-btn")) {
        rejectTransfer(transferId, view);
      } 
    });
  }
}



function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data)
    .map(function (k) {
      return encodeURIComponent(k) + "=" + encodeURIComponent(data[k]);
    })
    .join("&");
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader(
    "X-CSRF-TOKEN",
    document.querySelector('meta[name="csrf-token"]').content
  );
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.addEventListener("load", handler);
  request.send(encodeForAjax(data));
}

function UserToSys(userId) {
  let userRow = document.getElementById("user_row_" + userId);

  if (userRow) {
    let index = Array.from(userRow.parentNode.children).indexOf(userRow);

    let disableButton = userRow.querySelector(".popup-btn");
    let promoteButton = userRow.querySelector(".promote-btn");
    let banButton = userRow.querySelector(".ban-btn");
    disableButton.remove();
    promoteButton.remove();
    banButton.remove();

    userRow.id = "user_row_" + userId; 
    let usersTable = document.getElementById("users_table");
    
    usersTable.querySelector("tbody").insertBefore(userRow, usersTable.querySelector("tbody").children[index]);

    let demoteButton = document.createElement("button");
    demoteButton.className = "mx-2 p-2 text-white bg-stone-800 rounded demote-btn";
    demoteButton.type = "button";
    demoteButton.innerText = "Demote";
    demoteButton.setAttribute('user_id', userId);

    let actionsCell = userRow.querySelector(".flex.flex-row");
    actionsCell.appendChild(demoteButton);

    let roleRow = userRow.querySelector("#role");
    if (roleRow) {
      roleRow.innerText = "System Manager";
    }
  } else {
    console.error("User row not found:", userId);
  }
}

function SysToUser(userId) {

  let userRow = document.getElementById("user_row_" + userId);

  if (userRow) {
    let index = Array.from(userRow.parentNode.children).indexOf(userRow);
    let demoteButton = userRow.querySelector(".demote-btn");
    demoteButton.remove();

    userRow.id = "user_row_" + userId; 
    let usersTable = document.getElementById("users_table");
    usersTable.querySelector("tbody").insertBefore(userRow, usersTable.querySelector("tbody").children[index]);

    let disableButton = document.createElement("button");
    disableButton.className = "mx-2 p-2 text-white bg-stone-800 rounded popup-btn";
    disableButton.type = "button";
    disableButton.innerText = "Delete";
    disableButton.setAttribute('user_id', userId);
    disableButton.setAttribute('onclick', 'showDeletePopup('+userId+')');
    let promoteButton = document.createElement("button");
    promoteButton.className = "mx-2 p-2 text-white bg-stone-800 rounded promote-btn";
    promoteButton.type = "button";
    promoteButton.innerText = "Promote";
    promoteButton.setAttribute('user_id', userId);

    let banButton = document.createElement("button");
    banButton.className = "mx-2 p-2 text-white bg-stone-800 rounded ban-btn";
    banButton.type = "button";
    banButton.innerText = "Ban";
    banButton.setAttribute('user_id', userId);

    let actionsCell = userRow.querySelector(".flex.flex-row");
    actionsCell.appendChild(disableButton);
    actionsCell.appendChild(promoteButton);
    actionsCell.appendChild(banButton);

    let roleRow = userRow.querySelector("#role");
    if (roleRow) {
      roleRow.innerText = "User"; 
    }
  } else {
    console.error("User row not found:", userId);
  }
}

function banUserJs(userId) {
  let userRow = document.getElementById("user_row_" + userId);

  if(userRow) {

    let index = Array.from(userRow.parentNode.children).indexOf(userRow);
    let promoteButton = userRow.querySelector(".promote-btn");
    let banButton = userRow.querySelector(".ban-btn");
    promoteButton.remove();
    banButton.remove();
    let usersTable = document.getElementById("users_table");
    usersTable.querySelector("tbody").insertBefore(userRow, usersTable.querySelector("tbody").children[index]);
    let unbanButton = document.createElement("button");
    unbanButton.className = "mx-2 p-2 text-white bg-stone-800 rounded unban-btn";
    unbanButton.type = "button";
    unbanButton.innerText = "Unban";
    unbanButton.setAttribute('user_id', userId);

    let actionsCell = userRow.querySelector(".flex.flex-row");
    actionsCell.appendChild(unbanButton);

  } else {
    console.error("User row not found:", userId);
  }
}

function unbanUserjs(userId) {
  let userRow = document.getElementById("user_row_" + userId);

  if(userRow) {

    let index = Array.from(userRow.parentNode.children).indexOf(userRow);
    let unbanButton = userRow.querySelector(".unban-btn");
    unbanButton.remove();

    let usersTable = document.getElementById("users_table");

    usersTable.querySelector("tbody").insertBefore(userRow, usersTable.querySelector("tbody").children[index]);
    let banButton = document.createElement("button");
    banButton.className = "mx-2 p-2 text-white bg-stone-800 rounded ban-btn";
    banButton.type = "button";
    banButton.innerText = "Ban";
    banButton.setAttribute('user_id', userId);

    let promoteButton = document.createElement("button");
    promoteButton.className = "mx-2 p-2 text-white bg-stone-800 rounded promote-btn";
    promoteButton.type = "button";
    promoteButton.innerText = "Promote";
    promoteButton.setAttribute('user_id', userId);

    let actionsCell = userRow.querySelector(".flex.flex-row");
    actionsCell.appendChild(promoteButton);
    actionsCell.appendChild(banButton);
  
  } else {
    console.error("User row not found:", userId);
  }
}

function removeTransfer(transferId, view) { 
  let transferRow = document.getElementById("transfer_row_" + transferId);
  if(transferRow) {
    transferRow.remove();
  }
  else {
    console.error("Transfer row not found:", transferId);
  }
}

function demoteUser(userId) {
  let formData = { user_id: userId };

  sendAjaxRequest(
    "POST",
    "/admin/users/demote",
    formData,
    SysToUser(userId)
  );
}

function removeUser(userId) {
  let userRow = document.getElementById("user_row_" + userId);

  if (userRow) {
    userRow.remove();
    confirmDelete();
  } else {
    console.error("User row not found:", userId);
  }
}
function confirmDelete() {
  document.getElementById('delete').removeAttribute('user_id');
  document.getElementById('disableUser').classList.add('hidden');
}

function showDeletePopup(userId) {
  userIdToDelete = userId;  
  document.getElementById('disableUser').classList.remove('hidden');
  document.getElementById('delete').setAttribute('user_id', userIdToDelete);
}

function cancelDelete() {

  document.getElementById('disableUser').classList.add('hidden');
}

function disableUser(userId) {
  let formData = { user_id: userId };

  sendAjaxRequest(
    "POST",
    "/admin/users/disable",
    formData,
    removeUser(userId)
  );
  
}

function promoteUser(userId) {
  let formData = { user_id: userId };

  sendAjaxRequest(
    "POST",
    "/admin/users/promote",
    formData,
    UserToSys(userId)
  );
}
function banUser(userId) {
  let formData = { user_id: userId };

  sendAjaxRequest(
    "POST",
    "/admin/users/ban",
    formData,
    banUserJs(userId)
  );
}

function unbanUser(userId) {
  let formData = { user_id: userId };

  sendAjaxRequest(
    "POST",
    "/admin/users/unban",
    formData,
    unbanUserjs(userId)
  );
}

function approveTransfer(transferId, view) {
  let formData = { transfer_id: transferId , view: view};

  sendAjaxRequest(
    "POST",
    "/admin/transfers/approve",
    formData,
    removeTransfer(transferId, view)
  );
}

addUserEventListeners();
addPopupEventListeners();
addTransferEventListeners();
