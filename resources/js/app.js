import Swal from 'sweetalert2'

function addUserEventListeners() {
  let usersTable = document.getElementById("users_table");
  if (usersTable) {
    usersTable.addEventListener("click", function (event) {
      let userId = event.target.getAttribute("user_id");
      let userName = event.target.getAttribute("user_name");
      let role= event.target.getAttribute("role");
      if (event.target.classList.contains("promote-btn")) {
        promoteUser(userId,role);
      } else if (event.target.classList.contains("demote-btn")) {
        demoteUser(userId,role);
      } else if (event.target.classList.contains("ban-btn")) {
        banUser(userId);
      } else if (event.target.classList.contains("unban-btn")) {
        unbanUser(userId);
      } else if (event.target.classList.contains("popup-btn")) {
        showDeletePopup(userId, userName);
      } else if (event.target.classList.contains("edit-btn")) { 
        editUser(userId);
      }
    });
  }
}

function addTransferEventListeners() {
  let transfersTable = document.getElementById("transfers_table");
  if (transfersTable) {
    transfersTable.addEventListener("click", function (event) {
      let transferId = event.target.getAttribute("transfer_id");
      if (event.target.classList.contains("approve-btn")) {
        approveTransfer(transferId);
      } else if (event.target.classList.contains("reject-btn")) {
        rejectTransfer(transferId);
      }  
    });
  }
}

function addAuctionEventListeners() {
  let auctionsTable = document.getElementById("auctions_table");
  if (auctionsTable) {
    auctionsTable.addEventListener("click", function (event) {
      let auctionId = event.target.getAttribute("auction_id");
      if (event.target.classList.contains("resume-btn")) {
        resumeAuction(auctionId);
      } else if (event.target.classList.contains("pause-btn")) { 
        pauseAuction(auctionId);
      } else if (event.target.classList.contains("approve-btn")) { 
        approveAuction(auctionId);
      } else if (event.target.classList.contains("reject-btn")) { 
        rejectAuction(auctionId);
      }
    });
  }
}

function addReportEventListeners() {
  let reportTable = document.getElementById("report_table");
  if(reportTable) {
    reportTable.addEventListener("click",function (event) {
      let reportId = [event.target.getAttribute("user_id"),event.target.getAttribute("auction_id")];
      if (event.target.classList.contains("relevant-btn")){
        relevantReport(reportId);
      } else if (event.target.classList.contains("irrelevant-btn")){
        irrelevantReport(reportId);
      }
    });
  }
}

function addFollowEventListeners() {
  let followIcon = document.getElementById("follow_icon");
  if (followIcon) {
    followIcon.addEventListener("click", function (event) {
      let auctionId = this.getAttribute("data-auction-id");
      let userId = this.getAttribute("data-user-id");
      let action = this.getAttribute("data-action");
      if(action === "follow") {
        console.log("Gonna follow");
        followAuction(userId, auctionId);
      } else if (action === "unfollow") {
        console.log("Gonna unfollow");
        unfollowAuction(userId, auctionId);
      }
    });
  }
}

function addProfileEventListeners() {
  let deleteButton = document.getElementById("delete_profile");
  if (deleteButton) {
    deleteButton.addEventListener("click", function (event) {
      let userId = event.target.getAttribute("user_id");
      let balance = event.target.getAttribute("balance");
      if(event.target.classList.contains("delete-profile-btn")){
        deleteProfile(userId,balance);
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

function UserToSys(userId, role) {
  let userRow = document.getElementById("user_row_" + userId);

  if (userRow) {
    let index = Array.from(userRow.parentNode.children).indexOf(userRow);;
    if(role == true) {
    let editButton = userRow.querySelector(".edit-btn");
    editButton.remove();
    let disableButton = userRow.querySelector(".popup-btn");
    disableButton.remove();
    }
    let promoteButton = userRow.querySelector(".promote-btn");
    let banButton = userRow.querySelector(".ban-btn");
    promoteButton.remove();
    banButton.remove();

    userRow.id = "user_row_" + userId; 
    let usersTable = document.getElementById("users_table");
    
    usersTable.querySelector("tbody").insertBefore(userRow, usersTable.querySelector("tbody").children[index]);

    let demoteButton = document.createElement("button");
    demoteButton.className = "m-2 py-1 px-2 text-white bg-stone-800 rounded demote-btn";
    demoteButton.type = "button";
    demoteButton.innerText = "Demote";
    demoteButton.setAttribute('user_id', userId);
    demoteButton.setAttribute('role', role);

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

function SysToUser(userId,role) {

  let userRow = document.getElementById("user_row_" + userId);
  if (userRow) {
    let index = Array.from(userRow.parentNode.children).indexOf(userRow);
    let demoteButton = userRow.querySelector(".demote-btn");
    demoteButton.remove();
    userRow.id = "user_row_" + userId; 
    let usersTable = document.getElementById("users_table");
    usersTable.querySelector("tbody").insertBefore(userRow, usersTable.querySelector("tbody").children[index]);
    let actionsCell = userRow.querySelector(".flex.flex-row");
    if(role == true) {
    let editButton = document.createElement("button");
    editButton.className = "m-2 py-1 px-2 text-white bg-stone-800 rounded edit-btn";
    editButton.type = "button";
    editButton.innerText = "Edit";
    editButton.setAttribute('user_id', userId);
    actionsCell.appendChild(editButton);
    let disableButton = document.createElement("button");
    disableButton.className = "m-2 py-1 px-2 text-white bg-stone-800 rounded popup-btn";
    disableButton.type = "button";
    disableButton.innerText = "Delete";
    disableButton.setAttribute('user_id', userId);
    disableButton.setAttribute('onclick', 'showDeletePopup('+userId+')');
    actionsCell.appendChild(disableButton);
    }
    let promoteButton = document.createElement("button");
    promoteButton.className = "m-2 py-1 px-2 text-white bg-stone-800 rounded promote-btn";
    promoteButton.type = "button";
    promoteButton.innerText = "Promote";
    promoteButton.setAttribute('user_id', userId);
    promoteButton.setAttribute('role', role);

    let banButton = document.createElement("button");
    banButton.className = "m-2 py-1 px-2 text-white bg-stone-800 rounded ban-btn";
    banButton.type = "button";
    banButton.innerText = "Ban";
    banButton.setAttribute('user_id', userId);

    
    
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
    unbanButton.className = "m-2 py-1 px-2 text-white bg-stone-800 rounded unban-btn";
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
    banButton.className = "m-2 py-1 px-2 text-white bg-stone-800 rounded ban-btn";
    banButton.type = "button";
    banButton.innerText = "Ban";
    banButton.setAttribute('user_id', userId);

    let promoteButton = document.createElement("button");
    promoteButton.className = "m-2 py-1 px-2 text-white bg-stone-800 rounded promote-btn";
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

function removeTransfer(transferId) { 
  let transferRow = document.getElementById("transfer_row_" + transferId);
  if(transferRow) {
    transferRow.remove();
  }
  else {
    console.error("Transfer row not found:", transferId);
  }
}

function removeUser(userId) {
  let userRow = document.getElementById("user_row_" + userId);

  if (userRow) {
    userRow.remove();
  } else {
    console.error("User row not found:", userId);
  }
}

function showDeletePopup(userId, userName) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to recover " + userName + " account!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#FF0000",
    cancelButtonColor: "#0000FF",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      disableUser(userId);
    }
  });
}

function pauseAuctionJs(auctionId) {
  let auctionRow = document.getElementById("auction_row_" + auctionId);
  if(auctionRow) { 
    let index = Array.from(auctionRow.parentNode.children).indexOf(auctionRow);
    let pauseButton = auctionRow.querySelector(".pause-btn");
    pauseButton.remove();
    let auctionsTable = document.getElementById("auctions_table");
    auctionsTable.querySelector("tbody").insertBefore(auctionRow, auctionsTable.querySelector("tbody").children[index]);
    let resumeButton = document.createElement("button");
    resumeButton.className = "m-2 py-1 px-2 text-white bg-stone-800 rounded resume-btn";
    resumeButton.type = "button";
    resumeButton.innerText = "Resume";
    resumeButton.setAttribute('auction_id', auctionId);
    let actionsCell = auctionRow.querySelector(".flex.flex-row");
    actionsCell.appendChild(resumeButton);

    let state = auctionRow.querySelector("#state");
    if(state) {
      state.innerText = "paused";
    } else {
      console.error("Auction state not found:", auctionId);
    }
  } else {
    console.error("Auction row not found:", auctionId);
  }
}

function resAuction(auctionId) {
  let auctionRow = document.getElementById("auction_row_" + auctionId);
  if(auctionRow) {
    let index = Array.from(auctionRow.parentNode.children).indexOf(auctionRow);
    let resumeButton = auctionRow.querySelector(".resume-btn");
    resumeButton.remove();
    let auctionsTable = document.getElementById("auctions_table");
    auctionsTable.querySelector("tbody").insertBefore(auctionRow, auctionsTable.querySelector("tbody").children[index]);
    let pauseButton = document.createElement("button");
    pauseButton.className = "m-2 py-1 px-2 text-white bg-stone-800 rounded pause-btn";
    pauseButton.type = "button";
    pauseButton.innerText = "Pause";
    pauseButton.setAttribute('auction_id', auctionId);
    let actionsCell = auctionRow.querySelector(".flex.flex-row");
    actionsCell.appendChild(pauseButton);

    let state = auctionRow.querySelector("#state");
    if(state) {
      state.innerText = "active";
    } else {
      console.error("Auction state not found:", auctionId);
    }
  } else {
    console.error("Auction row not found:", auctionId);
  }
}

function appAuction(auctionId) {
  let auctionRow = document.getElementById("auction_row_" + auctionId);
  if(auctionRow) {
    auctionRow.remove();
  } else {
    console.error("Auction row not found:", auctionId);
  }
}

function rejAuction(auctionId) { 
  let auctionRow = document.getElementById("auction_row_" + auctionId);
  if(auctionRow) {
    auctionRow.remove();
  } else {
    console.error("Auction row not found:", auctionId);
  }
}

function removeReport(reportId) {
  let reportRow = document.getElementById("report_row_" + reportId[0] + "_" + reportId[1]);
  if(reportRow) {
    reportRow.remove();
  } else {
    console.error("Report row not found:", reportId);
  }
}

function fillHeart() {
  var heartIcon = document.getElementById("follow_icon");

  if (heartIcon) {
    heartIcon.src = "/images/icons/full_heart.png";
    heartIcon.alt = "Full Heart Icon";
    heartIcon.dataset.action = "unfollow";
  }
}

function emptyHeart() {
  var heartIcon = document.getElementById("follow_icon");

  if (heartIcon) {
    heartIcon.src = "/images/icons/empty_heart.png";
    heartIcon.alt = "Empty Heart Icon";
    heartIcon.dataset.action = "follow";
  }
}

function demoteUser(userId,role) {
  let formData = { user_id: userId };

  sendAjaxRequest(
    "POST",
    "/admin/users/demote",
    formData,
    SysToUser(userId,role)
  );
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

function promoteUser(userId,role) {
  let formData = { user_id: userId };

  sendAjaxRequest(
    "POST",
    "/admin/users/promote",
    formData,
    UserToSys(userId,role)
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

function approveTransfer(transferId) {
  let formData = { transfer_id: transferId};

  sendAjaxRequest(
    "POST",
    "/admin/transfers/approve",
    formData,
    removeTransfer(transferId)
  );
}

function rejectTransfer(transferId) {
  let formData = { transfer_id: transferId};

  sendAjaxRequest(
    "POST",
    "/admin/transfers/reject",
    formData,
    removeTransfer(transferId)
  );
}

function resumeAuction(auctionId) {
  let formData = { auction_id: auctionId };

  sendAjaxRequest(
    "POST",
    "/admin/auctions/resume",
    formData,
    resAuction(auctionId)
  );
}

function pauseAuction(auctionId) {
  let formData = { auction_id: auctionId };

  sendAjaxRequest(
    "POST",
    "/admin/auctions/pause",
    formData,
    pauseAuctionJs(auctionId)
  );
}

function approveAuction(auctionId) {
  let formData = { auction_id: auctionId };

  sendAjaxRequest(
    "POST",
    "/admin/auctions/approve",
    formData,
    appAuction(auctionId)
  );
}

function rejectAuction(auctionId) {
  let formData = { auction_id: auctionId };

  sendAjaxRequest(
    "POST",
    "/admin/auctions/reject",
    formData,
    rejAuction(auctionId)
  );
}

function relevantReport(reportId) {
  let formData = { user_id: reportId[0], auction_id: reportId[1] , state: 'reviewed'};

  sendAjaxRequest(
    "POST",
    "/admin/reports/update",
    formData,
    removeReport(reportId)
  );
}

function irrelevantReport(reportId) {
  let formData = { user_id: reportId[0], auction_id: reportId[1] , state: 'unrelated'};

  sendAjaxRequest(
    "POST",
    "/admin/reports/update",
    formData,
    removeReport(reportId)
  );
}

function followAuction(userId, auctionId) {
  console.log("User ID:", userId);
  console.log("Auction ID:", auctionId);

  let formData = { user_id: userId, auction_id: auctionId };

  sendAjaxRequest("POST", "/auction/follow", formData, function (response) {
    fillHeart();
  });
}

function unfollowAuction(userId, auctionId) {
  console.log("User ID:", userId);
  console.log("Auction ID:", auctionId);

  let formData = { user_id: userId, auction_id: auctionId };

  sendAjaxRequest("POST", "/auction/unfollow", formData, function (response) {
    emptyHeart();
  });
}

function deleteProfile(userId,balance) {
  console.log("User ID:", userId);
  console.log("Balance:", balance);

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to recover your account! Your balance will NOT be refunded.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#FF0000",
    cancelButtonColor: "#000000",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      let formData = { user_id: userId };
      sendAjaxRequest(
        "POST", 
        "/profile/delete",
        formData
      );
      window.location.href = "/logout"
    }
  });
 }




async function editUser(userId) {
  const response = await fetch(`/admin/users/${userId}`, {
      method: 'GET', 
  });
  if(response.status !== 200) {
      console.error("Error fetching user info");
      return;
  }
  const userInfo = await response.json();
  showEditProfilePopup(userInfo);
}


async function showEditProfilePopup(userInfo) {
  const user = userInfo[0];
  const { value: formValues } = await Swal.fire({
      title: 'Edit Profile',
      html:`<label for="new_username">Username:</label> <br>
            <input id="new_username" class="swal2-input m-2" value="${user.username}"> <br>
            <label for="new_name">Name:</label> <br>
            <input id="new_name" class="swal2-input m-2" value="${user.name}"> <br>
            <label for="new_email">Email:</label> <br>
            <input id="new_email" class="swal2-input" value="${user.email}"> <br>
            <label for="new_password">Password:</label> <br>
            <input id="new_password" class="swal2-input m-2" value=""> <br>

            <label for="confirm_password">Confirm Password:</label> <br>
            <input id="confirm_password" class="swal2-input m-2" value="">`, 


      focusConfirm: false,
      showCancelButton: true,
      confirmButtonText: 'Save',
      cancelButtonText: 'Cancel',
      confirmButtonColor: "#0000FF",
      cancelButtonColor: "#FF0000",
      preConfirm: () => {
        if(document.getElementById('new_name') === user.name && document.getElementById('new_username') === user.username && document.getElementById('new_email') === user.email && document.getElementById('new_password') === "") {
          Swal.showValidationMessage('No changes were made');
        }
        if(document.getElementById('new_password').value !== document.getElementById('confirm_password').value) {
          Swal.showValidationMessage('Passwords do not match');
        } 
        else if(document.getElementById('new_password').value.length < 8 && document.getElementById('new_password').value != "") {
          Swal.showValidationMessage('Password must have at least 8 characters');
        }
        else if(document.getElementById('new_username').value === "" || document.getElementById('new_name').value === "" || document.getElementById('new_email').value === "") {
          Swal.showValidationMessage('Username, Name and Email are required');
        }
        else return {
              username: document.getElementById('new_username').value,
              name: document.getElementById('new_name').value,
              email: document.getElementById('new_email').value,
              password: document.getElementById('new_password').value,
          };
      }
  });
  console.log("Form Values:", formValues);

  if (formValues && user && user.id) {
    if (formValues.password === "") {
      formValues.password = null; // or delete formValues.password;
    }
    formValues.user_id = user.id;
    console.log("Updated Form Values:", formValues);
  
    sendAjaxRequest(
      "POST", 
      `/admin/users/${formValues.user_id}/update`, 
      formValues, 
      updateUserRow(formValues)
    );
  }
  
}

function updateUserRow(res) {
  const user = res;
  const userRow = document.getElementById("user_row_" + user.user_id);

  if (!userRow) {
    console.error("User row not found for ID: " + user.user_id);
    return;
  }

  const index = Array.from(userRow.parentNode.children).indexOf(userRow);
  const usersTable = document.getElementById("users_table");

  if (!usersTable || !usersTable.querySelector("tbody")) {
    console.error("Users table or tbody not found");
    return;
  }

  usersTable.querySelector("tbody").insertBefore(userRow, usersTable.querySelector("tbody").children[index]);

  const username = userRow.querySelector(".username");
  const name = userRow.querySelector(".name");
  const email = userRow.querySelector(".email");

  if (username) {
    username.innerText = user.username;
  }

  if (name) {
    name.innerText = user.name;
  }

  if (email) {
    email.innerText = user.email;
  }

  Swal.fire({
    icon: 'success',
    title: user.name + ' updated successfully',
    showConfirmButton: false,
    timer: 1500
  });
}



addUserEventListeners();
addTransferEventListeners();
addAuctionEventListeners();
addReportEventListeners();
addFollowEventListeners();
addProfileEventListeners();
