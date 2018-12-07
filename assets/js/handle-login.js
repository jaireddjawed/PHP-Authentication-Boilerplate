$(document).ready(function () {
  $('form').validate({
    rules: {
      'email-address': {
        required: true,
        email: true,
      },
      password: {
        required: true,
      },
    },
    messages: {
      'email-address': {
        required: 'Please enter your email address.',
      },
      password: {
        required: 'Please enter your password.',
      },
    },
    submitHandler: function () {
      var form = document.getElementsByTagName('form')[0];
      var password = document.querySelector('[name="password"]');

      // hash the user's password before submitting the form
      var hashedPasswordInput = document.createElement('input');
      hashedPasswordInput.type = 'hidden';
      hashedPasswordInput.name = 'hashed-password';
      hashedPasswordInput.value = hex_sha512(password.value);

      // prevents the user's password from being submitted in plaintext
      password.value = '';
      form.appendChild(hashedPasswordInput);
      form.submit();
    },
  });
});
