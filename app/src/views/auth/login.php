<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Eigene CSS Datei -->
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <h1 class="text-center mt-5">Login</h1>
                    <form action="/submit_login" method="POST" class="mt-4">

                        <!-- Username -->
                         <div class="form-group">
                             <label for="username">Username:</label>
                             <input type="text" class="form-control" id="username" name="username" required/><br>
                         </div>

                         <!-- Passwort -->
                          <div class="form-group">
                            <label for="password">Passwort:</label>
                            <input type="password" class="form-control" id="password" name="password" required/><br>
                          </div>
                          
                          <!-- Submit -->
                           <button type="submit" class="btn btn-primary btn-block">Login</button>

                    </form>
                </div>
            </div>
        </div>
    </body>
</html>