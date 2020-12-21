<form id='forms'>
    <p>Login: min length 3, only letters, start with capital (^[A-Z][a-z]{2,}$)</p>
    <p>Email: no whitespace, @, no whitespace , . , no whitespace (^\S+@\S+\.\S+$)</p>
    <p>Passwd: min length 8, atleast: 1 capital, 1 lower, 1 digit and 1 special (^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)</p>

    <input type='text' placeholder='Login' name='login' required>
    <br>
    <input type='email' placeholder='Email' name='email' required>
    <br>
    <input type='password' placeholder='Password' name='passwd' required>
    <br>
    <input type='password' placeholder='Again Password' name='passwdAgain' required>
    <br>
    <input id='formUrl' type="submit" value="ok" name="server/UM/userCreation.php">
</form>