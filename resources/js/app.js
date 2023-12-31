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

function addAuctionBidEventListeners(){
  let auctionBidTable = document.getElementById("BidsPopUp");
  if(auctionBidTable) {
    auctionBidTable.addEventListener("click", function (event) {
      let auctionId = event.target.getAttribute("auction_id");
      if (event.target.classList.contains("bids-history-btn")){
        openBids(auctionId);
      }
    });
  }

}

function addAuctionReportEventListener(){
  let auctionReportTable = document.getElementById("icons");
  if(auctionReportTable) {
    auctionReportTable.addEventListener("click", function (event) {
      let auctionId = event.target.getAttribute("auction_id");
      let userId = event.target.getAttribute("user_id");
      if (event.target.classList.contains("report_icon")){
        openReports(auctionId,userId);
      }
    });
  }

}

function addNotificationsEventListeners() {
  let notifications = document.getElementById("notifications");
  if (notifications) {
    notifications.addEventListener("click", function (event) {
      if (event.target.classList.contains("btn-viewall")) {
        readAllNotification();
      }
      else if (event.target.classList.contains("btn-deleteall")) { 
        deleteAllNotification();
      } 
    });
  }
}

function addNotificationEventListener(){
  let notification = document.getElementById("notification-ul");
  if(notification) {
    notification.addEventListener("click", function (event) {
      let notificationId = event.target.getAttribute("notification_id");
      if (event.target.classList.contains("btn-view")){
        viewNotification(notificationId);
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
    if(role) {
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
    let actionsCell = auctionRow.querySelector(".btn");
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
  if (auctionRow) {
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

    let actionsCell = auctionRow.querySelector(".btn");

    if (actionsCell) {
      actionsCell.appendChild(pauseButton);
      let state = auctionRow.querySelector("#state");
      if (state) {
        state.innerText = "active";
      } else {
        console.error("Auction state not found:", auctionId);
      }
    } else {
      console.error("actionsCell not found:", auctionId);
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
      formValues.password = null; 
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

async function openBids(id) {
  const response = await fetch(`/auction/${id}/bids`, {
    method: 'GET', 
  });
  if (response.status !== 200) {
    console.error("Error fetching bidding history");
    return;
  }
  const bidsInfo = await response.json();
  openBidsPopup(bidsInfo);
}


async function openBidsPopup(bidsInfo) {
  console.log("Bids Info:", bidsInfo);
  const fetchProfileImagePath = async (userId) => {
    const response = await fetch(`/profile/${userId}/image`);
    const data = await response.json();
    return data.path; 
  };
  const fetchUserName= async (userId) => {
    const response = await fetch(`/profile/${userId}/name`);
    const data = await response.json();
    return data.name; 
  }
  const bidsHTML = await Promise.all(bidsInfo.map(async bid => {
  const profileImagePath = await fetchProfileImagePath(bid.user_id);
  const name = await fetchUserName(bid.user_id);
    return `
      <div class="w-full my-1 p-4 flex flex-row items-center bg-stone-100 rounded-lg shadow-sm">
          <a class="w-[4rem] h-[3rem] mr-1" href="/user/${bid.user_id}">
              <img class="w-[3rem] h-[3rem] rounded-full object-cover" src="${profileImagePath}">
          </a>
          <div class="w-full flex flex-col items-start">
            <div class="w-full flex flex-row justify-between items-center">
              <a href="/user/${bid.user_id}" class="font-bold text-lg">${name}</a>
              <span class="text-stone-500 text-sm">${bid.time}</span>
            </div>
            <p class="text-stone-800 text-sm">Bidded ${bid.amount}</p>
          </div>
      </div>
    `;
  }));

  Swal.fire({
    title: 'Bidding History',
    html: `<div class="w-full px-2 flex flex-col max-h-[42vh] overflow-y-auto items-center">${bidsHTML.join('')}</div>`,
    showCloseButton: true,
    showConfirmButton: false,
    customClass: {
      container: 'bids-popup-container',
    },
  });
}

async function openReports(auction_id,user_id) {
  console.log("Auction ID:", auction_id);
  console.log("User ID:", user_id);
  const { value: text } = await Swal.fire({
    title: "Report",
    text: "Please describe the issue you found",
    input: "textarea",
    inputPlaceholder: "Type your message here...",
    inputAttributes: {
      "aria-label": "Type your message here"
    },
    showCancelButton: true,
    showConfirmButton: true,
    confirmButtonText: "Report",
    cancelButtonText: "Cancel",
    confirmButtonColor: "#FF0000",
    cancelButtonColor: "#000000",
    preConfirm: () => {
      if(document.getElementById('swal2-textarea').value === "") {
        Swal.showValidationMessage('Message is required');
      }
    }
  });
  if(text) {
    const formData = { user_id: user_id, auction_id: auction_id, description: text};
    sendAjaxRequest(
      "POST",
      `/auction/${auction_id}/report`,
      formData
    );
    Swal.fire({
      icon: 'success',
      title: 'Report submitted successfully',
      showConfirmButton: false,
      timer: 2500
    });
  }
}

function deleteAll() {
  let parentElement = document.querySelector('#notification-ul');
  if(parentElement){
  let childElements = parentElement.querySelectorAll('.notif');

  if(childElements){
  childElements.forEach(child => {
    child.remove();
  });}}

  let notificationsli = document.createElement("li");
  notificationsli.className = "no-notifications mt-2";
  notificationsli.innerHTML = "You currently have zero notifications.";
  if (parentElement) {
      parentElement.appendChild(notificationsli);
  } else {
      console.error("Parent element not found.");
  }
  let notificationButtons = document.querySelector('#notification-buttons');
  if(notificationButtons){
    let viewAllButton = notificationButtons.querySelector('.btn-viewall');
    if(viewAllButton){
      viewAllButton.remove();
    }
    let deleteAllButton = notificationButtons.querySelector('.btn-deleteall');
    if(deleteAllButton){
      deleteAllButton.remove();
    }
  }

  let NotificationSign = document.querySelector('.notification-badge');
  if(NotificationSign){
    NotificationSign.remove();
  }
}

function viewAll() {
  let parentElement = document.querySelector('#notification-ul');
  if(parentElement){
  let childElements = parentElement.querySelectorAll('.notif');
  if(childElements){
  childElements.forEach(child => {
    child.classList.remove('bg-gray-100');
    child.classList.add('bg-gray-300');
    let viewButton = document.querySelector('.btn-view');
    if (viewButton) {
        viewButton.parentNode.removeChild(viewButton);
    }
  });}}
  let NotificationSign = document.querySelector('.notification-badge');
  if(NotificationSign){
    NotificationSign.remove();
  }
}

function readAllNotification() {

  sendAjaxRequest(
    "POST",
    '/notification/viewall',
    viewAll()
  );
}


function deleteAllNotification() {

  sendAjaxRequest(
    "POST",
    '/notification/deleteall',
    deleteAll()
  );
}



function vNotification(notificationId) {
  let notificationRow = document.getElementById(notificationId);
  if(notificationRow) {
    notificationRow.classList.remove('bg-gray-100');
    let viewButton = document.querySelector('.btn-view');
    console.log("View Button:", viewButton);
    if (viewButton) {
        viewButton.parentNode.removeChild(viewButton);
    }
    let NotificationSign = document.querySelector('.notification-badge');
    if(NotificationSign){
      let number= parseInt(NotificationSign.innerHTML) - 1;
      if(number == 0){
        NotificationSign.remove();
        let notificationButtons = document.getElementById('.notification-buttons');
        if(notificationButtons){
          let viewAllButton = notificationButtons.querySelector('.btn-viewall');
          if(viewAllButton){
            viewAllButton.remove();
          }
          let deleteAllButton = notificationButtons.querySelector('.btn-deleteall');
          if(deleteAllButton){
            deleteAllButton.remove();
          }
        }
      } else {
        NotificationSign.innerHTML = number;
      }
      notificationRow.classList.add('bg-gray-300');
    }
  } else {
    console.error("Notification row not found:", notificationId);
  }
}

function viewNotification(notificationId) {
  let formData = { notification_id: notificationId };

  sendAjaxRequest(
    "POST",
    `/notification/${notificationId}/view`,
    formData,
    vNotification(notificationId)
  );
}


addUserEventListeners();
addTransferEventListeners();
addAuctionEventListeners();
addReportEventListeners();
addFollowEventListeners();
addProfileEventListeners();
addAuctionBidEventListeners();
addAuctionReportEventListener();
addNotificationsEventListeners();
addNotificationEventListener();