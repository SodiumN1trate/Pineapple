const ERROR_MESSAGE = document.getElementById('error-message')
 
const USER_EMAIL_ADDRESS = document.getElementById('email')

const SUBMIT_BUTTON = document.getElementById('submit-button')

let validated = false

function email_valid(email) {
    var r = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
    return r.test(email)
}

function is_checkbox_marked() {
    return document.getElementById('agree-terms-of-service-checkbox').checked
}

function create_error_message(value) {
    ERROR_MESSAGE.innerHTML = value
}

function email_check_illegal_domain(email) {
    var illegal_characters = /\.co$/
    return illegal_characters.test(email)
}


USER_EMAIL_ADDRESS.addEventListener('keyup', () => { 
    ERROR_MESSAGE.style.display = 'block'
    if(USER_EMAIL_ADDRESS.value === ''){
        create_error_message('Email address is required')
    } else if(email_valid(USER_EMAIL_ADDRESS.value) == false) {
         create_error_message('Please provide a valid e-mail address')
    } else if(email_check_illegal_domain(USER_EMAIL_ADDRESS.value)) {
        create_error_message('We are not accepting subscriptions from Colombia emails')
    } else if(!is_checkbox_marked()){
        create_error_message('You must accept the terms and conditions')
    } else {
        ERROR_MESSAGE.style.display = 'none'
        validated = true
    }
})

document.getElementById('agree-terms-of-service-checkbox').addEventListener('click', () => {
    if(is_checkbox_marked()){
        ERROR_MESSAGE.style.display = 'none'
        validated = true
    }
})

