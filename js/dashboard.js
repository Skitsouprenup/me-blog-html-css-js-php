const sidebarContainer = document.querySelector('.dashboard_side_bar')
const sidebarToggleBg = document.querySelector('.dashboard_body_wrapper > .sidebar_toggle_bg')
const sidebarClose = document.querySelector('.dashboard_body_wrapper > .arrow_left')
const sidebarOpen = document.querySelector('.dashboard_body_wrapper > .arrow_right')

const openSidebarMobile = () => {
  sidebarContainer.style.left = '0'
  sidebarToggleBg.style.display = 'initial'
  sidebarClose.style.display = 'flex'
  sidebarOpen.style.display = 'none'
}

const closeSidebarMobile = () => {
  sidebarToggleBg.style.display = 'none'
  sidebarContainer.style.left = '-100%'
  sidebarClose.style.display = 'none'
  sidebarOpen.style.display = 'flex'
}

sidebarClose.addEventListener('click', closeSidebarMobile)
sidebarOpen.addEventListener('click', openSidebarMobile)

function hideMobileButtons(media) {
  if (media.matches) { // If media query matches
    sidebarContainer.style.left = ''
    sidebarToggleBg.style.display = ''
    sidebarClose.style.display = ''
    sidebarOpen.style.display = ''
  }
}
  
var media = window.matchMedia("screen and (min-width: 1024px)")
  
//initial execution
hideMobileButtons(media);
  
// Attach listener function on state changes
media.addEventListener("change", function() {
  hideMobileButtons(media);
});

const dialogBoxBg = document.querySelector('.dashboard_body_wrapper > .dashboard_dialog_box_wrapper')
const dialogBox = document.querySelector('.dashboard_dialog_box_wrapper > .dashboard_dialog_box')
const dialogDesc = document.querySelector('.dashboard_dialog_box > .info > .description')

const showDeleteDialogBox = (item) => {
  dialogBoxBg.style.display = 'flex'
  dialogBox.style.display = 'flex'
  dialogDesc.textContent = `Are you sure you want to delete \'${item}\'?`
}

const hideDialogBox = () => {
  dialogBoxBg.style.display = ''
  dialogBox.style.display = ''
  dialogDesc.textContent = ''
}