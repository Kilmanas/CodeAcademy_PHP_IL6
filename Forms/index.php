<html>
<head>
    <title>Musu title</title>
</head>
<body>
<!--        <div class="header">-->
<!--            <ul>-->
<!--                <li><a href="#">Home</a></li>-->
<!--                <li><a href="#">Kiti</a></li>-->
<!--                <li><a href="#">About</a></li>-->
<!--            </ul>-->
<!--        </div>-->
<div class="content">
    <h2>Prisijungti</h2>
    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="vardenis@domenas.lt">
        <input type="password" name="password" placeholder="******">
        <input type="submit" value="Prisijungti">
    </form>
    <hr>
    <h2>Registration</h2>
    <!--            <p>me speak no latino</p>-->
    <form action="registration.php" method="post">

       <input type="text" name="first_name" placeholder="Vardas"><br>
        <input type="text" name="last_name" placeholder="Pavarde"><br>
        <input type="email" name="email" placeholder="El. pastas"><br>
        <input type="password" name="password1" placeholder="Slaptazodis"><br>
        <input type="password" name="password2" placeholder="Pakartoti slaptazodi"><br>
        <Label for="agree_terms">Sutinku su registracijos taisyklemis</Label>
        <input type="checkbox" name="agree_terms" id="agree_terms"><br><br>
        <input type="submit" value="Registruotis" />

    </form>
</div>
</body>
</html>
