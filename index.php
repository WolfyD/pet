<?php
    require_once("init.php");
    require_once("./resources/sql/error_list.php");
    use PET\sql\ErrorList;
    $pdo ? $pdo : $conn->createConnection(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>PET - PHP Error Tracker</title>
        <script src='js/index.js'></script>
        <?php require_once(__DIR__ . "/components/head.php"); ?>
        <script> setDefaultLists();  </script>
    </head>
    <body>
    <div id='content' class="container">
        <?php require_once(__DIR__ . "/components/header.php"); ?>

        <!-- Main Layout -->
        <div class="layout">
            <!-- Main Form Section -->
            <main class="form-container">
                
                <div class="form_top_container">
                    <div class="form_top">
                        <span class="id_wrapper"><span id='id_span'>ID: </span></span>
                        <span class="state_wrapper" id='state_marker'><span id='state_span'></span></span>
                    </div>
                </div>
                <div class="form">
                    <!-- Example Form Fields -->
                    <div class="form-group">
                        <label for="field_severity">Severity</label>
                        <input type="text" id="field_severity">
                        <button class="icon-button"></button>
                    </div>
                    <div class="form-group">
                        <label for="field_line_from_to">Line from-to</label>
                        <input type="text" id="field_line_from_to">
                        <button class="icon-button"></button>
                    </div>
                    <div class="form-group">
                        <label for="field_type">Type</label>
                        <select id="field_type" value=0>
                            <option class="nonselect" value=0>Select error type</option>
                            <hr />
                        </select>
                        <button class="icon-button"></button>
                    </div>
                    <div class="form-group">
                        <label for="field_message">Message</label>
                        <textarea style="resize: vertical; min-height: 100px;" id="field_message"></textarea>
                        <button class="icon-button"></button>
                    </div>
                    <div class="form-group">
                        <label for="field_file_name">File</label>
                        <input type="text" id="field_file_name">
                        <button class="icon-button"></button>
                    </div>
                    <div class="form-group">
                        <label for="field_snippet">Snippet</label>
                        <input type="text" id="field_snippet">
                        <button class="icon-button"></button>
                    </div>
                    <div class="form-group">
                        <label for="field_error_level">Error level</label>
                        <input type="text" id="field_error_level">
                        <button class="icon-button"></button>
                    </div>
                    <div class="form-group">
                        <label for="field_taint_trace">Taint trace</label>
                        <textarea style="resize: vertical; min-height: 100px;" id="field_taint_trace"></textarea>
                        <button class="icon-button"></button>
                    </div>
                    <div class="form-group">
                        <label for="field_other_references">Other references</label>
                        <textarea style="resize: vertical; min-height: 100px;" id="field_other_references"></textarea>
                        <button class="icon-button"></button>
                    </div>
                    <div class="form-group">
                    <label for="field_relevance">Relevance</label>
                        <select id="field_relevance">
                            <option class="nonselect" value='0'>Select error relevance</option>
                            <hr />
                        </select>
                        <button class="icon-button"></button>
                    </div>
                    <div class="form-group">
                        <label for="screenshot">Screenshot</label>
                        <div class="screenshot_image_container">
                            <img alt="screenshot" />
                        </div>
                        <button class="icon-button"></button>
                    </div>
                    
                </div>
            </main>

            <!-- Sidebar Section -->
            <aside class="sidebar">
                <div class="assign-section">
                    <label for="field_user">Assigned To</label>
                    <span class="assign_dropdown_container">
                        <select id="field_user">
                            <option class="nonselect" value='0'>Select user</option>
                            <hr />
                        </select>
                        <button style="height: 30px;">Assign to Me</button>
                    </span>
                </div>

                <div class="notes-section">
                    <label for="notes">Notes</label>
                    <textarea style="height: 50px;" id="notes" placeholder="Add notes here..."></textarea>
                </div>

                <div class="difficulty-section">
                    <label>Difficulty</label>
                    <div class="rating" onmouseleave="resetDiff()">
                        <!--&#9733;&#9733;&#9733;&#9734;&#9734;-->
                        <span title="difficulty 1/5" onmouseenter="showDiff(1)" onclick="setDiff(1)" class="difficulty_star" id="difficulty_star_1">&#9733;</span>
                        <span title="difficulty 2/5" onmouseenter="showDiff(2)" onclick="setDiff(2)" class="difficulty_star" id="difficulty_star_2">&#9734;</span>
                        <span title="difficulty 3/5" onmouseenter="showDiff(3)" onclick="setDiff(3)" class="difficulty_star" id="difficulty_star_3">&#9734;</span>
                        <span title="difficulty 4/5" onmouseenter="showDiff(4)" onclick="setDiff(4)" class="difficulty_star" id="difficulty_star_4">&#9734;</span>
                        <span title="difficulty 5/5" onmouseenter="showDiff(5)" onclick="setDiff(5)" class="difficulty_star" id="difficulty_star_5">&#9734;</span>
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
            <button onclick="previous()" class="arrow">&#9664;</button>
            <div class="jump-to">
                <label class="jump_page_label" for="jump-page">Jump to:</label>
                <input onkeypress="jumpKeyPress(this.value)" type="number" id="jump-page" min="1" placeholder="Error #">
            </div>
            <button onclick="next()" class="arrow">&#9654;</button>
        </footer>
    </div>
    <script>  

        function jumpKeyPress(value){
            var x = new RegExp("^\\d+$");
            if(event.key == "Enter" && value.match(x) && value > 0){
                window.location = "/pet/?id=" + value;
            }else{
                console.log(value);
            }
        }

        function next(){
            if(currentData){
                var id = parseInt(currentData.id) + 1;
                window.location = "/pet/?id=" + id;
            }
        }

        function previous(){
            if(currentData){
                var id = currentData.id;
                if(id > 1){
                    window.location = "/pet/?id=" + (id - 1);
                }
            }
        }

    </script>
</body>
</html>


<?php
    if($pdo){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }else{
            $id = 1;
        }
        $e = new ErrorList($pdo);
        $error_data = $e->getErrorById($id);
        echo("<script>document.addEventListener('DOMContentLoaded', ()=>{ window.setTimeout(()=>{ setErrorData(" . json_encode($error_data) . "); }, 120); } )</script>");
        
    }
?>