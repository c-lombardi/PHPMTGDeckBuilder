<?php
if (!empty($_GET['error']))
{
?><h1><?php echo $_GET['error']?></h1><?php
}
                                          ?>
<form class="navbar-form navbar-left" id="createForm" method="post" action="/MTGDeckBuilder/index.php?action=processCreateAccount">
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
            <td style="font-size:large">ConfirmPassword:</td>
            <td>
                <input type='password' name='ConfirmPassword' /></td>
        </tr>
        <tr>
            <td>
                <input type='submit' class="btn btn-default" value='Create Account' /></td>
        </tr>
    </table>
</form>

<script>
    $("#createForm").submit(function () {
        if (!($("input:password[name=Password]").val() === $("input:password[name=ConfirmPassword]").val())) {
            toastr.warning("Your passwords don't match");
            return false;
        }
    });
</script>
