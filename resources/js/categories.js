function addEventListeners () {
  document.addEventListener('DOMContentLoaded', function () {
    // Fetch categories from the server
    fetch('/categories') // Replace with your API endpoint
      .then(response => response.json())
      .then(data => {
        // Populate the dropdown with categories
        populateCategories(data)
      })
      .catch(error => {
        console.error('Error fetching categories:', error)
      })
    // Show the dropdown
    //dropdown.parentElement.classList.remove('hidden')
  })

  const searchForm = document.getElementById('searchForm')

  // Add an event listener for form submission
  searchForm.addEventListener('submit', function (event) {
    // Prevent the default form submission
    event.preventDefault()

    // Get the selected categories
    const selectedCategories = document.querySelectorAll(
      'input[name="categories[]"]:checked'
    )

    // Create an array to store the selected category values
    const categoryValues = []

    // Push each selected category value to the array
    selectedCategories.forEach(function (category) {
      categoryValues.push(category.value)
    })
  })
}
// Function to populate categories in the dropdown
function populateCategories (categories) {
  var dropdown = document.getElementById('categoriesDropdown')
  dropdown.innerHTML = '' // Clear existing options

  // Add each category as a checkbox
  categories.forEach(function (category) {
    var checkbox = document.createElement('label')
    checkbox.className = 'flex items-center'
    checkbox.innerHTML = `
                    <input type="checkbox" name="categories[]" value="${category.value}" class="mr-2">
                    ${category.label}
                `
    dropdown.appendChild(checkbox)
  })

  // Create a hidden input element to hold the category values
  const hiddenInput = document.createElement('input')
  hiddenInput.type = 'hidden'
  hiddenInput.name = 'categories'
  hiddenInput.value = JSON.stringify(categoryValues) // You can use JSON or other serialization methods

  // Append the hidden input to the form
  searchForm.appendChild(hiddenInput)

  // Submit the form
  searchForm.submit()
}

addEventListeners()
