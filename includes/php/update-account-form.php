<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
        <legend>Update Account</legend>
        UPDATE user SET
        <select name="current-attribute-name" id="update-account-current-attribute">
            <option value="app_name">app name</option>
            <option>url</option>
            <option>password</option>
            <option>comment</option>
            <option>username</option>
        </select>
        = <input type="text" name="new-attribute" id="update-account-attribute-input"">
        <?php
            $rows = getUsernames();
            echo '<select name="new-attribute" id="update-account-attribute-username" disabled>';
            echo '<option value="" disabled selected>Select Username</option>';
            foreach ($rows as $row) {
                echo '<option>'.$row["username"].'</option>';
            }
            echo '</select>';
        ?>
        WHERE
        <select name="query-attribute" id="query-attribute">
            <option value="app_name">app name</option>
            <option>url</option>
            <option>password</option>
            <option>comment</option>
        </select>
        = <input type="text" name="pattern" required>
        <input type="hidden" name="submitted" value="6">
        <p><input type="submit" value="update-account"></p>
    </fieldset>
    <script type="text/javascript" src="/includes/scripts/updateAccount.js"></script>
</form>