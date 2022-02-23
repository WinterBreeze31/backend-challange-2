<?php
include_once("resources/functions.php");
?>
<?php
include("resources/head.php");
?>
<?php
$list = $pdo->query('SELECT * FROM `list`');

?>

<body>
    <div class="w3-container">
        <h2>planner tool</h2>



<!-- lists loop -->
        <?php
        foreach ($list as $val) {
        ?>

            <div class="w3-card-4" style="width:25%; display:inline-block;">
                <header class="w3-container w3-light-grey">
                    <h3><?php echo $val['name']; ?></h3>
                </header>
                <div class="w3-container">
                    <?php

                    $stmt = $pdo->prepare('SELECT * FROM listitem WHERE listId = ?');
                    $stmt->execute([$val['id']]);
                    $items = $stmt->fetchAll();

// list item loop
                    foreach ($items as $val1) { ?>
                        <div class="item">
                            <p><?php echo $val1['name']; ?></p>
                            <hr>
                            <p>list item content</p><br>
                        </div>
                    <?php } ?>



                </div>
                <button class="w3-button w3-block w3-dark-grey" onclick="modal('modal<?php echo $val['id'] ?>', 'open')">New item</button>
<!-- new item modal -->
                <div id="modal<?php echo $val['id'] ?>" class="w3-modal">
                    <div class="w3-modal-content">
                        <div class="w3-container">
                            <span onclick="modal('modal<?php echo $val['id'] ?>', 'close')" class="w3-button w3-display-topright">&times;</span>
                            
                            <form action="#" method="post" class="w3-container">
                                <h3>New Item</h3>
                                <input type="hidden" name="listId" value="<?php echo $val['id'] ?>">
                                <br>
                                <input type="text" name="itemName" placeholder="Name of list item" class="w3-input w3-border">
                                <br>
                                <input type="number" name="itemPriority" placeholder="priority" class="w3-input w3-border">
                                <br>
                                <input type="number" name="ItemDuration" placeholder="Duration in minutes" class="w3-input w3-border">
                                <br>
                                <textarea name="itemContent" style="resize: vertical;" cols="30" rows="10" placeholder="content" class="w3-input w3-border"></textarea>
                                <br>
                                <input type="submit" value="Add Item" class="w3-btn w3-block">
                                <br>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>





        <div class="w3-card-4" style="width:25%; display:inline-block;">
            <header class="w3-container w3-light-grey">
                <h3>New list</h3>
            </header>
            <div class="w3-container">
                <p>list item name</p>
                <hr>
                <p>list item content</p><br>
            </div>
            <button class="w3-button w3-block w3-dark-grey">+ Connect</button>
        </div>
    </div>




    <script>
        function modal(elementID, openClose) {
            var element = document.getElementById(elementID);
            if (openClose === "open") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }
    </script>
</body>

</html>