<!DOCTYPE html>
<!-- ADMIN CONTROL PAGE-->
<?php
session_start();
include 'connect.php';

//check to see if user is admin, otherwise, redirect back to the home page
if (empty($_SESSION['email']) || $_SESSION['email'] != 'admin@saveway.com') {
    header("location: DefaultHome.php");
}
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
            </div>
            <div id='usercheck'> 
                <?php include 'usercheck.php'; ?>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="DefaultHome.php">Home</a></li>
                <li><a href="Browse.php">Browse</a></li>
                <li><a href="Cart.php">
                        <?php
                        // count products in cart and displays the number 
                        // in the nav bar
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
            <h1> Manage your products, accounts, and orders</h1>
            <div id="testing">
                <ul>
                    <li><a href="#tabs-1">Products</a></li>
                    <li><a href="#tabs-2">Accounts</a></li>
                    <li><a href="#tabs-3">Orders</a></li>
                </ul>
                <div id="tabs-1">
                    <div style='margin:0 0 .5em 0;'>
                        <input type="button" id="addProducts" class='buttons' value="Add Product"/>                      
                        <input type="button" id="viewProducts" class='buttons' value="View Products"/>  
                        <!-- this is the loader image, hidden at first -->
                        <div id='loaderImage'><img src='images/loading.gif' alt="whatever"/></div>

                        <div style='clear:both;'></div>
                        <div id="add">
                            <h2>Add New Product</h2>
                            <form id='addItemForm' action="" method="post" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td>Item Category</td>
                                        <td><select name='CATEGORY_ID'>
                                                <option value="1">Produce</option>
                                                <option value="2">Meat</option>
                                                <option value="3">Dairy</option>
                                                <option value="4">Bakery</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td>Item Name</td>
                                        <td><input type='text' id="ITEM_NAME" name='ITEM_NAME' required /></td>
                                    </tr>
                                    <tr>
                                        <td>Item Description</td>
                                        <td><input type='text' name='DESCRIPTION' required /></td>
                                    </tr>
                                    <tr>
                                        <td>Item Price</td>
                                        <td><input type='text' name='PRICE' required /></td>
                                    </tr>
                                    <tr>
                                        <td>Item Cost</td>
                                        <td><input type='text' name='COST' required /></td>
                                    </tr>
                                    <tr>
                                        <td>Item Quantity</td>
                                        <td><input type='text' name='QUANTITY' required /></td>
                                    </tr>
                                    <tr>
                                        <td>Image Filename</td>
                                        <td><input type="file" id="file" name="file" accept="image/*" required/>
                                            <input type='hidden' name='PHOTO_FILENAME'/></td>
                                    </tr>
                                </table>   
                                Recommended image types: jpg, jpeg, png<br/>
                                Recommended image dimensions: 200x200<br/>
                                Max image size: 1MB<br/>
                                <input id="submit" type='submit' name='submit' class='buttons' value='Add'>
                            </form>
                            <?php include 'Uploadphp.php'; ?> 
                            <p id="result"></p>
                            
                        </div>
                        <!-- this is where the contents will be shown. -->
                        <div id='pageContent'>
                            
                        </div>
                    </div>
                </div>


                <div id="tabs-2">
                    <?php
                    $getCustomers = $dbh->prepare("SELECT * FROM CUSTOMER");
                    $getCustomers->execute();

                    $customers = $getCustomers->fetchAll();

                    echo "<table>";
                    echo "<tr><th>Customer ID</th><th>Name</th><th>Email</th></tr>";
                    
                    foreach ($customers as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['CUSTOMER_ID'] . "</td>";
                        echo "<td>" . $row['NAME'] . "</td>";
                        echo "<td>" . $row['EMAIL'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                    ?>


                </div>
                <div id="tabs-3">
                    <?php
                    include 'Orders.php';
                    ?>
                </div>
            </div>
        </section>
        <script src="scripts/jquery/jquery.js"></script>
        <script src="scripts/jquery-ui.js"></script>
        <script>
            $("#testing").tabs();
            $(".buttons").button();
            $(".buttons2").button();
            $(".buttons").css({"width": "130px"});
        </script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script type='text/javascript'>
            //add new products ajax
            $(document).ready(function () {

                $("#submit").click(function (e) {
                    //e.preventDefault();
                    console.log($("#file").val());
                    var formData = ConvertFormToJSON("#addItemForm");
                    console.log("Data from form (to be sent): ", formData);

                    $.ajax({
                        url: "CreateProduct.php",
                        type: "POST",
                        dataType: "JSON",
                        data: formData,
                        success: function (data) {
                            console.log("Data returned from server: ", data);
                            if (data['msg'] == "Success") {
                                $("#pageContent").empty();
                                showItems();
                            }
                            else {
                                $("#result").text(data['msg']);
                            }

                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $("#result").html(jqXHR.responseText);
                        }
                    });


                    function ConvertFormToJSON(form) {
                        var array = $(form).serializeArray();
                        var json = {};

                        jQuery.each(array, function () {
                            json[this.name] = this.value || '';
                        });
                        return json;
                    }

                });

                $("#file").change(function () {

                    $("input[name=PHOTO_FILENAME]").val($("#file").val());
                });

            });



            function showCreateItemForm() {
                $("#pageContent").empty();
                $('#add').show();

            }


            $('#loaderImage').show();
            showItems();


            $('#viewProducts').click(function () {
                // show a loader img
                $('#loaderImage').show();
                showItems();
            });

            $('#addProducts').click(function () {
                // show a loader img
                showCreateItemForm();

            });


            function showItems() {
                setTimeout("$('#pageContent').load('read.php', function(){ $('#loaderImage').hide(); });", 1000);
                $("#add").hide();
            }

            // clicking the EDIT button
            $(document).on('click', '.editBtn', function () {
                $("#add").hide();

                var ITEM_ID = $(this).closest('td').find('.ITEM_ID').text();
                console.log(ITEM_ID);

                // show a loader image
                $('#loaderImage').show();
                setTimeout("$('#pageContent').load('Update_Form.php?ITEM_ID=" + ITEM_ID + "', function(){ $('#loaderImage').hide(); });", 1000);

            });

            // UPDATE FORM IS SUBMITTED
            $(document).on('submit', '#updateItemForm', function () {

                // show a loader img
                $('#loaderImage').show();
                $("#add").css("display", "none");

                // post the data from the form
                $.post("Update.php", $(this).serialize())

                        .done(function (data) {
                            console.log(data);
                            showItems();

                            // 'data' is the text returned, you can do any conditions based on that

                        });

                return false;
            });

            // when clicking the DELETE button
            $(document).on('click', '.deleteBtn', function () {
                if (confirm('Are you sure?')) {

                    // get the id
                    var ITEM_ID = $(this).closest('td').find('.ITEM_ID').text();

                    // trigger the delete file
                    $.post("Delete.php", {ITEM_ID: ITEM_ID})
                            .done(function (data) {
                                // you can see your console to verify if record was deleted
                                console.log(data);
                                $('#loaderImage').show();
                                // reload the list
                                showItems();
                            });
                }
            });
        </script>
    </body>
    <?php
    include 'footer.php';
    ?>
</html>