<?php
    // Create connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sis";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['submit'])){
            $username_input = $_POST['username'];
            $password_input = $_POST['password'];

            do {
                if (empty($username_input) || empty($password_input)) {
                    $errormsg = "Harus diisi semua";
                    break;
                }

                // Check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                $query = "SELECT * FROM user WHERE username = ? AND password = ?";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("ss", $username_input, $password_input);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        // Redirect to Dashboard.php on successful login
                        header("Location: Dashboard.php");
                        exit();
                    } else {
                        $errormsg = "Username atau password salah";
                    }
                    $username_input = "";
                    $password_input = "";
                } else {
                    $errormsg = "Gagal Login: " . $stmt->error;
                }

                $stmt->close();
                $connection->close();
            } while (false);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .divider:after, .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
        .h-custom {
            height: calc(100% - 73px);
        }
        @media (max-width: 450px) {
        .h-custom {
            height: 100%;
        }
        }
    </style>
</head>
<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
              <form method="post">
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-3 mb-0">LOGIN</p>
                </div>
                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="form3Example3" class="form-control form-control-lg"
                    placeholder="Enter Username" name="username"/>
                  <label class="form-label" for="form3Example3">Username</label>
                </div>
      
                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-3">
                  <input type="password" id="form3Example4" class="form-control form-control-lg"
                    placeholder="Enter password" name="password"/>
                  <label class="form-label" for="form3Example4">Password</label>
                </div>
      
                <div class="text-center text-lg-start mt-4 pt-2">
                    <button type="submit" class="btn btn-primary" name="submit">LOGIN</button>
                </div>
              </form>
              <?php
                if (isset($errormsg)) {
                    echo "<div class='alert alert-danger mt-3'>$errormsg</div>";
                }
                if (isset($succesmsg)) {
                    echo "<div class='alert alert-success mt-3'>$succesmsg</div>";
                }
              ?>
            </div>
          </div>
        </div>
      </section>
</body>
</html>
