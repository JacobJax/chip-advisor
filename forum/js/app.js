let psForm = document.querySelector('#post-f')
let cmForms = Array.from(document.querySelectorAll('.cmt-frm'))

psForm.addEventListener('submit', e => {
   e.preventDefault()

   let post = e.target.post.value
   // console.log(post)
   const xhr = new XMLHttpRequest()

   xhr.open('POST', `addpost.php`, true)
   xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

   xhr.onload = () => {
      console.log(xhr.responseText)
      e.target.post.value = ""
   }
   xhr.send("post="+post)
})

cmForms.forEach(frm => {
   frm.addEventListener('submit', e => {
      e.preventDefault()

      let cmt = e.target.cmt.value
      let pid = e.target.pid.value
      let cmCont = e.target.parentElement.children[2]

      const xhr = new XMLHttpRequest()

      xhr.open('POST', `addcomment.php`, true)
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

      xhr.onload = () => {
         console.log(xhr.responseText)
         e.target.cmt.value = ""
         cmCont.innerHTML += `<p style='padding-bottom: 5px; font-weight: lighter; font-size: 15px;'><span style='color: #bdbdbd; font-size: 13px;'><span style='font-size: 17px'>👨‍💻</span>You: </span> ${cmt}</p>`
      }
      xhr.send("post="+cmt+"&pid="+pid)
   })
})