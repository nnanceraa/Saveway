<!DOCTYPE html>
<!--BROWSE CATALOG PAGE-->
<?php
session_start();
include 'connect.php';
?>

<html lang="en">
    <?php
    include 'head.php';
    ?>

    <body>
        <header>
            <img src="images/logo.png" alt="D&amp;N logo" height="70">
            <div id="hgroup">
                <h1>SAVEWAY Online Grocery Store</h1>
                <h2>Brought to you by <span class="shadow">D&amp;N </span>Ltd.</h2>
                <div id='usercheck'> 
                    <?php
                    include 'usercheck.php';
                    ?>
                </div>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="DefaultHome.php">Home</a></li>
                <li>
                    <a class="current" href="Browse.php">Browse</a></li>
                <li><a href="Cart.php">
                        <?php
                        // count products in cart
                        if (isset($_SESSION['cart_items'])) {
                            $cart_count = count($_SESSION['cart_items']);
                        }
                        ?>
                        My Cart
                        <span class="badge" id="comparison-count">
                            <?php
                            if (!isset($_SESSION['cart_items'])) {
                                echo "0";
                            } else {
                                echo $cart_count;
                            }
                            ?>
                        </span></a>
                </li>
                <li><a href="Profile.php">Profile</a></li>
            </ul>
        </nav>
        <section>

            <form id="searchForm" style="display:inline-block">
                <input type="text" id="name" name="name" placeholder="Enter Product Name"/>
                <input type="button" id="search" value="Search" class="button"/>
                <input type="button" id="goCart" value="Go to Cart"  onclick="window.location = 'Cart.php';" class="button"/>
            </form>

            <h1> Browse Our Products</h1>
            <div id="answer" style="display:inline-block">

            </div>
            <div id="tabs" style="display:inline-block">
                <ul>
                    <li><a href="#tabs-1">Produce</a></li>
                    <li><a href="#tabs-2">Meat</a></li>
                    <li><a href="#tabs-3">Dairy</a></li>
                    <li><a href="#tabs-4">Bakery</a></li>
                </ul>
                <div id="tabs-1" >
                    <div class="accordion">
                        <?php
                        include 'CartProducts/produce.php';
                        ?>
                    </div>
                </div>
                <div id="tabs-2">
                    <div class="accordion">
                        <?php
                        include 'CartProducts/meat.php';
                        ?>
                    </div>
                </div>
                <div id="tabs-3">
                    <div class="accordion">
                        <?php
                        include 'CartProducts/dairy.php';
                        ?>
                    </div>
                </div>
                <div id="tabs-4">
                    <div class="accordion">
                        <?php
                        include 'CartProducts/bakery.php';
                        ?>
                    </div>
                </div>
            </div>



            <?php
            if ($action == 'exists') {
                echo "<script> "
                . "alert('Quantity was updated!');"
                . "</script>";
            }

            if ($action == 'added') {
                echo "<script type='text/javascript'> alert('Item was added to your cart!');</script>";
            }
            ?>
        </section>



        <script src="scripts/jquery/jquery.js"></script>
        <script src="scripts/jquery-ui.js"></script>
        <script>
                    $(".accordion").accordion();
                    $("#tabs").tabs();
                    $(".button").button();

        </script>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script>
                    $(document).ready(function () {

                        $('#search').click(function (e)
                        {
                            e.preventDefault();
                            if (!validateData($('input#name').val())) {
                                showErrorPanel("You need to fill the data in order to get results!");
                                return false;
                            }
                            makeAjaxRequest("name");
                        });
                        function makeAjaxRequest() {
                            $.ajax({
                                url: "Search.php",
                                dataType: "json",
                                type: "GET",
                                data: {name: $("input#name").val()},
                                success: function (response) {
                                    console.log(response);
                                    if (response['msg'] == "success") {
                                        var product = response['response'];
                                        var listData = "";
                                        for (var key in product) {
                                            listData +=
                                                    "<div style='border: 1px solid #33CC33'><h3>" + product[key]['ITEM_NAME'] + "</h3>" +
                                                    "<div><img src='images/" + product[key]['PHOTO_FILENAME'] + "' alt='" + product[key]['PHOTO_FILENAME'] + "' />" +
                                                    "<h4>Description</h4>" +
                                                    product[key]['DESCRIPTION'] +
                                                    "<h4>Price</h4>" +
                                                    "&#36;" + product[key]['PRICE'] +
                                                    "<h4>Quantity</h4>" +
                                                    "<input class='spinner' value='1'><br>" +
                                                    "<a href='CartProducts/add_to_cart.php?id=" +
                                                    product[key]['ITEM_ID'] + "&name=" +
                                                    product[key]['ITEM_NAME'] + "' class='button'>" +
                                                    "Add to cart</a></div></div>";

                                        }
                                        $('#answer').html(listData);
                                        $(".button").button();
                                    } else {
                                        $("#answer").html("<table><tr><td>Nothing was returned.</td></tr></table>");
                                    }


                                },
                                error: function (jqXHR, textStatus, errorThrown) {

                                    $("#answer").html("<table><tr><td>Something went wrong.</td></tr></table>");
                                }
                            });
                        }
                        function validateData(data) {
                            if (data == "") {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    });
        </script>
    </body>
            <?php
        include 'footer.php';
        ?>
</html>