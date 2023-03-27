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
    <div style="text-align: center;">
        <h2>planner tool</h2>
        <button class="w3-button w3-green" onclick="modal('modalNewList', 'open')">Create a new list</button>
    </div>
    <hr>
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

        <div class=" listcard_flex">

            <!-- lists loop -->
            <?php
            foreach ($list as $val) {
            ?>

                <div class="w3-card-4" style=" display:inline-block; position: relative; height: 100%;">
                    <header class="w3-container w3-light-grey">
                        <h3><?php echo $val['name']; ?></h3>
                        <button class="w3-btn" onclick="sortList(<?php echo $val['id']; ?>, 'duration')">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                        </button>
                        <button class="w3-btn " onclick="sortList(<?php echo $val['id']; ?>, 'priority')">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        </button>
                        <button class="w3-btn " onclick="sortList(<?php echo $val['id']; ?>, 'status')">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                        </button>
                    </header>
                    <div class="w3-container flex-container" id="listContainer<?php echo $val['id']; ?>">
                        <?php

                        $stmt = $pdo->prepare('SELECT * FROM listitem WHERE listId = ?');
                        $stmt->execute([$val['id']]);
                        $items = $stmt->fetchAll();

                        // list item loop
                        foreach ($items as $val1) { ?>
                            <div class="item" id="itemId<?php echo $val1['id']; ?>" data-listID="<?php echo $val['id']; ?>" data-itemName="<?php echo $val1['name']; ?>" data-duration="<?php echo $val1['duration']; ?>" data-priority="<?php echo $val1['priority']; ?>" data-status="<?php echo $val1['status']; ?>">
                                <h3><?php echo $val1['name']; ?></h3>
                                <p><?php echo $val1['content']; ?></p>
                                <span class="w3-tag w3-blue">Priority: <?php echo $val1['priority']; ?></span>
                                <span class="w3-tag w3-grey">duration: <?php echo $val1['duration']; ?>min</span>
                                
                                <span class="w3-tag w3-orange"><?php if ($val1['status']) {
                                                                    echo "active";
                                                                } else {
                                                                    echo "inactive";
                                                                } ?></span>
                                                                <br>	
                                <span class="w3-btn w3-yellow" onclick="modal('modalItem<?php echo $val1['id'] ?>', 'open')">
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
                    <br>
                    <div style="position: relative; bottom: 0;">
                    <button class="w3-button w3-block w3-yellow" onclick="modal('modalEditList<?php echo $val['id'] ?>', 'open')">Edit List</button>
                    <button class="w3-button w3-block w3-blue" onclick="modal('modal<?php echo $val['id'] ?>', 'open')">New item</button>
                    </div>
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


        function sortList(list, filter) {
            var listItems = document.querySelectorAll("[data-listID='" + list + "']");
            var sortItems = [];
            for (let val of listItems) {
                var currentIdName = val.id;
                var currentItemName = val.name;

                if (filter == "duration") {
                    var filterCheck = val.dataset.duration;
                } else if (filter == "priority") {
                    var filterCheck = val.dataset.priority;
                } else if (filter == "status") {
                    var filterCheck = val.dataset.status;
                } else {
                    filterCheck = currentItemName;
                }

                sortItems.push([currentIdName, filterCheck]);

            }

            sortItems.sort(function(a, b) {
                    return a[1] - b[1];
                });


                // functie om laten draaien voor tijd sortering
            
            
                for (let i = 0; i < sortItems.length; i++) {
                console.log(sortItems[i][0]);
                document.getElementById(sortItems[i][0]).style.order = i;
                }
            
           
            }
        
           // functie die status op display none zet

            
    </script>
</body>

</html>