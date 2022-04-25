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
               <img src="../${re.avatar}">
               <div class="pc-details">
                  <h4>${re.name}</h4>
                  <p>ram: ${re.ram} | hdd: ${re.hdd} | screen: ${re.screen} | os: ${re.os} | body: ${re.body}</p>
                  <div class="price">
                     <p>Price: ${re.price}</p>
                  </div>
                  <br>
               </div>
               <a href="pc.php?pid=${re.pc_id}" style="text-align: center; background-color: #6a1b9a;padding: 5px; color: white;">View</a>
            </div>
         `
      })
      // e.target.innerText = "👍Liked"
   }
   xhr.send("occ="+occ+"&price="+price)
})