<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <title>BallotBoxx – Your Voice. Your Vote. Your Campus.</title>
    <meta name="description" content="BallotBoxx is a secure online voting platform built for campus elections – from departments to SRC. Experience fast, fair, and transparent voting.">
    <meta name="keywords" content="campus voting, online voting, student elections, faculty elections, SRC, BallotBoxx, vote online, Ghana universities elections, secure voting app">
    <meta name="author" content="BallotBoxx Team">

    <!-- Open Graph (Social Sharing) -->
    <meta property="og:title" content="BallotBoxx – Your Voice. Your Vote. Your Campus.">
    <meta property="og:description" content="Secure campus election platform for department, faculty, and SRC voting. Free, fair, fast.">
    <meta property="og:image" content="https://yourdomain.com/images/ballotboxx-share.png"> <!-- Replace with your logo or hero image URL -->
    <meta property="og:url" content="https://yourdomain.com">
    <meta property="og:type" content="website">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="BallotBoxx – Campus Voting App">
    <meta name="twitter:description" content="Vote easily in your campus elections with BallotBoxx. Transparent and reliable voting for students.">
    <meta name="twitter:image" content="https://yourdomain.com/images/ballotboxx-share.png">
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <div class="grid_two">
        <div class="grid_pic">
            
        </div>
        <div class="grid_one">

            <div class="logo_name">
                <div class="logo"></div>
                <h1>Ballotboxx</h1>
                <br>
                <div class="tagline">
                    <h2>Your Voice. Your Vote. Your Campus.</h2>
                </div>
                <div class="buttons_flex">
                    <a href="./admin/login.php">
                        <button>Login (Admin)</button>
                    </a>
                    <a href="./students/login.php">
                        <button>Login (Student)</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    .grid_two {
    
        display: grid;
        grid-template-columns: 2fr 1fr;
        height: 100vh;
    }

    .grid_pic{
        background-image: url(./images/index.jpg);
        height: 100vh;
        background-position: center;
        background-size: cover;
    }
    .grid_one{
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 0 5%;
        text-align: center;
    }
    .logo_name{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
</style>

</html>