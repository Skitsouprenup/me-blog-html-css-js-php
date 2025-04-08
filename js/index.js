const navItemsContainer = document.querySelector('.nav__options_credentials_options_mobile')
const navItemsMobile = document.querySelectorAll('.nav__options_credentials_options_list > li')
const navHamBurgerOpen = document.querySelector('.nav__options_mobile > .choices > .menu')
const navHamBurgerClose = document.querySelector('.nav__options_mobile > .choices > .close')

const openNavItemsMobile = () => {
    navItemsContainer.style.display = 'flex'
    navHamBurgerOpen.style.display = 'none'
    navHamBurgerClose.style.display = 'flex'
}

const closeNavItemsMobile = () => {
    navItemsContainer.style.display = 'none'
    navHamBurgerOpen.style.display = 'flex'
    navHamBurgerClose.style.display = 'none'
}

navHamBurgerOpen.addEventListener('click', openNavItemsMobile)
navHamBurgerClose.addEventListener('click', closeNavItemsMobile)

let anim_delay = 0
for(let x of navItemsMobile) {

    if(x.innerText === 'Blogposts') {
        x.style.animationDelay = '25ms'
    }
    else {
        anim_delay += 50
        x.style.animationDelay = `${anim_delay}ms`
    }
    
}