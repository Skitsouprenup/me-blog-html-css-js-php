<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE-edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="../../css/index.css" />

        <script src="../../js/index.js" defer></script>
    </head>

    <body class="form-body">
        <section class="form_section">
            <div class="form_container">
                <h2>Sign Up</h2>
                <form class="form_inputs" action="" enctype="multipart/form-data">
                    <input type="text" placeholder="First Name..."/>
                    <input type="text" placeholder="Last Name..."/>
                    <input type="text" placeholder="Username..."/>
                    <input type="email" placeholder="E-mail..."/>
                    <input type="password" placeholder="Password..."/>
                    <input type="password" placeholder="Confirm Password..."/>
                    <div class="file_upload">
                        <label for="avatar">Add Avatar</label>
                        <input type="file" id="avatar" />
                    </div>
                    <div class="form_error_message">Error Here</div>
                    <button type="submit">Sign Up</button>

                    <div class="have_account">
                        <p class="have_account_text">Have an Account? </p>
                        <a href="signin.php" class="sign_in">Login.</a>
                    </div>
                </form>
            </div>
        </section>
    </body>
</html>