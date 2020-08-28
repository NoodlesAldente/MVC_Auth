<div class="container">
    <div class="row">
        <div class="col-4 ">
            <img src="./Pictures/lock.png" alt="locker">
        </div>
        <div class="col-4 ">
            <h2>Sign In</h2>
            <p>Please connect with your username and password</p>
            <form method="post" action="./index.php?action=connexion">
                <label for="username">Username:</label>
                <input class="form-control" type="text" name="username" id="username" required>
                <label for="password">Password:</label>
                <input class="form-control" type="password" name="password" id="password" required><br>
                <input type="text" name="fingerPrint" style="visibility: hidden;" value="<?php echo isset($_SESSION['fingerPrint']) ? $_SESSION['fingerPrint'] : ''; ?>">
                <button type="submit" class="btn btn-outline-primary">Sign in </button>
            </form>
            </div>
        <div class="col-4 ">
            <h2>Register</h2>
            <p>Please register with your username and a password</p>
                <form method="post" action="./index.php?action=inscription">
                <label for="username">Username:</label>
                    <input class="form-control" type="text" name="username" id="username" required>
                    <label for="password">password:</label>
                    <input class="form-control" type="password" name="password" id="password" required><br>
                    <input type="text" name="fingerPrint" style="visibility: hidden;" value="<?php echo isset($_SESSION['fingerPrint']) ? $_SESSION['fingerPrint'] : ''; ?>">
                    <button type="submit" class="btn btn-outline-primary">Register</button>
                </form>
        </div>
            
    </div>
    
</div>