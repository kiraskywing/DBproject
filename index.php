<?php
    session_start();
    # remove all session variables
    session_unset(); 
    # destroy the session
    session_destroy();
    $_SESSION['Authenticated']=false;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="For demo">
        <meta name="author" content="Jeff">
        <meta name="generator" content="Jeff">
        <title>Online Mask Shop</title>
        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
        <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
        <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
        <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
        <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
        <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
        <meta name="theme-color" content="#7952b3">


        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
                }
            }
            .form-signin {
                width: 100%;
                max-width: 330px;
                padding: 15px;
                margin: auto;
                margin-top: 15vh;
            }
            .login-button {
                margin-top: 15px;
            }
            .form-floating {
                position: relative;
            }
            .place-right {
                position: absolute;
                left: 325px;
                bottom: 15px;
                color: red;
                display: none;
                width: 250px;
            }
            .show {
                display: block;
            }
        </style>
    </head>
    <body class="text-center">
            <script>
                // local variable.
                const inputStatus = {
                    ACCOUNT: false,
                    PASSWORD: false,
                    CONFIRM_PASSWORD: false,
                    FULL_NAME: false,
                    PHONE: false,
                };
                // utils.
                function disableSubmitButton() {
                    document.getElementById('submit-button').disabled = true;
                }
                function enableSubmitButton() {
                    document.getElementById('submit-button').disabled = false;
                }
                function showNotice(idName) {
                    document.getElementById(idName).classList.add('show');
                }
                function hideNotice(idName) {
                    document.getElementById(idName).classList.remove('show');
                }
                function replaceToNormalImg() {
                    document.getElementById('login-image').src = './login.png';
                }
                function replaceToFailImg() {
                    document.getElementById('login-image').src = './login-fail.jpeg';
                }
                function confirmAllStatus() {
                    const { ACCOUNT, PASSWORD, CONFIRM_PASSWORD, FULL_NAME, PHONE } = inputStatus;
                    return (
                        ACCOUNT
                        && PASSWORD
                        && CONFIRM_PASSWORD
                        && FULL_NAME
                        && PHONE
                    );
                }
                // validate functions.
                function isRequired(element, noticeElementId, inputStatusKey) {
                    if (element.value.length === 0) {
                        showNotice(noticeElementId);
                        inputStatus[inputStatusKey] = false;
                        replaceToFailImg();
                        disableSubmitButton();
                    } else {
                        hideNotice(noticeElementId);
                        inputStatus[inputStatusKey] = true;
                        replaceToNormalImg();
                        if (confirmAllStatus()) enableSubmitButton();
                    }
                }
                function confirmAccountOrPassword(element, noticeElementId, inputStatusKey) {
                    const passwordTester = /[a-zA-Z\d]{4,20}$/;
                    if (!passwordTester.test(element.value)) {
                        showNotice(noticeElementId);
                        inputStatus[inputStatusKey] = false;
                        replaceToFailImg();
                        disableSubmitButton();
                    } else {
                        hideNotice(noticeElementId);
                        inputStatus[inputStatusKey] = true;
                        replaceToNormalImg();
                        if (confirmAllStatus()) enableSubmitButton();
                    }
                }
                function doubleCheckPassword(element, inputStatusKey) {
                    if (element.value !== document.getElementsByClassName('pwd')[0].value) {
                        showNotice('confirm-password-notice');
                        inputStatus[inputStatusKey] = false;
                        replaceToFailImg();
                        disableSubmitButton();
                    } else {
                        hideNotice('confirm-password-notice');
                        inputStatus[inputStatusKey] = true;
                        replaceToNormalImg();
                        if (confirmAllStatus()) enableSubmitButton();
                    }
                }
                function isNumber(element, inputStatusKey) {
                    const nonNumberTester = /\D/;                    
                    if (nonNumberTester.test(element.value) || element.value.length !== 10) {
                        showNotice('phone-notice');
                        inputStatus[inputStatusKey] = false;
                        replaceToFailImg();
                        disableSubmitButton();
                    } else {
                        hideNotice('phone-notice');
                        inputStatus[inputStatusKey] = true;
                        replaceToNormalImg();
                        if (confirmAllStatus()) enableSubmitButton();
                    }
                }
            </script>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Login</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Register</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <main class="form-signin">
                    <form action="login.php" method="post">
                        <img src="./login.png" alt="" height="120" width="108">
                        <h1 class="h3 mb-3 fw-normal">Please Login</h1>

                        <div class="form-floating">
                            <input type="text" class="form-control" name="account" id="account" placeholder="Your account">
                            <label for="account">Account</label>
                        </div>
                        
                        <div class="form-floating">
                            <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Your password">
                            <label for="password">Password</label>
                        </div>

                        <button class="login-button w-100 btn btn-lg btn-primary" type="submit">Login</button>
                        <p class="mt-5 mb-3 text-muted">©2021 For NCTU DB HW2 demo</p>
                    </form>
                </main>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <main class="form-signin">
                    <form action="register.php" method="post">
                        <img id="login-image" src="./login.png" alt="" height="120" width="108">
                        <h1 class="h3 mb-3 fw-normal">Create New Account</h1>

                        <div class="form-floating">
                            <input onchange="confirmAccountOrPassword(this, 'account-notice', 'ACCOUNT')" type="text" class="form-control" name="account" id="account" placeholder="Your account">
                            <label for="account">Account</label>
                            <div id="account-notice" class="place-right">帳號為4~20碼，只能有英數</div>
                        </div>
                        
                        <div class="form-floating">
                            <input onchange="confirmAccountOrPassword(this, 'password-notice', 'PASSWORD')" type="password" class="form-control pwd" name="pwd" id="pwd" placeholder="Your password">
                            <label for="password">Password</label>
                            <div id="password-notice" class="place-right">Invalid format (only upper/lower-case character and number are allowed)</div>
                        </div>

                        <div class="form-floating">
                            <input onchange="doubleCheckPassword(this, 'CONFIRM_PASSWORD')" type="password" class="form-control" name="re_pwd" id="re_pwd" placeholder="Input your password again">
                            <label for="re_password">Confirm Password</label>
                            <div id="confirm-password-notice" class="place-right">確認密碼與原本不同</div>
                        </div>

                        <div class="form-floating">
                            <input onchange="isRequired(this, 'full-name-notice', 'FULL_NAME')" type="text" class="form-control" name="full_name" id="full_name" placeholder="Your full name">
                            <label for="full_name">Full Name</label>
                            <div id="full-name-notice" class="place-right">Full Name 不能為空</div>
                        </div>
                        
                        <div class="form-floating">
                            <input onchange="isNumber(this, 'PHONE')" type="text" class="form-control" name="phone" id="phone" placeholder="Your phone number">
                            <label for="phone">Phone Number</label>
                            <div id="phone-notice" class="place-right">Invalid format (only 10 digits)</div>
                        </div>

                        <div class="form-floating">
                            City of Residence
                            <select name="city">
                                <?php
                                    include "parameters.php";
                                    foreach ($cities as $city)
                                        echo "<option value=\"" . $city . "\">" . $city . "</option>";
                                ?>
                            </select>
                            <div id="city-of-residence-notice" class="place-right">City of residence 不能為空</div>
                        </div>
                        <p class="mt-5 mb-3 text-muted">©2021 For NCTU DB HW2 demo</p>
                    </form>
                </main>
            </div>
        </div>
    </body>
</html>
