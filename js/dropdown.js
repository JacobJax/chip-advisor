const toggleBtn = document.querySelector('.link-toggle')
const container = document.querySelector('.dissapear')

// add event on button click
toggleBtn.addEventListener('click', () => {
   togleClass(container, 'dissapear')
})

// toggle class function
const togleClass = (element, class_name) => {
   element.classList.toggle(class_name)
}