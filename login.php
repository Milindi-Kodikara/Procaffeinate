<?php
    session_start();
    include_once('tools.php');
    top_module("Login|Procaffeination");
?>
    <main>
        <div id="login-bkgrd" class='bkgrd'>
            <div class="card">
                <h3 id="login-heading">Log in</h3>
                <form action='https://titan.csit.rmit.edu.au/~e54061/wp/processing.php' method="post" class='form'>
                    <div>
                        <input type='email' name='email' placeholder="Email address" required />
                    </div>
                    <div class='form-inputs'>
                        <input type='password' name='password' placeholder="Password" required/>
                    </div>
                    <div>
                        <input type='submit' value="Login">
                    </div>
                </form>
                <p id='login-des'>By clicking on Login, you agree to the Privacy Policy</p>
            </div>
        </div>
<?php
    bottom_module();
?>