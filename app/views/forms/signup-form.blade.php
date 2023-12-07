<form method="post">
    <div>
        <label>
            First Name
            <input type="text" name="firstname" required maxlength="20" autofocus>
        </label>
    </div>

    <div>
        <label>
            Last Name
            <input type="text" name="lastname" required maxlength="20">
        </label>
    </div>

    <div>
        <label>
            Username
            <input type="text" name="username" required maxlength="30">
        </label>
    </div>

    <div>
        <label>
            Password
            <input type="password" name="password" required minlength="6" maxlength="30">
        </label>
    </div>

    <div>
        <label>
            Confirm Password
            <input type="password" name="confirm_password" required minlength="6" maxlength="30">
        </label>
    </div>

    <div>
        <label>
            Address Line 1
            <input type="text" name="address_line_1" required maxlength="30">
        </label>
    </div>

    <div>
        <label>
            Address Line 2
            <input type="text" name="address_line_2" required maxlength="30">
        </label>
    </div>

    <div>
        <label>
            City
            <input type="text" name="address_city" required maxlength="30">
        </label>
    </div>

    <div>
        <label>
            Telephone
            <input type="text" name="telephone" required minlength="10" maxlength="10">
        </label>
    </div>

    <div>
        <label>
            Mobile Number
            <input type="text" name="mobile_number" required minlength="10" maxlength="10">
        </label>
    </div>

    <div>
        <input type="submit" value="Sign Up">
    </div>
</form>