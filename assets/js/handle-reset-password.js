$(document).ready(function () {
  $('form').validate({
    rules: {
      'new-password': {
        required: true,
        minlength: 6,
        regex: /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/,
      },
      'confirm-new-password': {
        required: true,
        equalTo: '[name="new-password"]',
      },
    },
    messages: {
      'new-password': {
        required: 'Please create a new password.',
        regex: 'Your password must have at least one number, one lowercase letter and one uppercase letter.',
      },
      'confirm-new-password': {
        required: 'Please confirm your new password.',
        equalTo: 'Your passwords do not match.',
      },
    },
    submitHandler: function () {
      var form = document.getElementsByTagName('form')[0];
      var password = document.querySelector('[name="new-password"]');
      var confirmPassword = document.querySelector('[name="confirm-new-password"]');

      // hash the user password before submiting the form
      var hashedPasswordInput = document.createElement('input');
      hashedPasswordInput.type = "hidden";
      hashedPasswordInput.name = "hashed-password";
      hashedPasswordInput.value = hex_sha512(password.value);
      form.appendChild(hashedPasswordInput);

      // get the password reset token
      var urlParams = new URLSearchParams(window.location.search);
      var token = urlParams.get('token');

      // append the token as a hidden input
      var tokenInput = document.createElement('input');
      tokenInput.type = 'hidden';
      tokenInput.name = 'token';
      tokenInput.value = token;
      form.appendChild(tokenInput);

      // prevent the user's password from being submitted in plaintexts
      password.value = '';
      confirmPassword.value = '';
      form.submit();
    },
  });
});
