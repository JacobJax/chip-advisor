let likeBTNs = Array.from(document.querySelectorAll('.l-btn'))

likeBTNs.forEach(likeBtn => {
   likeBtn.addEventListener('click', e => {
      e.preventDefault()

      let pid = e.target.children.pid.value
      const xhr = new XMLHttpRequest()

      xhr.open('POST', `handlelike.php`, true)
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

      xhr.onload = () => {
         console.log(xhr.responseText)
         e.target.innerText = "👍Liked"
      }
      xhr.send("pid="+pid)
      console.log(e)
   })
})
