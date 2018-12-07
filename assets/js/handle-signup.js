$(document).ready(function () {
  $('form').validate({
    rules: {
      'first-name': {
        required: true,
        regex: /.[A-z]{1,}/,
      },
      'last-name': {
        required: true,
        regex: /.[A-z]{1,}/
      },
      'email-address': {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 6,
        regex: /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/,
      },
    },
    messages: {
      'first-name': {
        required: 'Please enter your first name.',
        regex: 'Your first name must have at least 2 characters.',
      },
      'last-name': {
        required: 'Please enter your last name.',
        regex: 'Your last name must have at least 2 characters.',
      },
      'email-address': {
        required: 'Please enter your email address.',
      },
      password: {
        required: 'Please create a password.',
        regex: 'Your password must have at least one number, one lowercase letter and one uppercase letter.'
      },
    },
    submitHandler: function () {
      var form = document.getElementsByTagName('form')[0];
      var password = document.querySelector('[name="password"]');

      // hash the user password before submiting the form
      var hashedPasswordInput = document.createElement('input');
      hashedPasswordInput.type = "hidden";
      hashedPasswordInput.name = "hashed-password";
      hashedPasswordInput.value = hex_sha512(password.value);

      // prevents the user's password from being submitted in plaintext
      password.value = '';
      form.appendChild(hashedPasswordInput);
      form.submit();
    },
  });
});
