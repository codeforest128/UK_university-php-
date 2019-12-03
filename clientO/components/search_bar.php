<div class="leftfilter">
    <div class="tab1">
        <button id="basic_search_button" class="tablinks1" onclick="openTab(event, 1, 'search_tab')" disabled>Filter</button>
        <button class="tablinks1" onclick="openTab(event, 1, 'smart_search_tab')" style="display: none;">Smart Search</button>
    </div>
    <div id="search_tab" class="tabcontent1" style="display:inline-block;">
        <?php include_once "search/basic.php"; ?>
    </div>
    <div id="smart_search_tab" class="tabcontent1" style="display: none;">
        <?php include_once "search/smart.php"; ?>
    </div>
</div>