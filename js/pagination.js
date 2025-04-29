const forwardBtn = document.querySelector('.forward_buttons > .forward')
const forwardSkipBtn = document.querySelector('.forward_buttons > .forward_skip')
const backwardBtn = document.querySelector('.backward_buttons > .backward')
const backwardSkipBtn = document.querySelector('.backward_buttons > .backward_skip')

const moveToPage = (current_page, page_count, btnType, domainName) => {

    const actions = [
        [forwardBtn, 'pagination_disable_btn', 'forward', current_page+1],
        [forwardSkipBtn, 'pagination_disable_skip_btn', 'forward_skip', page_count],
        [backwardBtn, 'pagination_disable_btn', 'backward', current_page-1],
        [backwardSkipBtn, 'pagination_disable_skip_btn','backward_skip', 1]
    ]
    validInput = false

    for(list of actions) {
        //Check if this button is disabled.
        //End the function if the button is disabled
        //'list[2] === btnType' checks which button to be evaluated
        if(list[2] === btnType && list[0].classList.contains(list[1])) {
            console.log(list[0].classList)
            return
        }

        // Check if btnType is a valid input in this
        // function. End the function if not.
        if(validInput === false && list[2] === btnType) {
            validInput = true
        }
    }

    if(!validInput) return
    
    for(list of actions) {
        if(list[2] === btnType) {
            window.location.href = domainName+"?cp="+list[3]+"#blogposts";
        }
    }

}

//Note: classList may not support some old browsers
const togglePagBtnHighlights = (current_page, page_count) => {

    /*
    [0] = element
    [1] = 'disable' css classes
    [2] = 'highlights' css classes
    */
    const buttons = [
        [forwardBtn, 'pagination_disable_btn', 'f_hover'], 
        [forwardSkipBtn, 'pagination_disable_skip_btn', 'f_skip_hover'], 
        [backwardBtn, 'pagination_disable_btn', 'b_hover'], 
        [backwardSkipBtn, 'pagination_disable_skip_btn', 'b_skip_hover']
    ]

    const setPagBtnsClasses = (direction) => {
        let idList = null
        let validInput = false

        if(direction === 'left' || direction === 'right')
            validInput = true

        if(!validInput) return
    
        if(direction === 'left')
            idList = ['b_hover', 'b_skip_hover']
    
        if(direction === 'right')
            idList = ['f_hover', 'f_skip_hover']
    
        for(list of buttons) {
            // Get css classes that identify left/right buttons
            // This is the part for disabling the buttons
            if(list[2] === idList[0] || list[2] === idList[1]) {
                // Check for disable classes and add them if 
                // not already added in order to disable buttons
                if(!list[0].classList.contains(list[1])) {
                    list[0].classList.add(list[1])
                }
    
                // Remove highlight classes because this button
                // is gonna be disabled
                if(list[0].classList.contains(list[2])) {
                    list[0].classList.remove(list[2])
                }
            }
            //This is the part for enabling buttons
            else {
                //Remove disable classes.
                if(list[0].classList.contains(list[1])) {
                    list[0].classList.remove(list[1])
                }

                //Add highlight classes.
                if(!list[0].classList.contains(list[2])) {
                    list[0].classList.add(list[2])
                }
            }
        }
    }

    //Start
    if(current_page === 1 && page_count > 1) {
        //Disable left buttons and enable right buttons
        setPagBtnsClasses('left')
    }

    //Middle. This condition requires page_count to be 3 or more
    if(current_page > 1 && current_page < page_count && page_count > 2) {
        //Enable all buttons and add highlights
        for(list of buttons) {
            //Remove disable classes.
            if(list[0].classList.contains(list[1])) {
                list[0].remove(list[1])
            }

            //Add highlight classes.
            if(!list[0].classList.contains(list[2])) {
                list[0].classList.add(list[2])
            }
        }
    }

    //End
    if(current_page === page_count && page_count > 1) {
        //Disable right buttons and enable left buttons
        setPagBtnsClasses('right')
    }

    //Start-End
    if(current_page === 1 && page_count === 1) {
        
        //Disable all buttons
        for(list of buttons) {
            //Add disable classes
            if(!list[0].classList.contains(list[1])) {
                list[0].classList.add(list[1])
            }

            //Remove highlight classes
            if(list[0].classList.contains(list[2])) {
                list[0].classList.remove(list[2])
            }
        }
    }
}