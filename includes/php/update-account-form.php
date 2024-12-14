<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
        <legend>Update Account</legend>
        UPDATE user SET
        <select name="current-attribute-name" id="current-attribute">
            <option value="app_name">app name</option>
            <option>url</option>
            <option>password</option>
            <option>comment</option>
            <option>username</option>
        </select>
        = <input type="text" name="new-attribute" required> WHERE
        <select name="query-attribute" id="query-attribute">
            <option value="app_name">app name</option>
            <option value="">url</option>
        </select>
        = <input type="text" name="pattern" required>
        <input type="hidden" name="submitted" value="6">
        <p><input type="submit" value="update-account"></p>
    </fieldset>
</form>