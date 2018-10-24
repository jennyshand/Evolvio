<?php
    function create_dropdown()
    {
        if (array_key_exists("username", $_POST) )
        {


            $username = strip_tags($_POST['username']);

            $password = $_POST['password'];

            $_SESSION['username'] = $username;

            $_SESSION['password'] = $password;
         }
         elseif (array_key_exists("username", $_SESSION) )
         {

            $username = $_SESSION['username'];

            $password = $_SESSION['password'];
         }
         else
         {
                ?>
                <p> Need a valid username and password! </p>

                <hr />

        </body>
        </html>

                <?php
                session_destroy();
                exit;
         }


            $db_conn_str =
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";

        // let's try to connect and log into Oracle using this

            $conn = oci_connect($username, $password, $db_conn_str);

        // exiting if connection/log in failed

            if (! $conn)
            {
                ?>
                <p> Could not log into Oracle, sorry </p>
    </body>
    </html>

                <?php
                session_destroy();
                exit;
            }

            $password = NULL;
            ?>
            <form method="post"
                  action="<?= htmlentities($_SERVER['PHP_SELF'],
                                   ENT_QUOTES) ?>">
                <fieldset>
                    <legend> What would you like to do? </legend>
                    <select name="desired_choice">
                        <option value=""> Select an option </option>
                        <option value="creatures" >
                            Examine how many creatures are in an environment </option>
                        <option value="food_effect" >
                            Examine what effect a food has on a creature </option>
                        <option value="insert">
                            Add a food to an environment </option>
                    </select>
                <hr />
                <input type="submit" value="submit choice" />
                </fieldset>
            </form>

            <?php
            oci_close($conn);
    }

?>

