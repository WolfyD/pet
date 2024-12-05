<?php
    require_once("init.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>PET - PHP Error Tracker</title>
        <?php require_once(__DIR__ . "/components/head.php"); ?>
    </head>
    <body>
    <div id='content' class="container">
        <?php require_once(__DIR__ . "/components/header.php"); ?>

        <!-- Main Layout -->
        <div class="layout">
            <!-- Main Form Section -->
            <main class="form-container">
                <div class="form">
                    <!-- Example Form Fields -->
                    <div class="form-group">
                        <label for="field-1">Field 1</label>
                        <input type="text" id="field-1">
                        <button class="icon-button">&#128269;</button>
                    </div>
                    <div class="form-group">
                        <label for="field-2">Field 2</label>
                        <input type="text" id="field-2">
                        <button class="icon-button">&#128396;</button>
                    </div>
                    <!-- Additional form groups go here -->
                </div>
            </main>

            <!-- Sidebar Section -->
            <aside class="sidebar">
                <div class="assign-section">
                    <label for="assign-to">Assigned To</label>
                    <select id="assign-to">
                        <option value="user1">Henk</option>
                        <option value="user2">Other User</option>
                    </select>
                    <button>Assign to Me</button>
                </div>

                <div class="notes-section">
                    <label for="notes">Notes</label>
                    <textarea id="notes" placeholder="Add notes here..."></textarea>
                </div>

                <div class="difficulty-section">
                    <label>Difficulty</label>
                    <div class="rating">
                        &#9733;&#9733;&#9733;&#9734;&#9734; <!-- Example stars -->
                    </div>
                </div>

                <div class="estimate-section">
                    <label for="estimate">Estimated Time</label>
                    <input type="number" id="estimate" placeholder="Hours">
                </div>

                <div class="sidebar-buttons">
                    <button class="not-important">Request Not Important</button>
                    <button class="save">Save</button>
                </div>
            </aside>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <button class="arrow">&#9664;</button>
            <div class="jump-to">
                <label class="jump_page_label" for="jump-page">Jump to:</label>
                <input type="number" id="jump-page" min="1" placeholder="Page #">
            </div>
            <button class="arrow">&#9654;</button>
        </footer>
    </div>
</body>
</html>