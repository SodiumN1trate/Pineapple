$(document).ready(()=>{
    let uri = window.location.pathname
    if(uri === '/Pineapple/'){
        $('.wrapper').load('frontend/pages/main.html')
    }
    else if(uri === '/Pineapple/email_list'){
        $('.wrapper').load('frontend/pages/admin.html')
    }
})