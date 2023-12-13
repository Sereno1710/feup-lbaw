function addEventListeners() {
  let AdminSection = document.getElementById("admin_section");
  if (AdminSection) {
    AdminSection.addEventListener("click", function (event) {
      if (event.target.classList.contains("demote-btn")) {
        let userId = event.target.getAttribute("user_id");
        demoteUser(userId);
      }
    });
  }

  let UsersSection = document.getElementById("user_section");
  if (UsersSection) {
    UsersSection.addEventListener("click", function (event) {
      if (event.target.classList.contains("promote-btn")) {
        let userId = event.target.getAttribute("user_id");
        promoteUser(userId);
      }
      if (event.target.classList.contains("disable-btn")) {
        let userId = event.target.getAttribute("user_id");
        disableUser(userId);
      }
    });
  }

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

function moveAdminToUserTable(userId) {
  let adminRow = document.getElementById("admin_row_" + userId);

  if (adminRow) {
    let demoteButton = adminRow.querySelector(".demote-btn");
    demoteButton.remove();

    adminRow.parentNode.removeChild(adminRow);
    adminRow.id = "user_row_" + userId;
    let UsersTable = document
      .getElementById("user_section")
      .querySelector("tbody");
    UsersTable.appendChild(adminRow);

    let disableButton = document.createElement("button");
    disableButton.className =
      "mt-2 p-2 text-white bg-stone-800 rounded disable-btn";
    disableButton.type = "button";
    disableButton.innerText = "Disable";
    disableButton.setAttribute("user_id", userId);

    let promoteButton = document.createElement("button");
    promoteButton.className =
      "mt-2 p-2 text-white bg-stone-800 rounded promote-btn";
    promoteButton.type = "button";
    promoteButton.innerText = "Promote";
    promoteButton.setAttribute("user_id", userId);

    let actionsCell = adminRow.querySelector(".flex.flex-row");
    actionsCell.appendChild(disableButton);
    actionsCell.appendChild(promoteButton);
  } else {
    console.error("Admin row not found:", userId);
  }
}

function moveUserToAdminTable(userId) {
  let userRow = document.getElementById("user_row_" + userId);

  if (userRow) {
    let disableButton = userRow.querySelector(".disable-btn");
    let promoteButton = userRow.querySelector(".promote-btn");
    disableButton.remove();
    promoteButton.remove();

    userRow.parentNode.removeChild(userRow);
    userRow.id = "admin_row_" + userId;
    let adminTable = document
      .getElementById("admin_section")
      .querySelector("tbody");
    adminTable.appendChild(userRow);

    let demoteButton = document.createElement("button");
    demoteButton.className =
      "mt-2 p-2 text-white bg-stone-800 rounded demote-btn";
    demoteButton.type = "button";
    demoteButton.innerText = "Demote";
    demoteButton.setAttribute("user_id", userId);

    let actionsCell = userRow.querySelector(".flex.flex-row");
    actionsCell.appendChild(demoteButton);
  } else {
    console.error("User row not found:", userId);
  }
}

function removeUserFromTable(userId) {
  let userRow = document.getElementById("user_row_" + userId);

  if (userRow) {
    userRow.parentNode.removeChild(userRow);
  } else {
    console.error("User row not found:", userId);
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

function demoteUser(userId) {
  let formData = { user_id: userId };

  sendAjaxRequest("POST", "/admin/users/demote", formData, function (response) {
    moveAdminToUserTable(userId);
  });
}

function disableUser(userId) {
  let formData = { user_id: userId };

  sendAjaxRequest(
    "POST",
    "/admin/users/disable",
    formData,
    removeUserFromTable(userId)
  );
}

function promoteUser(userId) {
  let formData = { user_id: userId };

  sendAjaxRequest(
    "POST",
    "/admin/users/promote",
    formData,
    moveUserToAdminTable(userId)
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

addEventListeners();
