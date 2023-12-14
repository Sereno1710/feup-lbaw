function addEventListeners () {
  let buttons = document.getElementById('filters')
  var resultsArray = JSON.parse(searchResults)

  if (resultsArray && buttons) {
    buttons.addEventListener('click', function (event) {
      let button = event.target
      if (button.classList.contains('all')) {
        showAll(resultsArray)
      } else if (button.classList.contains('auctions')) {
        showAuctions(resultsArray)
      } else if (button.classList.contains('users')) {
        showUsers(resultsArray)
      }
      changeColours(button)
    })
  }
}

function changeColours (button) {
  document.querySelectorAll('.button').forEach(btn => {
    btn.classList.remove(
      'bg-black',
      'border-black-500',
      'text-white',
      'hover:bg-gray-600'
    )
    btn.classList.add(
      'bg-white',
      'border-black',
      'text-black',
      'hover:bg-gray-200'
    )
  })
  button.classList.remove(
    'bg-white',
    'border-black',
    'text-black',
    'hover:bg-gray-200'
  )
  button.classList.add(
    'bg-black',
    'border-black-500',
    'text-white',
    'hover:bg-gray-600'
  )
}

function encodeForAjax (data) {
  if (data == null) return null
  return Object.keys(data)
    .map(function (k) {
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    })
    .join('&')
}

function sendAjaxRequest (method, url, data, handler) {
  let request = new XMLHttpRequest()

  request.open(method, url, true)
  request.setRequestHeader(
    'X-CSRF-TOKEN',
    document.querySelector('meta[name="csrf-token"]').content
  )
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
  request.addEventListener('load', handler)
  request.send(encodeForAjax(data))
}

function showAll (resultsArray) {
  resultsArray.forEach(result => {
    result.style.display = 'block'
  })
}

function showAuctions (resultsArray) {
  resultsArray.forEach(result => {
    if (result.type === 'auction') {
      result.style.display = 'block'
    } else {
      result.style.display = 'none'
    }
  })
}

function showUsers (resultsArray) {
  resultsArray.forEach(result => {
    if (result.type === 'user') {
      result.style.display = 'block'
    } else {
      result.style.display = 'none'
    }
  })
}

addEventListeners()
