<?php

?>

<form class="navbar-form navbar-left" method="post" action="/MTGDeckBuilder/index.php?action=processLogin">
    <table class="table">
        <tr>
            <td style="font-size:large">UserName:</td>
            <td>
                <input type='text' name='UserName' /></td>
        </tr>
        <tr>
            <td style="font-size:large">Password:</td>
            <td>
                <input type='password' name='Password' /></td>
        </tr>
        <tr>
            <td>
                <input type='submit' class="btn btn-default" value='Login' /></td>
        </tr>
    </table>
</form>
