<?php
function add_food_call()
{
    $username = $_SESSION["username"];

    $password = $_SESSION["password"];

    $conn = hsu_conn_sess($username, $password);

    $environment = strip_tags($_POST['environment']);
    $food = strip_tags($_POST['food']);

    $_SESSION['environment'] = $environment;
    $_SESSION['food'] = $food;

    $insert_food_str = 'insert into env_has_food
                        values
                        (:environment, :food)';

    $insert_stmt = oci_parse($conn, $insert_food_str);

    oci_bind_by_name($insert_stmt, ":environment",
                     $environment);

    oci_bind_by_name($insert_stmt, ":food",
                     $food);

    $env_str = 'select env_name
                from environment
                where env_code = :environment';
    $env_stmt = oci_parse($conn, $env_str);

    oci_bind_by_name($env_stmt, ":environment",
                     $environment);

    oci_execute($env_stmt, OCI_DEFAULT);
    oci_fetch($env_stmt);
    $env_name = oci_result($env_stmt, 'ENV_NAME');

    $food_str = 'select f_name
                 from food
                 where food_id = :food';
    $food_stmt = oci_parse($conn, $food_str);

    oci_bind_by_name($food_stmt, ":food",
                     $food);

    oci_execute($food_stmt, OCI_DEFAULT);
    oci_fetch($food_stmt);
    $food_name = oci_result($food_stmt, 'F_NAME');


    $num_inserted = oci_execute($insert_stmt, OCI_DEFAULT);
    oci_commit($conn);
        if ($num_inserted == 0)
        {
            ?>
            <p> SORRY, no food was added! </p>
            <?php
        }
        else
        {
            ?>
            <p> <?= $food_name ?> was added to <?= $env_name ?>  </p>
            <?php

            oci_commit($conn);
        }

    oci_free_statement($insert_stmt);
    oci_close($conn);
    ?>

    <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>"" method="post">
         Would you like to do something else?
         <button name="finish" type="submit" value="goback"> Do another thing </button>
         <button name="finish" type="submit" value="done"> I'm done </button>
    </form>

    <?php
}
?>
