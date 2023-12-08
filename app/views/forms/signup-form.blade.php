<form method="post">
    <div>
        <label>
            First Name
            <input type="text" name="firstname" placeholder="Enter your first name" required maxlength="20" autofocus>
        </label>
    </div>

    <div>
        <label>
            Last Name
            <input type="text" name="lastname" placeholder="Enter your last name" required maxlength="20">
        </label>
    </div>

    <div>
        <label>
            Username
            <input type="text" name="username" placeholder="Enter your username" required maxlength="30">
        </label>
    </div>

    <div>
        <label>
            Password
            <input type="password" name="password" placeholder="Enter your password" required minlength="6" maxlength="30">
        </label>
    </div>

    <div>
        <label>
            Confirm Password
            <input type="password" name="confirm_password" placeholder="Re-enter your password" required minlength="6" maxlength="30">
        </label>
    </div>

    <div>
        <label>
            Address Line 1
            <input type="text" name="address_line_1" placeholder="Enter your address" required maxlength="30">
        </label>
    </div>

    <div>
        <label>
            Address Line 2
            <input type="text" name="address_line_2" placeholder="Enter your address" required maxlength="30">
        </label>
    </div>

    <div>
        <label>
            City
            <input type="text" name="address_city" placeholder="Enter your city" required maxlength="30">
        </label>
    </div>

    <div>
        <label>
            Telephone
            <input type="text" name="telephone" placeholder="Enter your telephone" required minlength="10" maxlength="10">
        </label>
    </div>

    <div>
        <label>
            Mobile Number
            <input type="text" name="mobile_number" placeholder="Enter your mobile number" required minlength="10" maxlength="10">
        </label>
    </div>

    <div>
        <input type="submit" value="Sign Up" class="btn primary">
    </div>
</form>