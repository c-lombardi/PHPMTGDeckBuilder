<?php

?>
<input type="hidden" id="userID" value="<?php 
                                        $mode;
                                        if (isset($_GET['action']))
                                            $mode = $_GET['action'];
                                        if (isset($_SESSION['userID']) && !$admin && $mode == "viewDecks"){
                                            echo $_SESSION['userID'];
                                        } ?>"/>
<table>
</table>

<div style="width: 800px; margin: 0 auto;" data-bind="visible: Loading">
    <img src="Images/zan12.gif" width="350" height="256" />
</div>


<div style="">
    <div style="margin-top: 20px;" data-bind="template: { name: PageTemplate }"></div>
    <table class="table" style="text-align: center;">
        <thead data-bind="template: { name: HeaderTemplate }"></thead>
        <tbody data-bind="template: { name: BodyTemplate, foreach: pagedList }"></tbody>
    </table>
</div>
<script id="HeadTmpl" type="text/html">
    <tr class="header">
        <th data-bind="" style="text-align:center;"><h3>Deck Name</h3></th>
        <?php if($mode == "viewAllDecks"){ ?>
        <th class="" data-bind="" style="text-align:center;"><h3>Deck Owner</h3></th>
        <?php } ?>
    </tr>
</script>

<script id="itemsTmpl" type="text/html">
    <tr class="standard">
        <td style="font-size:large;" data-bind="text: DeckName"></td>
        <?php if($user && $mode!="viewAllDecks"){?>
        <td>
            <button class="btn btn-default" onclick="" data-bind="click: $parent.addToDeck">Add Cards</button></td>
        <td>
            <button class="btn btn-default" onclick="" data-bind="click: $parent.editDeck">Edit Deck</button></td>
        <td>
            <button class="btn btn-default" onclick="" data-bind="click: $parent.removeDeck" style="background-color: red;"><b>Delete Deck</b></button></td>
        <?php } else{ ?>
        <td style="font-size:large;" data-bind="text: 'By: ' + UserName"></td>
        <td>
            <button class="btn btn-default" onclick="" data-bind="click: $parent.viewDeck">View Deck</button></td>
        <?php } ?>
        <?php if($admin){?>
        <td>
            <button class="btn btn-default" onclick="" data-bind="click: $parent.removeDeck" style="background-color: red;"><b>Delete Deck</b></button></td>
        <?php } ?>
    </tr>
</script>

<script id="numberTmpl" type="text/html">
    <div style="padding-top: 3%; padding-bottom: 3%; text-align: center">
        <div style="margin: -3px 0.25em;" />
        <ul class="pagination pagination-lg">
            <li data-bind="css: { disabled: pageIndex() === 0 }"><a href="#" data-bind="	click: function () { moveToPage(0); }">First</a></li>

            <li data-bind="css: { disabled: pageIndex() === 0 }"><a href="#" data-bind="	click: previousPage">Prev</a></li>

            <li data-bind="css: { disabled: pageIndex() >= maxPageIndex() }"><a href="#" data-bind="	click: nextPage">Next</a></li>

            <li data-bind="css: { disabled: pageIndex() >= maxPageIndex() }"><a href="#" data-bind="	click: function () { moveToPage($root.maxPageIndex()); }">Last</a></li>
            <br />
            <!-- ko if: pageIndex() === maxPageIndex() && maxPageIndex() >= 3-->
            <li data-bind="visible: pageIndex() <= maxPageIndex()"><a href="#" data-bind="	text: $root.pageIndex() - 2, click: function () { moveToPage($root.pageIndex() - 3); }"></a></li>
            <!-- /ko -->

            <!-- ko if: pageIndex() > maxPageIndex()-2 && maxPageIndex() > 4-->
            <li data-bind="visible: pageIndex() <= maxPageIndex()"><a href="#" data-bind="	text: $root.pageIndex() - 3, click: function () { moveToPage($root.pageIndex() - 4); }"></a></li>
            <!-- /ko -->

            <li data-bind="visible: pageIndex() > 1"><a href="#" data-bind="	text: $root.pageIndex() - 1, click: function () { moveToPage($root.pageIndex() - 2); }"></a></li>
            <li data-bind="visible: pageIndex() > 0"><a href="#" data-bind="	text: $root.pageIndex(), click: function () { moveToPage($root.pageIndex() - 1); }"></a></li>

            <li data-bind="css: { active: true }"><a href="#" data-bind="	text: $root.pageIndex() + 1"></a></li>

            <li data-bind="visible: pageIndex() < maxPageIndex()"><a href="#" data-bind="	text: $root.pageIndex() + 2, click: function () { moveToPage($root.pageIndex() + 1); }"></a></li>
            <li data-bind="visible: pageIndex() < maxPageIndex() - 1"><a href="#" data-bind="	text: $root.pageIndex() + 3, click: function () { moveToPage($root.pageIndex() + 2); }"></a></li>

            <!-- ko if: pageIndex() === 0 && maxPageIndex() >= 3-->
            <li data-bind="visible: pageIndex() <= maxPageIndex() - 2"><a href="#" data-bind="	text: $root.pageIndex() + 4, click: function () { moveToPage($root.pageIndex() + 3); }"></a></li>
            <!-- /ko -->

            <!-- ko if: pageIndex() < 2 && maxPageIndex() >= 4-->
            <li data-bind="visible: pageIndex() <= maxPageIndex() - 3"><a href="#" data-bind="	text: $root.pageIndex() + 5, click: function () { moveToPage($root.pageIndex() + 4); }"></a></li>
            <!-- /ko -->
        </ul>
    </div>
</script>
<script>
    $(document).ready(function () {
        function Deck(DeckName, UserID, UserDeckID, UserName) {
            this.DeckName = DeckName;
            this.UserID = UserID;
            this.UserDeckID = UserDeckID;
            this.UserName = UserName;
        }
        Decks = new Array();
        $.ajax({
            url: "processViewDecks.php",
            type: "POST",
            data: { ID: $("#userID").val() },
            success: function (result) {
                var test = JSON.parse(result);
                for (var i = 0; i < test.length; i++) {
                    var d = new Deck(test[i].DeckName, test[i].UserID, test[i].UserDeckID, test[i].UserName);
                    Decks.push(d);
                }
                var vm = new DecksViewModel(Decks);
                ko.applyBindings(vm);
            }
        });
    });
</script>
<script>
    function DecksViewModel(records) {
        var self = this;
        self.editItem = ko.observable();
        self.Loading = ko.observable(true);
        self.Decks = ko.observableArray();
        self.selectedSize = ko.observable(10);
        self.PageCount = ([10, 25, 50, 100]);
        self.selectedSearch = ko.observable("Name");
        self.pageSize = ko.observable(self.selectedSize());
        self.pageIndex = ko.observable(0);
        self.selectedItem = ko.observable();


        self.Decks = ko.computed(function () {
            return ko.utils.arrayFilter(Decks, function (r) {
                return true;
            });
        });
        self.addToDeck = function (Deck) {
            window.location = "index.php?action=deck&DeckID=" + Deck.UserDeckID;
        };
        self.editDeck = function (Deck) {
            window.location = "index.php?action=deck&DeckID=" + Deck.UserDeckID + "&mode=1";
        };
        self.viewDeck = function (Deck) {
            window.location = "index.php?action=deck&DeckID=" + Deck.UserDeckID + "&mode=2";
        };
        self.removeDeck = function (Deck) {
            $.ajax({
                url: "removeDeck.php",
                data: { UserDeckID: Deck.UserDeckID },
                type: "POST",
            }).success(function (result) {
                if (result == true) {
                    window.location = 'index.php?action=viewDecks';
                    toastr.success('Deleted Deck ' + Deck.DeckName);
                }
            }).error(function () {
                toastr.warning("Error deleting Deck " + Deck.DeckName);
            });
        };
        self.pageSize.subscribe(function () {
            self.selectedSize();
        });

        self.BodyTemplate = function (item) {
            return item === self.editItem() ? 'editItemsTmpl' : 'itemsTmpl';
            //return 'itemsTmpl';
        };

        self.HeaderTemplate = function (item) {
            return 'HeadTmpl';
        };

        self.PageTemplate = function (item) {
            return 'numberTmpl';
        };

        //Paging
        self.pagedList = ko.dependentObservable(function () {
            var size = self.pageSize();
            var start = self.pageIndex() * size;
            self.Loading(false);
            return self.Decks().slice(start, start + size);
        });
        self.maxPageIndex = ko.dependentObservable(function () {
            return Math.ceil(self.Decks().length / self.pageSize()) - 1;
        });
        self.previousPage = function () {
            if (self.pageIndex() > 0) {
                self.pageIndex(self.pageIndex() - 1);
            }
        };
        self.nextPage = function () {
            if (self.pageIndex() < self.maxPageIndex()) {
                self.pageIndex(self.pageIndex() + 1);
            }
        };
        self.allPages = ko.dependentObservable(function () {
            var pages = [];
            for (i = 0; i <= self.maxPageIndex() ; i++) {
                pages.push({ pageNumber: (i + 1) });
            }
            return pages;
        });

        self.moveToPage = function (index) {
            self.pageIndex(index);
        };

        self.setPageSize = function () {
            self.pageSize(self.selectedSize());
            self.pageIndex(0);
        };
    };
</script>
