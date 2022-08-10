<?php

    include("config/login.php");

?>
<div class="signin">

  <form action="" method="post" autocomplete="off">

    <div class="group head">

      <h2>Oi Eraldo,</h2>

      <p>Seja bem vindo de volta</p>

    </div>

    <div class="group">

      <label for="username-field">Nome de usuário</label><br>

      <input type="text" name="usuario" id="username-field" required>

    </div>

    <div class="group">

      <label for="password-field">Senha</label><br>

      <input type="password" name="senha" id="password-field" required>

      <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>

    </div>

    <div class="group forgot-pass-link">

      <a href="#">Esqueceu a senha?</a>

    </div>

    <div class="group">

      <button type="submit" name="entrar"><span>Login</span></button>

    </div>

    <div class="group sign-up-link">

      <p>Não tem conta? <a href="#">Não acessa.</a></p>

    </div>

  </form>

</div>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

html, body { 
  min-height: 100vh; 
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: "Poppins", sans-serif;
}

.group {
  margin: 20px 0px 20px 0px;
}

.signin {
  min-height: 300px; 
  align-items: center;
  text-align: center;
  padding: 30px 30px 0px 30px;
  border-radius: 10px;
  box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
}

.forgot-pass-link {
  float: right;
}

.group input {
  width: 280px;
  height: 35px;
  border: 0px;
  outline: none;
  font-size: 13px;
  padding: 0px 10px 0px 10px;
  border-bottom: 1px solid #aaa;
  font-family: "Poppins", sans-serif;
  transition: 0.5s;
}

.group input:hover {
  border-bottom: 1px solid #000;
}

.group button {
  width: 300px;
  height: 45px;
  outline: none;
  border: none;
  background-color: #000000;
  color: #fff;
  font-family: "Poppins", sans-serif;
  font-weight: 600;
  font-size: 16px;
  border-radius: 5px;
}

.sign-up-link {
  text-align: center;
  padding-bottom: 10px;
}

a {
  text-decoration: none;
  color: gray;
  font-weight: 400;
  cursor: pointer;
  transition: 0.5s;
}

a:hover {
  color: #000000;
}

label {
  font-weight: 400;
  float: left;
}

.head {
  float: left;
  margin-top: 0px;
  text-align: left;
}

.head p {
  margin-top: -20px;
  color: gray;
  font-weight: 400;
  padding-bottom: 20px;
  float: left;
}

.field-icon {
  float: right;
  margin-left: -30px;
  margin-top: 8px;
  position: absolute;
  z-index: 2;
}

.group button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.group button span:after {
  content: "\00bb";
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.group button:hover span {
  padding-right: 25px;
}

.group button:hover span:after {
  opacity: 1;
  right: 0;
}

@media screen and (max-width: 400px) {
  .signin{
    border: 0;
    padding: 0px;
    border-radius: 10px;
    box-shadow: none;
  }
}
</style>
<script>
    $(".toggle-password").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $($(this).attr("toggle"));

        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>