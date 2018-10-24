<?php
    function add_food()
    {
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];

        $conn = hsu_conn_sess($username, $password);

        $env_str = 'select env_code, env_name
                           from environment';
        $env_stmt = oci_parse($conn, $env_str);

        oci_execute($env_stmt, OCI_DEFAULT);
        ?>
        <form method="post"
              action="<?= htmlentities($_SERVER['PHP_SELF'],
                               ENT_QUOTES) ?>">
            <fieldset>
                <legend> Pick an environment you would like to add a
                         food to </legend>
                <select name="environment" required="required">
                    <option value=""> Select an environment </option>
                <?php
                while (oci_fetch($env_stmt))
                {
                    $curr_env_num = oci_result($env_stmt, 'ENV_CODE');
                    $curr_env_name = oci_result($env_stmt, 'ENV_NAME');
                    ?>
                    <option value="<?= $curr_env_num ?>" >
                         <?= $curr_env_name ?> </option>
                    <?php
                }
                oci_free_statement($env_stmt);
                ?>
                </select>

                <hr />

        <?php
        $food_str = 'select f_name, food_id
                           from food';
        $food_stmt = oci_parse($conn, $food_str);

        oci_execute($food_stmt, OCI_DEFAULT);
                ?>
                <legend> Pick a food you would like to add to the environment
                </legend>
                <select name="food" required="required">
                    <option value=""> Select a food </option>
                <?php
                while (oci_fetch($food_stmt))
                {
                    $curr_food = oci_result($food_stmt, 'F_NAME');
                    $curr_food_id = oci_result($food_stmt, 'FOOD_ID');
                    ?>
                    <option value="<?= $curr_food_id ?>" >
                         <?= $curr_food ?> </option>
                    <?php
                }
                oci_free_statement($food_stmt);
                ?>
                </select>
                <hr />
                <input type="submit" />
            </fieldset>

            <hr />
        </form>
        <?php
        oci_close($conn);
    }
?>

