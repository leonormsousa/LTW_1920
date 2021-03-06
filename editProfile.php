<?php
  function generate_random_token() {
    return bin2hex(openssl_random_pseudo_bytes(32));
  }
  session_start();
  session_regenerate_id(true);

  if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
  }
  $logedin=true;
  if (!isset($_SESSION['user']))
    header( 'Location: homepage.php' );
  
  $displaySearch = true;
  include('templates/common/header.php');

  $action_form="templates/forms/editProfile_action.php";
  include('database/connection.php');
  include('database/users.php');
  $user=getUserById($_SESSION['user']);
  $firstName=$user['primeiroNome'];
  $lastName=$user['ultimoNome'];
  $birth=$user['dataNascimento'];
  $email=$user['email'];
  $phone=$user['telefone'];
  $country=getCountryById($user['idPais']);
  $pictures=$user['foto'];
?>
  <section id="profile">
    <header>
          <h1> Edit Profile </h1>
    </header>
<?php
  include('templates/forms/profile.php');
?>
  </section>
<?php
  include('templates/common/footer.php');
?>