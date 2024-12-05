
<script src='js/header.js'></script>

<!-- Header -->
<header class="header">
    <?php if($theme == 'dragon'){ echo("<img draggable='false' oncontextmenu='event.preventDefault()' class='derg_img' src='./resources/images/derg.bmp' />"); } ?>
    <div class="header-left">
        <h1 onclick="window.location = '/pet/index.php';">PET - PHP Error Tracker</h1>
        <span class="greeting">Welcome, <span id='userName'>Username</span></span>
    </div>
    <nav class="header-buttons">
        <button class="header_button" onclick="buttonPressed('list')">List</button>
        <button class="header_button" onclick="buttonPressed()">Search</button>
        <button class="header_button" onclick="buttonPressed()">Tools</button>
        <button class="header_button" onclick="buttonPressed()">Settings</button>
        <button class="header_button" onclick="buttonPressed('logout')">Logout</button>
    </nav>
</header>
<script> 
    fillUserName(); 
</script>
<style>
    .header-buttons{ z-index: 10; }
    .derg_img{
        display: block;
        position: absolute;
        height: 250px;
        right: 10px;
        margin-top: 100px;
        transform: rotate(20deg);
        z-index: 0;
        opacity: .25;
        pointer-events: none;
    }
</style>