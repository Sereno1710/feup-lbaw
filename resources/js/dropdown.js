function activateDropdowns () {
  /* GENERAL DROPDOWN */
  const dropdownButtons = document.querySelectorAll('.dropdown-button')

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
}

activateDropdowns()

