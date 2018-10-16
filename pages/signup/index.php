<?php
  $currentPath = dirname(__FILE__);
  $pagetemplate = $currentPath . '/../../helpers/page-template.php';
  require_once($pagetemplate);

  if (!isset($template)) {
    $template = new PageTemplate();
    $template->pagetitle = 'Signup';
    $template->body = __FILE__;
    require_once($currentPath . '/../../layouts/App.php');
    exit;
  }
?>

<form action="../../includes/register.inc.php" method="post" onsubmit="return handleSubmit()">
  <div class="row">
    <div class="col-xs-12 col-md-6">
      <div class="form-group">
        <label>First Name</label>
        <input type="text" name="first-name" placeholder="First Name" class="form-control" required />
      </div>
    </div>
    <div class="col-xs-12 col-md-6">
      <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last-name" placeholder="Last Name" class="form-control" required />
      </div>
    </div>
  </div>
  <div class="form-group">
    <label>E-mail Address</label>
    <input type="email" name="email-address" placeholder="E-mail Address" class="form-control" required />
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" placeholder="Password" class="form-control" required />
  </div>
  <div class="form-group">
    <button type="submit" name="submit" class="btn btn-success">Signup</button>
  </div>
</form>

<script>
  function handleSubmit() {
    var submitForm = false;

    var form = document.getElementsByTagName('form')[0];
    var password = document.querySelector('[name="password"]');
    var passwordRegex = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 

    if (password.value.length < 6) {
      alert('Passwords must be at least 6 characters long!');
      password.focus();
    }
    else if (!passwordRegex.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        password.focus();
    }
    else {
      var hashedPasswordInput = document.createElement('input');

      hashedPasswordInput.type = 'hidden'; 
      hashedPasswordInput.name = 'hashed-password';
      hashedPasswordInput.value = hex_sha512(password.value);
      form.appendChild(hashedPasswordInput);

      password.value = '';
      submitForm = true;
    }

    return submitForm;
  }
</script>
