function openTab(evt, tabSet, tabName) {
	
    // Declare all variables
    var i, tabcontent, tablinks;
	sessionStorage.setItem("tbname",tabName);
	// if(tabName=="search_tab") {
		// $('#basic_search_button').addClass('active');
		// $('#smart_search_button').removeClass('active');
		
		// $('#search_tab').css('right','0');
		// $('#smart_search_tab.closed_search_tab').css('right','100%');
	// } else if(tabName=="smart_search_tab") {
		
		// $('#search_tab').css('right','100%');
		// $('#smart_search_tab.closed_search_tab').css('right','0');
		// $('#smart_search_button').addClass('active');
		// $('#basic_search_button').removeClass('active');
	// }
    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent" + tabSet);
    for (i = 0; i < tabcontent.length; i++) {
        cTabName = tabcontent[i].id;
        if (cTabName == "search_tab" || cTabName == "smart_search_tab") {
            if (!document.getElementById(cTabName).classList.contains('closed_search_tab')) {
                document.getElementById(cTabName).classList.add('closed_search_tab');
            }
        } else {
            tabcontent[i].style.display = "none";
        }
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks" + tabSet);
    for (i = 0; i < tablinks.length; i++) { 
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
	
    // Show the current tab, and add an "active" class to the button that opened the tab
    if (tabName != "search_tab" && tabName != "smart_search_tab") {
        document.getElementById(tabName).style.display = "block";
    } else {
        document.getElementById(tabName).classList.remove('closed_search_tab');
    }
    evt.currentTarget.className += " active";
}

function openTab1(evt, tabSet, tabName) {
	
	sessionStorage.setItem("tbname",tabName);
	if(tabName=="search_tab") {
		$('#basic_search_button').addClass('active');
		$('#smart_search_button').removeClass('active');
		
		$('#search_tab').css('right','0');
		$('#smart_search_tab.closed_search_tab').css('right','-100%');
	} else if(tabName=="smart_search_tab") {
		
		$('#search_tab').css('right','100%');
		$('#smart_search_tab.closed_search_tab').css('right','0');
		$('#smart_search_button').addClass('active');
		$('#basic_search_button').removeClass('active');
	}
    // Get all elements with class="tabcontent" and hide them
   
}