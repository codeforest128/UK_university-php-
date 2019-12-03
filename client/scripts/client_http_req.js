var xhr = null;

async function request(url, variables, destination, async = true) {
    var finUrl = createUrl(url, variables);
    try {
        xhr = [new XMLHttpRequest(), destination];
    } catch (e) {
        return;
    }
    xhr[0].onreadystatechange = stateChanged;
    xhr[0].open("GET", finUrl, async);
    xhr[0].send();
}

function stateChanged() {
    if (xhr[0].readyState == 4) {
        if (xhr[1] != null) {
            if (xhr[1] == 'update') {
                update_selected_candidate(latest_selected_candidate_id);
            } else {
                document.getElementById(xhr[1]).innerHTML = xhr[0].responseText;
            }
        }
    }
}

function createUrl(url, variables) {
    if (variables == null) {
        return url;
    }
    var res = url + "?";
    for (var key in variables) {
        if (variables.hasOwnProperty(key)) {
            res += key + "=" + variables[key] + "&";
        }
    }
    return res.slice(0, -1);
}