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
    <h2>planner tool</h2>
    <button class="w3-button w3-green" onclick="modal('modalNewList', 'open')">Edit List</button>
    <div class="w3-container">
        

        <!-- New List modal -->
        <div id="modalNewList" class="w3-modal">
                    <div class="w3-modal-content">
                        <div class="w3-container">
                            <span onclick="modal('modalNewList', 'close')" class="w3-button w3-display-topright">&times;</span>

                            <form action="#" method="post" class="w3-container">
                                <h3>Create List</h3>
                                <input type="text" name="itemName" placeholder="List name" pattern="[a-zA-Z0-9\s]+" class="w3-input w3-border" required value="<?php echo $val['name'] ?>">
                                <br>
                                <input type="submit" name="makeList" value="Create List" class="w3-btn w3-green w3-block">
                            </form>
                            <br>

                        </div>
                    </div>
                </div>



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
                        <div class="item ">
                            <h3><?php echo $val1['name']; ?></h3>
                            <p><?php echo $val1['content']; ?></p>
                            <span class="w3-tag w3-blue">Priority: <?php echo $val1['priority']; ?></span>
                            <span class="w3-tag w3-grey">duration: <?php echo $val1['duration']; ?>min</span>
                            <br>
                            <span class="w3-tag w3-orange"><?php if ($val1['status']) {
                                                                echo "active";
                                                            } else {
                                                                echo "inactive";
                                                            } ?></span>
                            <span class="w3-tag w3-yellow" onclick="modal('modalItem<?php echo $val1['id'] ?>', 'open')">
                                Edit list item <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                        </div>
                        <hr>

                        <!-- list item editor modal -->
                        <div id="modalItem<?php echo $val1['id'] ?>" class="w3-modal">
                            <div class="w3-modal-content">
                                <div class="w3-container">
                                    <span onclick="modal('modalItem<?php echo $val1['id'] ?>', 'close')" class="w3-button w3-display-topright">&times;</span>
                                    <form action="#" method="post" class="w3-container">
                                        <h3>New Item</h3>
                                        <input type="hidden" name="itemId" value="<?php echo $val1['id'] ?>">
                                        <br>
                                        <input type="text" name="itemName" placeholder="Name of list item" pattern="[a-zA-Z0-9\s]+" class="w3-input w3-border" required value="<?php echo $val1['name'] ?>">
                                        <br>
                                        <input type="number" name="itemPriority" placeholder="priority" class="w3-input w3-border" required value="<?php echo $val1['priority'] ?>">
                                        <br>
                                        <input type="number" name="itemDuration" placeholder="Duration in minutes" class="w3-input w3-border" required value="<?php echo $val1['duration'] ?>">
                                        <br>
                                        <textarea name="itemContent" style="resize: vertical;" cols="30" rows="10" placeholder="content" pattern="[a-zA-Z0-9\s]+" class="w3-input w3-border" required><?php echo $val1['content']; ?></textarea>
                                        <br>
                                        <label for="status">Status</label><br>
                                        <input type="radio" name="itemStatus" value="1" <?php if ($val1['status']) {
                                                                                            echo "checked";
                                                                                        } ?>>
                                        <label>Active</label><br>
                                        <input type="radio" name="itemStatus" value="0" <?php if (!$val1['status']) {
                                                                                            echo "checked";
                                                                                        } ?>>
                                        <label>Inactive</label><br>
                                        <input type="submit" name="editItem" value="Edit Item" class="w3-btn w3-block">
                                        <input type="submit" name="deleteItem" value="Delete Item" class="w3-btn w3-red w3-block">
                                        <br>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php } ?>



                </div>
                <button class="w3-button w3-block w3-yellow" onclick="modal('modalEditList<?php echo $val['id'] ?>', 'open')">Edit List</button>
                <button class="w3-button w3-block w3-blue" onclick="modal('modal<?php echo $val['id'] ?>', 'open')">New item</button>

                <!-- new item modal -->
                <div id="modal<?php echo $val['id'] ?>" class="w3-modal">
                    <div class="w3-modal-content">
                        <div class="w3-container">
                            <span onclick="modal('modal<?php echo $val['id'] ?>', 'close')" class="w3-button w3-display-topright">&times;</span>

                            <form action="#" method="post" class="w3-container">
                                <h3>New Item</h3>
                                <input type="hidden" name="listId" value="<?php echo $val['id'] ?>">
                                <br>
                                <input type="text" name="itemName" placeholder="Name of list item" pattern="[a-zA-Z0-9\s]+" class="w3-input w3-border" required>
                                <br>
                                <input type="number" name="itemPriority" placeholder="priority" class="w3-input w3-border" required>
                                <br>
                                <input type="number" name="itemDuration" placeholder="Duration in minutes" class="w3-input w3-border" required>
                                <br>
                                <textarea name="itemContent" style="resize: vertical;" cols="30" rows="10" placeholder="content" pattern="[a-zA-Z0-9\s]+" class="w3-input w3-border" required></textarea>
                                <br>
                                <input type="submit" name="newItem" value="Add Item" class="w3-btn w3-block">
                                <br>
                            </form>


                        </div>
                    </div>
                </div>

                <!-- Edit List modal -->
                <div id="modalEditList<?php echo $val['id'] ?>" class="w3-modal">
                    <div class="w3-modal-content">
                        <div class="w3-container">
                            <span onclick="modal('modalEditList<?php echo $val['id'] ?>', 'close')" class="w3-button w3-display-topright">&times;</span>

                            <form action="#" method="post" class="w3-container">
                                <h3>Edit List</h3>
                                <input type="hidden" name="itemId" value="<?php echo $val['id'] ?>">
                                <input type="text" name="itemName" placeholder="List name" pattern="[a-zA-Z0-9\s]+" class="w3-input w3-border" required value="<?php echo $val['name'] ?>">
                                <br>
                                <input type="submit" name="editList" value="Edit List" class="w3-btn w3-yellow w3-block">
                                <input type="submit" name="deleteList" value="Delete List" class="w3-btn w3-red w3-block">
                            </form>
                            <br>

                        </div>
                    </div>
                </div>


            </div>
        <?php
        }
        ?>

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