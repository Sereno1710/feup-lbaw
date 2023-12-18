function addEventListeners () {
  let buttons = document.getElementById('filters')
  console.log(searchResults)
  var auctions = document.querySelectorAll('.auction')
  var users = document.querySelectorAll('.user')
  var results = [...auctions, ...users]
  console.log(auctions)
  console.log(users)
  console.log(results)

  if (results && buttons) {
    buttons.addEventListener('click', function (event) {
      let button = event.target
      if (button.classList.contains('all')) {
        localStorage.setItem('selectedButton', 'allButton')
        changeColours(localStorage.getItem('selectedButton'))
        showAll(results)
      } else if (button.classList.contains('auctions')) {
        localStorage.setItem('selectedButton', 'auctionsButton')
        changeColours(localStorage.getItem('selectedButton'))
        showAuctions(results)
      } else if (button.classList.contains('users')) {
        localStorage.setItem('selectedButton', 'usersButton')
        changeColours(localStorage.getItem('selectedButton'))
        showUsers(results)
      }
    })

    if (localStorage.getItem('selectedButton') == null) {
      localStorage.setItem('selectedButton', 'allButton')
    }

    if (localStorage.getItem('selectedButton') === 'allButton') {
      showAll(results)
    } else if (localStorage.getItem('selectedButton') === 'auctionsButton') {
      showAuctions(results)
    } else if (localStorage.getItem('selectedButton') === 'usersButton') {
      showUsers(results)
    }

    changeColours(localStorage.getItem('selectedButton'))
  }
}

function changeColours (buttonId) {
  let button = document.getElementById(buttonId)
  console.log(button)
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

function showAll (searchResults) {
  searchResults.forEach(result => {
    result.classList.remove('hidden')
  })
}

function showAuctions (searchResults) {
  searchResults.forEach(result => {
    if (result.classList.contains('auction')) {
      result.classList.remove('hidden')
    } else {
      result.classList.add('hidden')
    }
  })
}

function showUsers (searchResults) {
  searchResults.forEach(result => {
    if (result.classList.contains('user')) {
      result.classList.remove('hidden')
    } else {
      result.classList.add('hidden')
    }
  })
}

addEventListeners()
