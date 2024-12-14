<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
        <legend>Insert Account</legend>
        INSERT INTO accounts VALUES (
        <input type="text" name="app_name" placeholder="Application Name" required>,
        <input type="text" name="url" placeholder="URL">,
        <textarea type="text" name="comment" placeholder="Comment"></textarea>,
        <?php
            $rows = getUsernames();
            echo '<select name="username" id="username">';
                echo '<option value="" disabled selected>Select Username</option>';
            foreach ($rows as $row) {
                echo '<option>'.$row["username"].'</option>';
            }
            echo '</select>';
        ?>
        <input type="password" name="password" placeholder="Password" required>
        );
        <input type="hidden" name="submitted" value="5">
        <p><input type="submit" value="insert-account"></p>
    </fieldset>
</form>



