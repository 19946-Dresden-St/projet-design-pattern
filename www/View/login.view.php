<!-- mini modif -->

        <div class="card">
            <div>
                <h1>Se connecter</h1>
            </div>
            <?php if ( count($errors)>0 ) { ?>
            <!-- modif : j'ai rajouté une div dans laquelle on va boucler sur un tableau $errors et display les error a chaque fois -->
            <div class="error-login">
                <h2>Error : </h2>
                <?php  foreach ($errors as $key => $error) { ?>
                    <!-- modif : ici qu'on display l'error -->
                    (<?=($key+1)?>) &nbsp; <?=$error?> <br>
                <?php } ?> 
            </div>
            <?php } ?>
            <?php if ( count($success)>0 ) { ?>
            <!-- modif : j'ai rajouté une div dans laquelle on va boucler sur un tableau $success et display les error a chaque fois -->
            <div class="success-login">
                <h2>Success : </h2>
                <?php  foreach ($success as $key => $succ) { ?>
                    <!-- modif : ici qu'on display succ -->
                    (<?=($key+1)?>) &nbsp; <?=$succ?> <br>
                <?php } ?> 
            </div>
            <?php } ?>
            <?php $this->includePartial("form", $user->getLoginForm()) ?>
            <a href="/forgottenpwd">Mot de passe oublié</a>
        </div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200;400&display=swap');

    body {
        margin: 0 !important;
        font-family: 'Manrope', sans-serif;
        color: whitesmoke;
    }

    .error-login {
        color: red;
    }

    .success-login {
        color: green;
    }

    .card {
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 8px;
        width: 30%;
        margin-left: auto;
        margin-right: auto;
        padding: 1.25rem;
        position: absolute;
        top: 35%;
        left: 35%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    .card h1 {
        margin: 0 0 1rem 0;
        font-size: 40px;
        letter-spacing: 6px;
    }

    .card input {
        background-color: transparent;
        border: none;
        border-bottom: 1px solid #ffffffb3;
        width: 70%;
        height: 2rem;
        font-size: 18px;
        font-weight: 200;
        color: white;
        margin-top: 1rem;
    }

    .card input::placeholder {
        color: #ffffffb3;
        font-weight: 200;
    }

    .card input:hover {
        border-bottom: 1px solid white;
    }

    .card input:last-child {
        border: 1px solid #ffffffb3;
        color: #ffffffb3;
        cursor: pointer;
        height: 3rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .card input:last-child:hover {
        border: 1px solid white;
        color: #ffffff;
    }

</style>
