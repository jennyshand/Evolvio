<?php
    function cr_in_env()
    {
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];

        $conn = hsu_conn_sess($username, $password);

        $environment_str = 'select env_name
                           from environment';
        $environment_stmt = oci_parse($conn, $environment_str);

        oci_execute($environment_stmt, OCI_DEFAULT);
        ?>
        <form method="post"
              action="<?= htmlentities($_SERVER['PHP_SELF'],
                               ENT_QUOTES) ?>">
            <fieldset>
                <legend> What environment would you like to examine? </legend>
                <select name="desired_env" required="required" >
                    <option value=""> Select an environment </option>
                <?php
                while (oci_fetch($environment_stmt))
                {
                    $curr_env = oci_result($environment_stmt, 'ENV_NAME');
                    ?>
                    <option value="<?= $curr_env ?>" >
                         <?= $curr_env ?> </option>
                    <?php
                }
                oci_free_statement($environment_stmt);
                ?>
                </select>

                <hr />
                <input type="submit" />
            </fieldset>
        </form>

        <?php
        oci_close($conn);
    }
?>

