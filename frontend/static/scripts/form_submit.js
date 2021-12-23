$(document).ready(() => {
    $('#submit-button').click(() => {
        if($('#error-message').val() === '' &&  $("input#email").val() != ''){
            let email_checkbox_data = {email: $("input#email").val(), checkbox: $("input#agree-terms-of-service-checkbox").prop('checked')};
            $.ajax({
                type: 'POST',
                url: '../Pineapple/add_email',
                data: email_checkbox_data,
                success: (message) => {
                    alert(message);
                    $('#advertisment-form-block').html(`
                        <img src="frontend/static/vectors/ic_success.svg" id='ic_success'>
                        <h1>Thanks for subscribing!</h1>
                        <p>You have succesfully subscribed to our email listing.<br>Check your email for the discount code.</p>
                    `)
                }
            })
        }
    })
})
