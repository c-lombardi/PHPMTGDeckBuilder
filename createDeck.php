<?php

?>
<form id="createDeckForm" action="index.php?action=processCreateDeck" method="post">
    <table class="table">
        <tr>
            <td style="font-size:large">Deck Name:
                <input type="text" name="DeckName" placeholder="Name of Deck" /></td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-default" type="submit" value="Create Deck" /></td>
        </tr>
    </table>
</form>

<script>
    $("#createDeckForm").submit(function () {
        if (($("input:text[name=DeckName]").val().length > 19)) {
            toastr.warning("Your Deck Name must be under 20 characters.");
            return false;
        }
        if (/^[a-zA-Z0-9- ]*$/.test($("input:text[name=DeckName]").val()) == false) {
            toastr.warning("Your Deck Name contains illegial characters.");
            return false;
        }
    });
</script>
