<?php
    function food_effect()
    {
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];

        $conn = hsu_conn_sess($username, $password);

        $creature_str = 'select cr_name
                           from creature';
        $creature_stmt = oci_parse($conn, $creature_str);

        oci_execute($creature_stmt, OCI_DEFAULT);
        ?>
        <form method="post"
              action="<?= htmlentities($_SERVER['PHP_SELF'],
                               ENT_QUOTES) ?>">
            <fieldset>
                <legend> Examine what effect a given food
                        will have on a given creature. </legend>
                <select name="creature" required="required">
                    <option value=""> Select a creature </option>
                <?php
                while (oci_fetch($creature_stmt))
                {
                    $curr_creature = oci_result($creature_stmt, 'CR_NAME');
                    ?>
                    <option value="<?= $curr_creature ?>" >
                         <?= $curr_creature ?> </option>
                    <?php
                }
                oci_free_statement($creature_stmt);
                ?>
                </select>

                <hr />

        <?php
        $food_str = 'select f_name
                           from food';
        $food_stmt = oci_parse($conn, $food_str);

        oci_execute($food_stmt, OCI_DEFAULT);
                ?>
                <select name="food" required="required">
                    <option value=""> Select a food </option>
                <?php
                while (oci_fetch($food_stmt))
                {
                    $curr_food = oci_result($food_stmt, 'F_NAME');
                    ?>
                    <option value="<?= $curr_food ?>" >
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

