<?php
    use PET\settings\styles;
    require_once("init.php");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>PET - List errors</title>
        <script src='js/session.js'></script>
        <script src='js/base.js'></script>
        <script src='js/list.js'></script>
        <script src='js/popup.js'></script>
        <link rel="stylesheet" href="resources/css/index.css" type="text/css" />
        <link rel="stylesheet" href="resources/css/custom.css" type="text/css" />
        <link rel="stylesheet" href="resources/css/list.css" type="text/css" />
        <style>
            :root{
                --paw-print-color: rgba(107, 142, 173, 0.1); /* Very light steel blue */
                <?php print(styles::getTheme($theme)) ?>
            }
        </style>
    </head>
    <body>
    <div class="container">
        <?php require_once(__DIR__ . "/components/header.php"); ?>
        <span id="full_popup_container">
            <div id="full_popup"><div class="full_popup_header">Title</div><div class="full_popup_body"><form>Multiple form lines</form></div><div class="full_popup_button"><button>Close</button></div></div>
        </span>
        <span id="simple_popup_container">
            <div id="simple_popup">
                <div class="simple_popup_header">Title</div>
                <div class="simple_popup_body">TEXT</div>
                <div class="simple_popup_button"><button onclick="hideSimplePopup()">Close</button></div>
            </div>
        </span>
        <!-- Main Layout -->
        <div class="layout">
            <!-- List Form Section -->
            <main class="form-container">
                <!-- Table of Items -->
                <div class="table-container">
                    <table class="error-table">
                        <thead>
                            <tr class="header_row">
                                <th>ID</th>
                                <th>
                                    <img title='filter on this field' class='list_img list_filter_img' src='./resources/images/filter.png' alt='filter'/>
                                    Severity
                                </th>
                                <th>
                                <img title='filter on this field' class='list_img list_filter_img' src='./resources/images/filter.png' alt='filter'/>
                                    Type
                                </th>
                                <th>
                                <img title='filter on this field' class='list_img list_filter_img' src='./resources/images/filter.png' alt='filter'/>
                                    File
                                </th>
                                <th>Error #</th>
                                <th>
                                <img title='filter on this field' class='list_img list_filter_img' src='./resources/images/filter.png' alt='filter'/>
                                    Difficulty
                                </th>
                                <th>
                                <img title='filter on this field' class='list_img list_filter_img' src='./resources/images/filter.png' alt='filter'/>
                                    Time
                                </th>
                                <th>
                                <img title='filter on this field' class='list_img list_filter_img' src='./resources/images/filter.png' alt='filter'/>
                                    Assigned To
                                </th>
                                <th>Actions</th>
                                <th>Tags</th>
                            </tr>
                        </thead>
                        <tbody id="error_table_main">
                            <!-- Table to be filled by getPage() function -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination_container">
                    <div class="pagination">
                        <button class="arrow" aria-label="Previous Page">&laquo; Prev</button>
                        <div class="page-numbers">
                            <button class="page-number active">1</button>
                            <button class="page-number">2</button>
                            <button class="page-number">3</button>
                            <button class="page-number">...</button>
                            <button class="page-number">10</button>
                        </div>
                        <button class="arrow" aria-label="Next Page">Next &raquo;</button>
                    </div>

                    <div class="filter_button_container">
                        <label class="filter_checkbox_label" for="filter_checkbox_fake">Filter</label>
                        <input id='filter_checkbox_fake' class="sidebar_button" type="checkbox" onchange="setFilterCheckbox()" />
                    </div>

                </div>
            </main>
            <!-- Sidebar Section -->
            <div class="sidebar_wrapper">
                <input type="checkbox" id='filter_checkbox' class="filter_checkbox" />
                <aside class="sidebar filter_sidebar sidebar_closed">
                    <!-- Filter -->
                    <h1>Filter</h1>
                </aside>
            </div>

        </div>
        <script type="text/javascript">
            var theme = '<?=$theme?>';
            
            function getImageColor(image){
                var w = "";
                if(isThemeDark(theme)){
                    w = "w_";
                }
                return `${w}${image}`;
            }

            function handleFilterImageColor(){
                var filterImages = document.getElementsByClassName("list_filter_img");
                Array.from(filterImages).forEach(filter => {
                    console.log(filter);
                    var src = filter.getAttribute('src');
                    var parts = src.split('/'); 
                    parts[parts.length - 1] = getImageColor(parts[parts.length - 1]);
                    filter.setAttribute('src', parts.join('/'));
                });
            }

            function setFilterCheckbox(){
                document.getElementById('filter_checkbox').checked = event.target.checked;
            }


            window.addEventListener("load", ()=>{
                window.listPage = 1;
                getPage(window.listPage);
                setTimeout(()=>{handleFilterImageColor();}, 100);
            });
        </script>
    </div>
</body>
</html>