$(document).ready(()=>{
    let uri = window.location.pathname
    if(uri === '/'){
        $('.wrapper').load('frontend/pages/main.html')
    }
    else if(uri === '/email_list'){
        $('.wrapper').load('frontend/pages/admin.html')
    }
})