var max_results_field = document.getElementById('max_results');
max_results_field.addEventListener(
    "change",
    function() {
        sel_type = sel_type_field.options[sel_type_field.selectedIndex].value;
        console.log(sel_type)
        max_results = max_results_field.options[max_results_field.selectedIndex].value;
        update_center();
    }
)

var sel_type_field = document.getElementById('selection_type');
sel_type_field.addEventListener(
    "change",
    function() {
        sel_type = sel_type_field.options[sel_type_field.selectedIndex].value;
        // reveal_select_all(sel_type);
        manage_bulk_actions(sel_type);
        max_results = max_results_field.options[max_results_field.selectedIndex].value;
        update_center();
    }
)

function manage_bulk_actions(sel) {
	console.log(sel);
    var ac_det = document.getElementById('access_details_bulk_cont');
    var d_xcl = document.getElementById('download_excel_bulk_cont');
    var s_list = document.getElementById('shortlist_cand_bulk_cont');
    var email = document.getElementById('email_cand_bulk_cont');
    var info = document.getElementById('select_all_info_basic');
    ac_det.style.display = "inline-block";
    d_xcl.style.display = "none";
    s_list.style.display = "inline-block";
    email.style.display = "inline-block";
    
    switch(sel) {
        case "CNTCT":
            ac_det.style.display = "none";
            break;
        case "SHRT":
            s_list.style.display = "none";
            break;
		
    }
	if(sel=="SEL") {
		$('#select_all_info_basic').css('display','none');
	}
}
