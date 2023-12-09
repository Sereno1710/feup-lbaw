function addEventListeners() {
  let usersTable = document.getElementById("users_table");
  if (usersTable) {
    usersTable.addEventListener("click", function (event) {
      let userId = event.target.getAttribute("user_id");

      if (event.target.classList.contains("promote-btn")) {
        promoteUser(userId);
      } else if (event.target.classList.contains("disable-btn")) {
        disableUser(userId);
      } else if (event.target.classList.contains("demote-btn")) {
        demoteUser(userId);
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

function UserToAdmin(userId) {
  let userRow = document.getElementById("user_row_" + userId);

  if (userRow) {
    let index = Array.from(userRow.parentNode.children).indexOf(userRow);

    let disableButton = userRow.querySelector(".disable-btn");
    let promoteButton = userRow.querySelector(".promote-btn");
    disableButton.remove();
    promoteButton.remove();

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
      roleRow.innerText = "Admin";
    }
  } else {
    console.error("User row not found:", userId);
  }
}

function AdminToUser(userId) {

  let adminRow = document.getElementById("user_row_" + userId);

  if (adminRow) {
    let index = Array.from(adminRow.parentNode.children).indexOf(adminRow);
    let demoteButton = adminRow.querySelector(".demote-btn");
    demoteButton.remove();

    adminRow.id = "user_row_" + userId; 
    let usersTable = document.getElementById("users_table");
    usersTable.querySelector("tbody").insertBefore(adminRow, usersTable.querySelector("tbody").children[index]);
    let disableButton = document.createElement("button");
    disableButton.className = "mx-2 p-2 text-white bg-stone-800 rounded disable-btn";
    disableButton.type = "button";
    disableButton.innerText = "Disable";
    disableButton.setAttribute('user_id', userId);

    let promoteButton = document.createElement("button");
    promoteButton.className = "mx-2 p-2 text-white bg-stone-800 rounded promote-btn";
    promoteButton.type = "button";
    promoteButton.innerText = "Promote";
    promoteButton.setAttribute('user_id', userId);

    let actionsCell = adminRow.querySelector(".flex.flex-row");
    actionsCell.appendChild(disableButton);
    actionsCell.appendChild(promoteButton);

    let roleRow = adminRow.querySelector("#role");
    if (roleRow) {
      roleRow.innerText = "User"; 
    }
  } else {
    console.error("User row not found:", userId);
  }
}

function demoteUser(userId) {
  let formData = { user_id: userId };

  sendAjaxRequest("POST", "/admin/users/demote", formData, function (response) {
    AdminToUser(userId);
  });
}

function removeUser(userId) {
  let userRow = document.getElementById("user_row_" + userId);

  if (userRow) {
    userRow.remove();
  } else {
    console.error("User row not found:", userId);
  }
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
    UserToAdmin(userId)
  );
}

addEventListeners();
