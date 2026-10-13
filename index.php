<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Klinik Meow | Home</title>


    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">


    <!-- Font Awesome -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }


        body {
            min-height: 100vh;

            background: #f4f6f9;

            display: flex;

            justify-content: center;

            align-items: center;
        }


        /* =========================
           MAIN CONTAINER
        ========================= */

        .home-container {

            width: 90%;

            max-width: 1100px;

            min-height: 600px;

            background: white;

            border-radius: 25px;

            box-shadow: 0 8px 30px rgba(0,0,0,.10);

            display: flex;

            overflow: hidden;
        }


        /* =========================
           LEFT SIDE
        ========================= */

        .home-left {

            width: 50%;

            background: #0D3043;

            color: white;

            display: flex;

            flex-direction: column;

            justify-content: center;

            align-items: center;

            text-align: center;

            padding: 50px;
        }


        .home-left i {

            font-size: 80px;

            margin-bottom: 25px;
        }


        .home-left h1 {

            font-size: 42px;

            margin-bottom: 10px;
        }


        .home-left p {

            font-size: 16px;

            opacity: .9;

            line-height: 1.7;
        }


        /* =========================
           RIGHT SIDE
        ========================= */

        .home-right {

            width: 50%;

            display: flex;

            flex-direction: column;

            justify-content: center;

            align-items: center;

            text-align: center;

            padding: 50px;
        }


        .home-right h2 {

            color: #0D3043;

            font-size: 30px;

            margin-bottom: 10px;
        }


        .home-right p {

            color: #777;

            font-size: 15px;

            margin-bottom: 30px;
        }


        /* =========================
           CAT IMAGE
        ========================= */

        .cat-image {

            width: 220px;

            height: 220px;

            object-fit: cover;

            border-radius: 50%;

            margin-bottom: 25px;

            box-shadow: 0 5px 20px rgba(0,0,0,.15);
        }


        /* =========================
           LOGIN BUTTON
        ========================= */

        .login-button {

            display: inline-block;

            padding: 14px 50px;

            background: #0D3043;

            color: white;

            text-decoration: none;

            border-radius: 10px;

            font-size: 16px;

            font-weight: 600;

            transition: .3s;
        }


        .login-button:hover {

            background: #234a91;

            transform: translateY(-2px);

            box-shadow: 0 5px 15px rgba(46,90,172,.25);
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 700px) {

            .home-container {

                flex-direction: column;
            }


            .home-left,
            .home-right {

                width: 100%;
            }


            .home-left {

                padding: 40px 25px;
            }


            .home-left h1 {

                font-size: 32px;
            }


            .cat-image {

                width: 170px;

                height: 170px;
            }

        }

    </style>

</head>


<body>


<div class="home-container">


    <!-- =========================
         LEFT SIDE
    ========================= -->

    <div class="home-left">

        <i class="fa-solid fa-cat"></i>

        <h1>Klinik Meow</h1>

        <p>
            Cat Medicine Inventory<br>
            Management System
        </p>

    </div>



    <!-- =========================
         RIGHT SIDE
    ========================= -->

    <div class="home-right">


        <!-- CAT IMAGE -->

        <img
            src="assets/images/cat.jpg"
            alt="Klinik Meow Cat"
            class="cat-image"
        >


        <h2>Welcome to Klinik Meow</h2>

        <p>
            Manage cat medicine inventory
            efficiently and securely.
        </p>


        <!-- LOGIN -->

       
<a href="login.php" class="login-button">
    Login
</a>

    </div>


</div>


</body>

</html>