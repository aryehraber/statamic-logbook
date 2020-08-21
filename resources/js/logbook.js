// Submit form on select change
const setupSelectListenter = () => {
  const select = document.querySelector('select[name=log]')

  if (select) {
    select.addEventListener('change', () => select.form.submit())
  }
}

// Confirm deletion of logs
const setupDeleteListeners = () => {
  const deleteButtons = Array.from(document.querySelectorAll('[data-delete]'))

  deleteButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      if (! confirm('Are you sure?')) {
        e.preventDefault()
      }
    })
  })
}

// Expand stacktraces on click
const setupStacktraceListeners = () => {
  const stackRows = Array.from(document.querySelectorAll('[data-expandable]'))

  stackRows.forEach(stackRow => {
    stackRow.addEventListener('click', (e) => {
      let row = e.target

      while (row !== null) {
        if (row === stackRow) break

        row = row.parentNode
      }

      const stack = row && row.querySelector('[data-stack]')

      if (stack) {
        stack.classList.toggle('hidden')

        row.style.cursor = stack.classList.contains('hidden') ? 'zoom-in' : 'zoom-out'
      }
    })
  })
}

const init = () => {
  setupSelectListenter()
  setupDeleteListeners()
  setupStacktraceListeners()
}

document.addEventListener('DOMContentLoaded', init)
