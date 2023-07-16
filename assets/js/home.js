const navBar = document.querySelector("nav"),
       menuBtns = document.querySelectorAll(".menu-icon"),
       overlay = document.querySelector(".overlay");

     menuBtns.forEach((menuBtn) => {
       menuBtn.addEventListener("click", () => {
         navBar.classList.toggle("open");
       });
     });

     overlay.addEventListener("click", () => {
       navBar.classList.remove("open");
     });



/*=============== DROPDOWN JS ===============*/
const showDropdown = (content, button) =>{
  const dropdownContent = document.getElementById(content),
        dropdownButton = document.getElementById(button)

  dropdownButton.addEventListener('click', () =>{
     dropdownContent.classList.toggle('show-dropdown')
  })
}

showDropdown('dropdown-content','dropdown-button')
//-------------------------------------------------------------------
