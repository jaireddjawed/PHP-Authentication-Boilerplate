$(document).ready(function () {
  $('form').validate({
    rules: {
      'email-address': {
        required: true,
        email: true,
      },
    },
    messages: {
      'email-address': {
        required: 'Please enter the email address associated with your account.',
      },
    },
  });
});
