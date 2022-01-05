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
            <h1>Calculator</h1>
<!--            <p>me speak no latino</p>-->
            <form action="functions.php" method="post">
                <input type="number" name="number1" placeholder="Pirmas skaičius">
                <input type="number" name="number2" placeholder="Antras skaičius">
                <select name="veiksmas">
                    <option value="+">sudėtis</option>
                    <option value="-">atimtis</option>
                    <option value="*">daugyba</option>
                    <option value="/">dalyba</option>
                </select>
                <input type="submit" value="OK" name="submit" />

            </form>
        </div>
    </body>
</html>
