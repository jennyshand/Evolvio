<?php
function get_effect()
{
    $username = $_SESSION["username"];

    $password = $_SESSION["password"];

    $conn = hsu_conn_sess($username, $password);

    $food_effect_call = 'begin :effect := food_effect(:crt, :food); end;';

    $food_effect_stmt = oci_parse($conn, $food_effect_call);

    $creature = strip_tags($_POST['creature']);

    $food = strip_tags($_POST['food']);

    oci_bind_by_name($food_effect_stmt, ":crt",
                     $creature);

    oci_bind_by_name($food_effect_stmt, ":food",
                     $food);

    oci_bind_by_name($food_effect_stmt, ":effect",
                     $effect, 50);
    oci_execute($food_effect_stmt, OCI_DEFAULT);
    ?>

    <?php
    oci_free_statement($food_effect_stmt);
    oci_close($conn);
    ?>


    <p id="effect"> <?= $effect ?></p>

    <p id="thing"> <?= $food ?> effect on <?= $creature ?> is: <div id="effect2"></div> </p>

    <p>
       <button id="seeEffect">
            Get Effect </button> <br />
    </p>


    <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"" method="post">
         Would you like to do something else?
         <button name="finish" type="submit" value="goback"> Do another thing </button>
         <button name="finish" type="submit" value="done"> I'm done </button>
    </form>

    <?php
}
?>

