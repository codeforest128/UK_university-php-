function change_map_focus(location) {
    map = document.getElementById('contact-map');
    switch (location) {
        case "imp":
            dest = "Imperial%20College%20London";
            break;
        case "dur":
            dest = "Durham";
            break;
        case "cam":
            dest = "Cambridge";
            break;
        case "ucl":
            dest = "University%20College%20London";
            break;
        default:
            dest = "Oxford";
    }
    map.src = "https://maps.google.com/maps?width=100%&height=600&hl=en&q=" + dest + "+(OCH)&ie=UTF8&t=&z=14&iwloc=B&output=embed";
}