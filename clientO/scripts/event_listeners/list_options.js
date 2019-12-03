var max_results_field = document.getElementById('max_results');
max_results_field.addEventListener(
    "change",
    function() {
        sel_type = sel_type_field.options[sel_type_field.selectedIndex].value;
        max_results = max_results_field.options[max_results_field.selectedIndex].value;
        update_center();
    }
)

var sel_type_field = document.getElementById('selection_type');
sel_type_field.addEventListener(
    "change",
    function() {
        sel_type = sel_type_field.options[sel_type_field.selectedIndex].value;
        reveal_select_all(sel_type);
        max_results = max_results_field.options[max_results_field.selectedIndex].value;
        update_center();
    }
)
