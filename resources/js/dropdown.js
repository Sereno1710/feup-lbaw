function activateDropdowns () {
  /* GENERAL DROPDOWN */
  const dropdownButtons = document.querySelectorAll('.dropdown-button')
  console.log(dropdownButtons)

  if (dropdownButtons !== null) {
    for (const dropdownButton of dropdownButtons) {
      dropdownButton.addEventListener('click', function () {
        const content = this.nextElementSibling
        if (!content.classList.contains('hidden')) {
          content.classList.add('hidden')
        } else {
          content.classList.remove('hidden')
        }
      })
    }
  }

  /* NOTIFICATIONS DROPDOWN */
  const notificationBtn = document.getElementById('notificationBtn')

  if (notificationBtn !== null) {
    const rightPosition =
      window.innerWidth - notificationBtn.getBoundingClientRect().right

    notificationDropdown.style.right = `${rightPosition}px`
  }

  /* SEARCH FILTERS DROPDOWNS */
  document.addEventListener('DOMContentLoaded', function () {
    const metaInfoContainers = document.querySelectorAll('.meta-info-container')

    metaInfoContainers.forEach(container => {
      const dropdown = container.querySelector('.dropdown-button-filter')
      const values = container.querySelector('.values')
      const inputField = container.querySelector('.meta-info-input')
      inputField.disabled = true

      dropdown.addEventListener('click', () => {
        if (!values.classList.contains('hidden')) {
          values.classList.add('hidden')
          inputField.disabled = true
        } else {
          values.classList.remove('hidden')
          inputField.disabled = false
        }
      })
    })
  })
}

activateDropdowns()
