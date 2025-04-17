const navItemsContainer = document.querySelector('.nav__options_credentials_options_mobile')
const navItemsMobile = document.querySelectorAll('.nav__options_credentials_options_list > li')
const navHamBurgerOpen = document.querySelector('.nav__options_mobile > .choices > .menu')
const navHamBurgerClose = document.querySelector('.nav__options_mobile > .choices > .close')

console.log(navHamBurgerClose)

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

/* Not all pages have navigation bar. Thus, check if these nav components are null. */
if(navHamBurgerOpen !== null)
    navHamBurgerOpen.addEventListener('click', openNavItemsMobile)
if(navHamBurgerClose !== null)
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

/*
    Note: Use this function syntax rather than the
    'arrow function' syntax. For some reason, the 'arrow function'
    syntax doesn't work on some pages like the sign in page. If you
    persist on using 'arrow function' syntax, you'll get this error:
    Uncaught ReferenceError: can't access lexical declaration 'closeMessagePanel' before initialization

    That error refers to 'Temporal Dead Zone'.

    I think the reason why this function syntax works is because of the 'hoisting' feature of javascript.
    Remember, arrow functions are not hoisted whereas this function syntax is hoisted.
*/
function closeMessagePanel(query) {
    document.querySelector(query).style.display = 'none';
}