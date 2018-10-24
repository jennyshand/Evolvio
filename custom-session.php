<?php
    session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
   Jenny Shand
   5/1/18
   URL: http://nrs-projects.humboldt.edu/~jes1098/328hw12/custom-session2.php
-->

<head>
    <title> Evolvio </title>
    <meta charset="utf-8" />

    <?php
        require_once("create_login.php");
        require_once("create_dropdown3.php");
        require_once("custom_call.php");
        require_once("custom_session1.php");
        require_once("add_food.php");
        require_once("add_food_call.php");
        require_once("destroy_and_exit.php");
        require_once("hsu_conn_sess.php");
        require_once("creature_call.php");
        require_once("effect_call.php");
    ?>

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />

    <link href="custom.css"
          type="text/css" rel="stylesheet" />

    <script src="whatEffect.js" type="text/javascript" async="async">
    </script>

</head>

<body>
    <h1> Evolvio </h1>

    <h2> Jenny Shand </h2>

    <h3> CS 328 </h3>

    <?php
    if (! array_key_exists('next-stage', $_SESSION))
    {
        create_login();
        $_SESSION['next-stage'] = "choices";
    }
    elseif ($_SESSION['next-stage'] == "choices")
    {
        create_dropdown();
        $_SESSION['next-stage'] = "choice_made";
    }
    elseif (($_SESSION['next-stage'] == "choice_made") &&
             array_key_exists("desired_choice", $_POST))
    {
        if($_POST['desired_choice'] == "creatures")
        {
             cr_in_env();
             $_SESSION['next-stage'] = "creature_call";
        }
        elseif ($_POST['desired_choice'] == "food_effect")
        {
             food_effect();
             $_SESSION['next-stage'] = "effect_call";
        }
        elseif ($_POST['desired_choice'] == "insert")
        {
            add_food();
            $_SESSION['next-stage'] = "add_food";
        }
        else
        {
            ?>
            <p> <a href="custom-session2.php"> Please pick a choice. </a> </p>
            <?php

            $_SESSION['next-stage'] = "choices";
        }
    }
    elseif($_SESSION['next-stage'] == "creature_call")
    {
        creature_call();
        $_SESSION['next-stage'] = "is_user_done";
    }
    elseif($_SESSION['next-stage'] == "effect_call")
    {
        get_effect();
        $_SESSION['next-stage'] = "is_user_done";
    }
    elseif($_SESSION['next-stage'] == "add_food")
    {
        add_food_call();
        $_SESSION['next-stage'] = "is_user_done";
    }

    elseif ($_SESSION['next-stage'] == "is_user_done")
    {
        if($_POST['finish'] == "goback")
        {
            create_dropdown();
            $_SESSION['next-stage'] = "choice_made";
        }
        else
        {
            session_destroy();
            session_regenerate_id(TRUE);
            session_start();

            create_login();
            $_SESSION['next-stage'] = "choices";
        }
    }

    // I hope to never reach here...!

    else
    {
        ?>
        <p> <strong> YIKES! should NOT have been able to reach
            here! </strong> </p>
        <?php

        session_destroy();
        session_regenerate_id(TRUE);
        session_start();

        create_login();
        $_SESSION['next-stage'] = "choices";
    }
    require_once("328footer.html");
?>

</body>
</html>

