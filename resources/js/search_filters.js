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
        showAll(results)
        changeColours(button)
      } else if (button.classList.contains('auctions')) {
        showAuctions(results)
        changeColours(button)
      } else if (button.classList.contains('users')) {
        showUsers(results)
        changeColours(button)
      }
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
