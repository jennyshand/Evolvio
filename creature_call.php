<?php
function creature_call()
{
    $username = $_SESSION["username"];

    $password = $_SESSION["password"];

    $conn = hsu_conn_sess($username, $password);

    $cr_in_env_call = 'begin :creatures := creatures_in_env(:env); end;';

    $cr_in_env_stmt = oci_parse($conn, $cr_in_env_call);

    $desired_env = strip_tags($_POST['desired_env']);

    oci_bind_by_name($cr_in_env_stmt, ":env",
                     $desired_env);

    oci_bind_by_name($cr_in_env_stmt, ":creatures",
                     $creatures, 50);
    oci_execute($cr_in_env_stmt, OCI_DEFAULT);
    ?>

    <p id="thing2"> <div> There are <?= $creatures ?> creature(s)
              in the <?= $desired_env ?> environment <br /> </div> </p>

    <?php
    oci_free_statement($cr_in_env_stmt);
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

