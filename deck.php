<?php
$mode = -1;
if (isset($_GET['mode']))
    $mode = $_GET['mode'];
if (isset($_GET['DeckID']))
    $DeckID = $_GET['DeckID'];
?>
<style>
    table tr:nth-child(2n+1) {
        background-color: lightgray;
    }
</style>
<input type="hidden" id="UserDeckID" value="<?php echo $DeckID;?>" />
<input type="hidden" id="UserID" value="<?php echo $_SESSION['userID'];?>"/>
<input type="hidden" id ="Edit" value="<?php echo $mode ?>" />
<div class="input-group input-group-lg">
    <span class="input-group-addon">
        <input id="txtSearch" class="form-control" placeholder="Search Name/Ability/Rule/Set..." data-bind="value: searchTerm" />
    </span>

    <span class="input-group-addon">
        <input type="checkbox" id="Red" data-bind="checked: $root.filterRed" />Red
    <input type="checkbox" id="Green" data-bind="checked: $root.filterGreen" />Green
    <input type="checkbox" id="Blue" data-bind="checked: $root.filterBlue " />Blue
    <input type="checkbox" id="White" data-bind="checked: $root.filterWhite" />White
    <input type="checkbox" id="Black" data-bind="checked: $root.filterBlack" />Black
    <input type="checkbox" id="X" data-bind="checked: $root.filterX" />X
    <input type="checkbox" id="UnColored" data-bind="checked: $root.filterUncolored" />UnColored
    </span>

</div>
<div class="input-group input-group-lg">
    <span class="input-group-addon">
        <form>
            <input type="radio" name="rarityGroup" value="1" data-bind="checked: selectedRarityID" />UnCommon
            <input type="radio" name="rarityGroup" value="2" data-bind="checked: selectedRarityID" />Common
            <input type="radio" name="rarityGroup" value="3" data-bind="checked: selectedRarityID" />Rare
            <input type="radio" name="rarityGroup" value="4" data-bind="checked: selectedRarityID" />Mythic-Rare
            <input type="radio" name="rarityGroup" value="5" data-bind="checked: selectedRarityID" />Timeshifted
        </form>
    </span>
    <span class="input-group-addon">
        <input type="checkbox" id="Checkbox1" data-bind="checked: $root.filterNotRed" />Not Red
    <input type="checkbox" id="Checkbox2" data-bind="checked: $root.filterNotGreen" />Not Green
    <input type="checkbox" id="Checkbox3" data-bind="checked: $root.filterNotBlue " />Not Blue
    <input type="checkbox" id="Checkbox4" data-bind="checked: $root.filterNotWhite" />Not White
    <input type="checkbox" id="Checkbox5" data-bind="checked: $root.filterNotBlack" />Not Black
    <input type="checkbox" id="Checkbox6" data-bind="checked: $root.filterNotX" />Not X
    <input type="checkbox" id="Checkbox7" data-bind="checked: $root.filterNotUncolored" />Not UnColored
    </span>
</div>
<div style="width: 800px; margin: 0 auto; text-align:center;" data-bind="visible: Loading">
    <img src="Images/zan12.gif" width="350" height="256" />
</div>

<div style="">
    <div style="margin-top: 20px;" data-bind="template: { name: PageTemplate }"></div>
    <?php if($mode == 2) {?>
    <div class="panel-heading" style="text-align: center;font-size:x-large;" id="UserName"></div>
    <?php } ?>
    <table class="table">
        <thead data-bind="template: { name: HeaderTemplate }"></thead>
        <tbody data-bind="template: { name: BodyTemplate, foreach: pagedList }"></tbody>
    </table>
</div>
<?php if ($user && ($mode == 1 || $mode == 2)){?>
<form class="navbar-form navbar-left" id="addPostForm" action="createPost.php" method="post">
    <input class="form-control" type="text" name="Subject" placeholder="Subject" />
    <input class="form-control" type="text" name="Body" placeholder="Body" />
    <input type="submit" class="btn btn-default" value="Submit Post" />
    <input type="hidden" name="UserDeckID" value="<?php echo $DeckID;?>" />
    <input type="hidden" name="UserID" value="<?php echo $_SESSION['userID'];?>"/>
</form>
<br />
<br />
<br />
<?php } ?>
<div>
    <ul data-bind="template: {name: PostTemplate, foreach:Posts}"></ul>
</div>
<script id="postTmpl" type="text/html">
    <div class="list-group">
        <li class="list-group-item list-group-item-info" style="font-size: x-large; font-weight: 500" data-bind="text: UserName"></li>
        <li class="list-group-item" style="font-size: large" data-bind="text: moment(DatePosted).format('MMMM Do YYYY, h:mm:ss a')"></li>
        <li class="list-group-item" style="font-size: large" data-bind="text: Subject"></li>
        <li class="list-group-item" style="font-size: large" data-bind="text: Body"></li>
        <?php if($admin){ ?>
        <li class="list-group-item list-group-item-danger">
            <button class="btn btn-default" style="background-color: red; font-size: large;" data-bind="click : $parent.removePost"><b>Delete Post</b></button></li>
        <?php } ?>
        <!-- ko if: $data.UserID == <?php if($user) {echo $_SESSION['userID'];} else{ echo -1; } ?> -->
        <li class="list-group-item list-group-item-danger">
            <button class="btn btn-default" style="background-color: red; font-size: large;" data-bind="click: $parent.removePost"><b>Delete Post</b></button></li>
        <!-- /ko -->
    </div>
</script>
<script id="HeadTmpl" type="text/html">
    <tr>
        <th style="font-size:larger">Name</th>
        <th style="font-size:larger">Set</th>
        <th style="font-size:larger">Ability</th>
        <th style="font-size:larger">Toughness</th>
        <th style="font-size:larger">Power</th>
        <th style="font-size:larger">Loyalty</th>
        <th style="font-size:larger">Costs</th>
        <th style="font-size:larger">Rarity</th>
        <th style="font-size:larger">Rule</th>
        <?php if($user){
                  if (!empty($DeckID) && $mode != "1" && $mode != "2"){?>?>
            <th>Add To Deck</th>
        <?php }
                  if($mode == "1"){?>
        <th>Remove From Deck</th>
        <?php }
              } ?>
    </tr>
</script>

<script id="itemsTmpl" type="text/html">
    <tr class="standard">
        <td style="font-size: large;" data-bind="text: Name"></td>
        <td style="font-size: large;" data-bind="text: SetID"></td>
        <td style="font-size: large;" data-bind="text: Ability"></td>
        <td style="font-size: large;" data-bind="text: Toughness"></td>
        <td style="font-size: large;" data-bind="text: Power"></td>
        <td style="font-size: large;" data-bind="text: Loyalty"></td>
        <td style="font-size: large;" data-bind="text: Costs"></td>
        <!--ko if: RarityID == 1-->
        <td style="font-size: large;" data-bind="">UnCommon</td>
        <!-- /ko -->
        <!--ko if: RarityID == 2-->
        <td style="font-size: large;" data-bind="">Common</td>
        <!-- /ko -->
        <!--ko if: RarityID == 3-->
        <td style="font-size: large;" data-bind="">Rare</td>
        <!-- /ko -->
        <!--ko if: RarityID == 4-->
        <td style="font-size: large;" data-bind="">Mythic-Rare</td>
        <!-- /ko -->
        <!--ko if: RarityID == 5-->
        <td style="font-size: large;" data-bind="">Timeshifted</td>
        <!-- /ko -->
        <td style="font-size: large;" data-bind="text: Rule"></td>
        <?php if($user){
                  if (!empty($DeckID) && $mode != "1" && $mode != "2"){?>
        <td style="font-size: large;">
            <button class="btn btn-default" style="background-color:green; font-weight:900; font-size:large" onclick="" data-bind="click: $parent.addCardToDeck">Add</button></td>
        <?php }
                  if($mode == "1"){?>
        <td style="font-size: large;">
            <button class="btn btn-default" style="background-color:red; font-weight:900; font-size:large;" onclick="" data-bind="click: $parent.removeCardFromDeck.bind($parent)">Remove</button></td>
        <?php }
              } ?>
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

<script type="text/javascript">
    $("#addPostForm").submit(function () {
        if (($("input:text[name=Subject]").val().length > 50)) {
            toastr.warning("Your Subject must be 50 characters or less.");
            return false;
        }
    });
    function addCardToDeckById(CardID) {
        alert("ID IS: " + CardID);
    }
    $(document).ready(function () {
        function Card(CardID, Name, Ability, Toughness, Power, Loyalty, Costs, RarityID, Rule, SetID) {
            this.CardID = CardID;
            this.Name = Name;
            this.Ability = Ability;
            this.Toughness = Toughness;
            this.Power = Power;
            this.Loyalty = Loyalty;
            this.Costs = Costs;
            this.RarityID = RarityID;
            this.Rule = Rule;
            this.SetID = SetID;
        }
        function Post(UserPostID, UserDeckID, UserName, UserID, Subject, Body, DatePosted) {
            this.UserPostID = UserPostID;
            this.UserDeckID = UserDeckID;
            this.UserName = UserName;
            this.UserID = UserID;
            this.Subject = Subject;
            this.Body = Body;
            this.DatePosted = DatePosted;
        }
        Cards = new Array();
        Posts = new Array();
        var data = { DeckID: $("#UserDeckID").val() };
        if ($("#Edit").val() == 1 || $("#Edit").val() == 2) {
            $.ajax({
                url: "getCards.php",
                type: "POST",
                data: data,
                async: false,
                success: function (result) {
                    var test = JSON.parse(result);
                    for (var i = 0; i < test.length; i++) {
                        var c = new Card(test[i].CardID, test[i].Name, test[i].Ability, test[i].Toughness, test[i].Power, test[i].Loyalty, test[i].Costs, test[i].RarityID, test[i].Rule, test[i].SetID);
                        Cards.push(c);
                    }
                }
            });
            var postData = { DeckID: $("#UserDeckID").val(), UserID: $("#UserID").val() };
            $.ajax({
                url: "getPostsForDeck.php",
                type: "POST",
                data: postData,
                async: false,
                success: function (result) {
                    var test = JSON.parse(result);
                    for (var i = 0; i < test.length; i++) {
                        var p = new Post(test[i].UserPostID, test[i].UserDeckID, test[i].UserName, test[i].UserID, test[i].Subject, test[i].Body, test[i].DatePosted);
                        Posts.push(p);
                    }
                },
            });
            var vm = new CardsViewModel(Cards, Posts);
            ko.applyBindings(vm);

            $.ajax({
                url: "getUserName.php",
                type: "POST",
                data: { DeckID: $("#UserDeckID").val() },
                success: function (result) {
                    $("#UserName").html("Deck Owner: " + JSON.parse(result));
                },
                error: function (result) {
                    toastr.warning("Error: Unable to retrieve Deck Owner");
                },
            });
        }
        else {
            $.ajax({
                url: "getCards.php",
                type: "POST",
                contentType: 'application/json',
                success: function (result) {
                    var test = JSON.parse(result);
                    for (var i = 0; i < test.length; i++) {
                        var c = new Card(test[i].CardID, test[i].Name, test[i].Ability, test[i].Toughness, test[i].Power, test[i].Loyalty, test[i].Costs, test[i].RarityID, test[i].Rule, test[i].SetID);
                        Cards.push(c);
                    }
                    var vm = new CardsViewModel(Cards);
                    ko.applyBindings(vm);
                }
            });
        }

    });
</script>
<script>
    function CardsViewModel(Cards, Posts) {
        var self = this;
        self.editItem = ko.observable();
        self.Cards = ko.observableArray();
        self.filterCards = ko.observable(true);
        self.filterRed = ko.observable(false);
        self.filterGreen = ko.observable(false);
        self.filterBlue = ko.observable(false);
        self.filterWhite = ko.observable(false);
        self.filterBlack = ko.observable(false);
        self.filterX = ko.observable(false);
        self.filterUncolored = ko.observable(false);
        self.filterNotRed = ko.observable(false);
        self.filterNotGreen = ko.observable(false);
        self.filterNotBlue = ko.observable(false);
        self.filterNotWhite = ko.observable(false);
        self.filterNotBlack = ko.observable(false);
        self.filterNotX = ko.observable(false);
        self.filterNotUncolored = ko.observable(false);
        self.searchTermChanged = ko.observable(false);

        self.selectedRarityIDs = ko.observableArray();
        self.selectedRarityID = ko.computed({
            read: function () {
                var values = self.selectedRarityIDs();
                return values.length ? values[0] : [];
            },
            write: function (newValue) {
                self.selectedRarityIDs([newValue]);
            },
            owner: self
        });

        self.searchTerm = ko.observable("");

        self.Loading = ko.observable(true);

        self.selectedSize = ko.observable(10);
        self.PageCount = ([10, 25, 50, 100]);
        self.selectedSearch = ko.observable("Name");
        self.pageSize = ko.observable(self.selectedSize());
        self.pageIndex = ko.observable(0);
        self.selectedItem = ko.observable();

        self.pageSize.subscribe(function () {
            self.selectedSize();
        });
        self.addCardToDeck = function (Card) {
            $.ajax({
                url: 'addCardToDeck.php',
                type: "POST",
                data: { CardID: Card.CardID, UserDeckID: $("#UserDeckID").val(), UserID: $("#UserID").val() },
            }).success(function (result) {
                if (result == true) {
                    toastr.success('Added Card ' + Card.Name);
                }
                else {
                    toastr.warning("You don't own this deck!");
                }
            }).error(function () {
                toastr.warning("Error Adding Card " + Card.Name);
            });
        };

        self.removeCardFromDeck = function (Card) {
            $.ajax({
                url: 'removeCardFromDeck.php',
                type: "POST",
                data: { CardID: Card.CardID, UserDeckID: $("#UserDeckID").val(), UserID: $("#UserID").val() },
            }).success(function (result) {
                if (result == true) {
                    toastr.success('Removed Card ' + Card.Name);
                    window.location.reload();
                    self.Cards.remove(Card);
                }
                else {
                    toastr.warning("You don't own this deck!");
                }
            }).error(function () {
                toastr.warning("Error Removing Card " + Card.Name);
            });
        }.bind(self);
        self.removePost = function (Post) {
            $.ajax({
                url: 'deletePost.php',
                type: "POST",
                data: { UserPostID: Post.UserPostID },
            }).success(function (result) {
                if (result == true) {
                    window.location.reload(function () {
                        toastr.success('Removed Post');
                    });
                    self.Posts.remove(Post);
                }
                else {
                    toastr.warning("Failed to remove post");
                }
            }).error(function (result) {
                toastr.warning("Failed to remove post");
            });
        };
        self.Loading(false);
        self.Cards = ko.computed(function () {
            return ko.utils.arrayFilter(Cards, function (r) {
                return true;
            });
        });
        self.Posts = ko.computed(function () {
            return ko.utils.arrayFilter(Posts, function (r) {
                return true;
            });
        });

        self.filterNotGreenCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.Cards(), function (r) {
                if (self.filterNotGreen()) {
                    return (r.Costs.indexOf("G") == -1);
                }
                return true;
            });
        });
        self.filterNotBlueCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterNotGreenCards(), function (r) {
                if (self.filterNotBlue()) {
                    return (r.Costs.indexOf("U") == -1);
                }
                return true;
            });
        });
        self.filterNotWhiteCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterNotBlueCards(), function (r) {
                if (self.filterNotWhite()) {
                    return (r.Costs.indexOf("W") == -1);
                }
                return true;
            });
        });
        self.filterNotBlackCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterNotWhiteCards(), function (r) {
                if (self.filterNotBlack()) {
                    return (r.Costs.indexOf("B") == -1);
                }
                return true;
            });
        });
        self.filterNotXCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterNotBlackCards(), function (r) {
                if (self.filterNotX()) {
                    return (r.Costs.indexOf("X") == -1);
                }
                return true;
            });
        });
        self.filterNotUncoloredCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterNotXCards(), function (r) {
                if (self.filterNotUncolored()) {
                    if (r.Costs.match(/\d+/g) != null)
                    { return false; }
                }
                return true;
            });
        });
        self.filterNotRedCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterNotUncoloredCards(), function (r) {
                if (self.filterNotRed()) {
                    return (r.Costs.indexOf("R") == -1);
                }
                return true;
            });
        });

        self.filterGreenCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterNotRedCards(), function (r) {
                if (self.filterGreen()) {
                    return (r.Costs.indexOf("G") > -1);
                }
                return true;
            });
        });
        self.filterBlueCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterGreenCards(), function (r) {
                if (self.filterBlue()) {
                    return (r.Costs.indexOf("U") > -1);
                }
                return true;
            });
        });
        self.filterWhiteCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterBlueCards(), function (r) {
                if (self.filterWhite()) {
                    return (r.Costs.indexOf("W") > -1);
                }
                return true;
            });
        });
        self.filterBlackCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterWhiteCards(), function (r) {
                if (self.filterBlack()) {
                    return (r.Costs.indexOf("B") > -1);
                }
                return true;
            });
        });
        self.filterXCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterBlackCards(), function (r) {
                if (self.filterX()) {
                    return (r.Costs.indexOf("X") > -1);
                }
                return true;
            });
        });
        self.filterUncoloredCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterXCards(), function (r) {
                if (self.filterUncolored()) {
                    if (r.Costs.match(/\d+/g) == null)
                    { return false; }
                }
                return true;
            });
        });
        self.filterRedCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterUncoloredCards(), function (r) {
                if (self.filterRed()) {
                    return (r.Costs.indexOf("R") > -1);
                }
                return true;
            });
        });
        self.filterTextCards = ko.computed(function () {
            return ko.utils.arrayFilter(self.filterRedCards(), function (r) {
                if (self.searchTerm() != "") {
                    return (r.Name.toUpperCase().search(self.searchTerm().toUpperCase()) > -1 || r.Ability.toUpperCase().search(self.searchTerm().toUpperCase()) > -1 || r.Rule.toUpperCase().search(self.searchTerm().toUpperCase()) > -1 || r.SetID.toUpperCase().search(self.searchTerm().toUpperCase()) > -1);
                }
                return true;
            });
        });


        self.filteredCardsCheckbox = ko.computed(function () {
            self.pageIndex(0);
            return ko.utils.arrayFilter(self.filterTextCards(), function (r) {
                self.Loading(false);
                switch (self.selectedRarityID()) {
                    case "1":
                        return (r.RarityID.indexOf("1") > -1);
                        break;
                    case '2':
                        return (r.RarityID.indexOf("2") > -1);
                        break;
                    case '3':
                        return (r.RarityID.indexOf("3") > -1);
                        break;
                    case '4':
                        return (r.RarityID.indexOf("4") > -1);
                        break;
                    case '5':
                        return (r.RarityID.indexOf("5") > -1);
                        break;
                    default:
                        return true;
                        break;
                }
                return true;
            })
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

        self.PostTemplate = function (item) {
            return 'postTmpl';
        };
        //Paging
        self.pagedList = ko.dependentObservable(function () {
            var size = self.pageSize();
            var start = self.pageIndex() * size;
            return self.filteredCardsCheckbox().slice(start, start + size);
        });
        self.maxPageIndex = ko.dependentObservable(function () {
            return Math.ceil(self.filteredCardsCheckbox().length / self.pageSize()) - 1;
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

    }
</script>
