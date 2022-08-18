let likeBTNs = Array.from(document.querySelectorAll('.l-btn'))
let rcForm = document.querySelector('#rc-form')
let sec = document.querySelector('#pc-v')

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

rcForm.addEventListener('submit', e => {
   e.preventDefault()

   sec.innerHTML = ""

   let price = e.target.children[0].children.price.value
   let i = e.target.children[0].children[6].children[1].children.occ.options.selectedIndex
   let occ = e.target.children[0].children[6].children[1].children.occ.options[i].value
   // console.log(occ)

   const xhr = new XMLHttpRequest()

   xhr.open('POST', `recommend_pc.php`, true)
   xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

   xhr.onload = () => {

      let res = JSON.parse(xhr.responseText)

      document.querySelector('#pcs-v').innerText = `${res.length} PCs found`

      // console.log(res)

      res.forEach(re => {
         sec.innerHTML += `
            <div class="pc">
               <div class="pc-ill" style="height: 200px;">
                  <img src="../${re.avatar}" class="backloader" style="height: 100%; width: 100%;">
               </div>
               <div class="pc-details">
                  <h4 class="backloader backloader-text">${re.name}</h4>
                  <p class="backloader backloader-text">ram: ${re.ram} | hdd: ${re.hdd} | screen: ${re.screen} | os: ${re.os} | body: ${re.body}</p>
                  <div class="price">
                     <p class="backloader backloader-text">Price: ${re.price}</p>
                  </div>
                  <br>
               </div>
               <a href="pc.php?pid=${re.pc_id}" style="text-align: center; background-color: #6a1b9a;padding: 5px; color: white; border-radius: 3px;">View</a>
            </div>
         `
      })
   }
   xhr.send("occ="+occ+"&price="+price)
})