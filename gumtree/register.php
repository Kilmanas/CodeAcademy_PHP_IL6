<?php
include 'parts/header.php'; ?>
<form action="user.php" method="post">
        <input type="text" name="name" placeholder="Name"><br>
        <input type="text" name="lastName" placeholder="Last name"><br>
        <input type="email" name="email" placeholder="Email"><br>
        <input type="password" name="password1" placeholder="Password"><br>
        <input type="password" name="password2" placeholder="Repeat password"><br>
        <input type="tel" name="phone" placeholder="Phone"><br>
        <input type="submit" value="create" name="create">
    </form>
<?php
include 'parts/footer.php'; ?>

