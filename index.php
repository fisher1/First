<html>
    <head>
        <title></title>
        <meta content="">
        <style></style>
    </head>
    <body>
        <?php
        include("Animal.php");
        $animal = new Animal();
        $animal->getresult(4, 8);
        if (2 == 2) {
            echo 8;
        }
        for($i=0;$i<10;$i++){
            echo $i."</br>";
        }
        ?>
    </body>
</html>