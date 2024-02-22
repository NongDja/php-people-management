<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-xjScD9r8DMHvo7uRtm5SLO5B1JnOBgqnXRWBbRVmH3gD5fKS72N9czNlCxVjFbJr" crossorigin="anonymous">
    <title>Login Form</title>

    <style>
        .divider:after,
        .divider:before {
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
   

        .back:hover svg {
            transform: scale(1.2); 
        }

        .back:hover svg path {
            fill: #ff0000;
        }
    </style>
</head>

<body>
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <a class="back" href="../index.php">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512" style="position: absolute; top: 20px; left: 20px;">
                                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
                            </svg>
                            </a>
                         
                            <h3 class="mb-5">Sign in</h3>
                            <form class="form-horizontal" action="2login.php" method="post">
                            <div class="form-outline mb-4">
                                <label class="form-label" for="typeEmailX-2">Username</label>
                                <input placeholder="Enter you username" name="username" type="text" id="typeEmailX-2" class="form-control form-control-lg" />
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label text-left" for="typePasswordX-2">Password</label>
                                <input placeholder="Enter your password" name="password" type="password" id="typePasswordX-2" class="form-control form-control-lg" />

                            </div>

                            <!-- Checkbox -->
                            <div class="form-check d-flex justify-content-start mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                                <label class="form-check-label" style="margin-left: 5px;" for="form1Example3"> Remember password </label>
                            </div>
                            <div class="d-grid gap-2 mx-auto">
                            <button class="btn btn-primary btn-lg btn-block " type="submit">Login</button>
                            </div>
                          
                            </form>
                            <hr class="my-4">

                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>