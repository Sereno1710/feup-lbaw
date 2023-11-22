function addEventListeners() {
    let AdminSection = document.getElementById('admin_section');
    if (AdminSection) {
        AdminSection.addEventListener('click', function(event) {
        if (event.target.classList.contains('demote-btn')) {
          let userId = event.target.getAttribute('data-user-id');
          demoteUser(userId);
        }
      });
    }
  
    let UsersSection = document.getElementById('user_section');
    if (UsersSection) {
      UsersSection.addEventListener('click', function(event) {
        if (event.target.classList.contains('promote-btn')) {
          let userId = event.target.getAttribute('data-user-id');
          promoteUser(userId);
        }
        if (event.target.classList.contains('disable-btn')) {
            let userId = event.target.getAttribute('data-user-id');
            disableUser(userId);
          }
      });
    }
  }
    
    function encodeForAjax(data) {
      if (data == null) return null;
      return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
      }).join('&');
    }
  
    function sendAjaxRequest(method, url, data, handler) {
      let request = new XMLHttpRequest();
  
      request.open(method, url, true);
      request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.addEventListener('load', handler);
      request.send(encodeForAjax(data));
    }
  

  
    function moveAdminToUsersTable(userId) {

        let adminRow = document.getElementById('admin_row_' + userId);
    
        if (adminRow) {
            let demoteButton = adminRow.querySelector('.demote-btn');
            adminRow.parentNode.removeChild(adminRow);
            adminRow.id = 'user_row_' + userId;
            let inactiveUsersTable = document.getElementById('user_section').querySelector('tbody');
    
            // Add Disable button to the row
            let disableButton = document.createElement('button');
            disableButton.className = 'mt-2 p-2 text-white bg-stone-800 rounded disable-btn';
            disableButton.type = 'button';
            disableButton.innerText = 'Disable';
            disableButton.addEventListener('click', function() {
                disableUser(userId);
            });
    
            let actionsCell = adminRow.querySelector('.flex.flex-row');
            actionsCell.appendChild(disableButton);
    
            inactiveUsersTable.appendChild(adminRow);
    
            if (demoteButton) {
                demoteButton.innerText = 'Promote';
                demoteButton.classList.remove('demote-btn');
                demoteButton.classList.add('promote-btn');
                demoteButton.removeEventListener('click', demoteUser);
                demoteButton.addEventListener('click', function() {
                    promoteUser(userId);
                });
            } 
        } else {
            console.error('Admin row not found:', userId);
        }
    }
    
    
  
  function moveUserToAdminTable(userId) {
    let userRow = document.getElementById('user_row_' + userId);

    if (userRow) {
        let demoteButton = userRow.querySelector('.demote-btn');
        userRow.parentNode.removeChild(userRow);
        userRow.id = 'admin_row_' + userId;
        let adminTable = document.getElementById('admin_section').querySelector('tbody');

        adminTable.appendChild(userRow);

        demoteButton.innerText = 'Promote';
        demoteButton.classList.remove('demote-btn');
        demoteButton.classList.add('promote-btn');
        demoteButton.removeEventListener('click', demoteUser);
        demoteButton.addEventListener('click', function() {
            promoteUser(userId);
        });
    } else {
        console.error('User row not found:', userId);
    }
}

function removeUserFromTableTable(userId) {
    let userRow = document.getElementById('user_row_' + userId);

    if (userRow) {
        userRow.parentNode.removeChild(userRow);
    } else {
        console.error('User row not found:', userId);
    }
}

  
  function demoteUser(userId) {
    let formData = { 'user_id': userId };
  
    sendAjaxRequest('POST', '/demote' + userId, formData, moveAdminToUserTable(userId));
  }
  
  function disableUser(userId) {
    let formData = { 'user_id': userId };
  
    sendAjaxRequest('POST', '/disable' + userId, formData, removeUserFromTable(userId));
  }
  

  function promoteUser(userId) {
    let formData = { 'user_id': userId };
  
    sendAjaxRequest('POST', '/promote' + userId, formData, moveUserToAdminTable(userId)); 
  }
  
    addEventListeners();