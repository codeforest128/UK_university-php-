
<?php
    # Begin forming document
    $page_title = "Analytics";
    include_once "components/header.php";
    include_once "../../classes/DB.php";
    include_once "../../classes/login.php";
	
    # Get constants
    include_once "../arrays.php";
     # Check if logged in      
     if (!Login::isClientLoggedIn()) {
        header("Location: login.php");
    } else {
        $cStrong = true;
        $ajax_token = bin2hex(openssl_random_pseudo_bytes(64, $cStrong));
        setcookie("ajax_ver", $ajax_token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
    }

    # Verify cookies
    if (isset($_COOKIE['SNID'])) {
        $token = $_COOKIE['SNID'];
        $clientid = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];
        $sectors = "";
        $kind = "";
    }

    # Check if logout has been requested 
    if (array_key_exists('logout', $_POST)) {
        $sql = "DELETE FROM client_login_token "
             . "WHERE client_id = :clientid";
        DB::query($sql, array(':clientid' => Login::isClientLoggedIn()));
        header("Location: login.php");
    }
?>

<style>

    .account-pages {
      background-color: #f8f9fa !important;
      padding: 25px 0px;
    }

    .personal-detaile-sec {
      background: #fff;
      padding: 20px;
      box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.05);
    }

    .personal-detaile-sec h1 {
      font-weight: 400;
      padding-bottom: 25px;
      color: #595454;
      text-indent: 10px;
    }
    
    /*.box-state {
        height: 120px;
        width: 120px;
        border-radius: 100%;
        border: 1px solid #333;
        margin: auto;
    }*/
    
    
    .user-lists {
      padding: 20px 0px;
    }

    .user-lists h1 {
      font-size: 20px;
      color: #333;
    }

    .user-lists h4 {
      font-size: 14px;
      padding: 6px 0px;
    }

    .panel {
      border-width: 0 0 1px 0;
      border-style: solid;
      border-color: #fff;
      background: none;
      box-shadow: none;
    }

    .panel:last-child {
      border-bottom: none;
    }

    .panel-group>.panel:first-child .panel-heading {
      border-radius: 4px 4px 0 0;
    }

    .panel-group .panel {
      border-radius: 0;
    }

    .panel-group .panel+.panel {
      margin-top: 0;
    }

    .panel-heading {
      background-color: #fff;
      border-radius: 0;
      border: none;
      color: #0c0b0b !important;
      padding: 0;
      box-shadow: 1px 3px 5px rgba(134, 127, 127, 0.19);
    }
    
    h4.panel-title {
      margin-bottom: .5em;
    }

    .panel-title button {
      display: block;
      color: #595454;
      padding: 19px;
      position: relative;
      font-size: 17px;
      font-weight: 600;
      background: none;
      border: none;
      width: 100%;
      text-align: left;
    }
    
    .panel-title button:focus {
        outline: none;
    }
    
    .panel-title button i {
      float: right;
    }

    .panel-body {
      background: #fff;
      padding: 16px;
    }

    .panel:last-child .panel-body {
      border-radius: 0 0 4px 4px;
    }

    .panel:last-child .panel-heading {
      border-radius: 0 0 4px 4px;
      transition: border-radius 0.3s linear 0.2s;
    }

    .panel:last-child .panel-heading.active {
      border-radius: 0;
      transition: border-radius linear 0s;
    }
    
    
    
    /* #bs-collapse icon scale option */

    .panel-heading.active button:before {
      content: ' ';
      transition: all 0.5s;
      transform: scale(0);
    }

    #bs-collapse .panel-heading button:after {
      content: ' ';
      font-size: 24px;

      right: 5px;
      top: 10px;
      transform: scale(0);
      transition: all 0.5s;
    }

    #bs-collapse .panel-heading.active button:after {
      transform: scale(1);
      transition: all 0.5s;
    }
    
    /* #accordion rotate icon option */
    
    #accordion .panel .panel-heading .panel-title button i:before {
      right: 5px;
      top: 10px;
      transform: rotate(180deg);
      transition: all 0.5s;
    }

    #accordion .panel .panel-heading.active .panel-title button i:after {
      transform: rotate(0deg);
      transition: all 0.5s;
    }
    
    .animated-text .form-control {
      border: none !important;
      box-shadow: 0px 0px 1px #7d7e80;

    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .my-network .count {
      color: #f25006;
      font-size: 27px;
    }

    .my-network {
      background: #fff;
      box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.23);
    }

    .my-network h2 {
      font-size: 18px;
      text-transform: uppercase;
      background: #4b4e4c;
      color: #fff;
      padding: 9px;
    }

    .my-network h3 {
      font-size: 16px;
      padding: 10px 0;
    }

    .my-network h1 {
      font-size: 22px;
    }

    .my-network p {
      padding: 1px 12px 24px;
    }

    .upload-box h3 {
      font-size: 20px;
    }
    
    .box-state img {
      height: 150px;
      border-radius: 100%;
      border: 1px solid #333;
    }
    
    .update-resume h2 {
      font-size: 18px;
      text-transform: uppercase;
      background: #00003c;
      color: #fff;
      padding: 9px;

    }

    .update-resume {
      background: #fff;
      box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.05);
    }

    .resume-count {
      color: #60c211;
      font-size: 27px;
    }

    .upload-box {
      padding: 30px 0px;
    }

    .upload-img {
      background: #acd7fb;
    }
    
    .icon-right {
      float: right;
    }

    .loader-box h2 {
      font-size: 25px;
    }

    .student-icon img {
      height: 40px;
      width: 40px;
      float: left;
      border-radius: 100%;
    }

    .clean-navbar .navbar-nav .nav-link {
      font-weight: 600;
      font-size: .8rem;
      text-transform: uppercase;
      float: left;
    }

    .logout-icon {
      line-height: 2;
    }

    .student-icon {
      border-right: 2px solid #908c8c;
      line-height: 2;
    }

    .btn-dark1 {
      width: 160px;
      background: #f57553;
      color: #fff;
      margin: 15px 0px;
    }

    .btn-dark2 {
      width: 160px;
      border: 1px solid #333;
      color: #e94c23 !important;
      margin: 15px 15px;

    }

    .btn-info {
      color: #4b4e4c;
      background-color: #acd7fb4d;
      border-color: #3b99e0;
    }

    .footer-send-btn {
      border-top: 1px solid #3333
    }

    .btn-dark1:hover {
      box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
    }

    .btn-dark2:hover {
      box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
      background: ;
    }

    .btn-info2 {
      color: #fff;
      background-color: #f57553;
    }

    .state-btn {
      margin-top: 30%;
    }

    .form-wrapper {
      margin: 10px auto;
    }

    .form-group {
      position: relative;

      &+.form-group {
        margin-top: 30px;
      }
    }

    .form-label {
      position: absolute;
      left: 0;
      top: 10px;
      background-color: #fff;
      z-index: 10;
      color: #201e1e;
      font-size: 14px;
      transition: transform 150ms ease-out, font-size 150ms ease-out;
    }

    .focused .form-label {
      transform: translateY(-125%);
      font-size: .75em;
    }

    .form-input {
      position: relative;
      padding: 12px 0px 5px 0;
      width: 100%;
      outline: 0;
      border: 0;
      box-shadow: 0 1px 0 0 #e5e5e5;
      transition: box-shadow 150ms ease-out;

      &:focus {
        box-shadow: 0 2px 0 0 blue;
      }
    }

    .form-input.filled {
      box-shadow: 0 2px 0 0 lightgreen;
    }

    .star {
      color: #ed5f3a;
    }

    .account-form {
      padding-right: 0px;
      padding-left: 0px;
      border: 1px solid #5f5c5c1a;
    }

    .education-title {
      border-bottom: 2px solid #acd7b2;
      font-size: 22px;
      padding: 8px 0px;
      color: #00003b;
    }

    .ks-cboxtags li {
      float: left;

    }

    .ks-cboxtags li label {
      display: inline-block;
      background-color: rgba(255, 255, 255, .9);
      border: 2px solid rgba(139, 139, 139, .3);
      color: #adadad;
      border-radius: 25px;
      white-space: nowrap;
      margin: 3px 0px;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      -webkit-tap-highlight-color: transparent;
      transition: all .2s;
    }

    .ks-cboxtags li label {
      padding: 3px 9px;
      cursor: pointer;
      margin: 3px;
      font-size: 15px;
    }

    .ks-cboxtags li label::before {
      display: inline-block;
      font-style: normal;
      font-variant: normal;
      text-rendering: auto;
      -webkit-font-smoothing: antialiased;
      font-family: "Font Awesome 5 Free";
      font-weight: 900;
      font-size: 12px;
      padding: 2px 6px 2px 2px;
      content: "\f067";
      transition: transform .3s ease-in-out;
    }

    .ks-cboxtags li input[type="checkbox"] {
      position: absolute;
      opacity: 0;
    }

    .ks-cboxtags li input[type="checkbox"]:checked+label {
      border: 2px solid #1bdbf8;
      background-color: #12bbd4;
      color: #fff;
      transition: all .2s;
    }

    .ks-cboxtags li input[type="checkbox"]:checked+label::before {
      content: "\f00c";
      transform: rotate(-360deg);
      transition: transform .3s ease-in-out;
    }

    .read-form h2 {
      font-size: 18px;
      color: #208ec5;
      font-weight: bold;
    }

    .table-responsive {
      display: inline-block;
      width: 100%;
      overflow-x: auto;
    }

    .info h4 {
      font-size: 18px;
      margin-bottom: 16px;
    }

    a:hover {
      text-decoration: none;
    }
    
    .modal-header .close {
      position: absolute;
      top: 5px;
      right: 10px;
    }
    
    .cv_box {
        width: 100%;
    }

    .grid-container {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1.5fr;
        grid-template-rows: 1fr 1fr 1fr;
        grid-template-areas: "Candidates Area-2 Area-4" "Area-3 Area-3 Area-4" "Area-5 Area-6 Area-7";
    }

    .Candidates { grid-area: Candidates;   box-shadow: 0px 0px 8px 5px #888888; margin:10px; padding: 10px}

    .Area-2 { grid-area: Area-2; box-shadow: 0px 0px 8px 5px #888888; margin:10px; padding: 10px}

    .Area-3 { grid-area: Area-3; box-shadow: 0px 0px 8px 5px #888888; margin:10px; padding: 10px}

    .Area-4 { grid-area: Area-4; box-shadow: 0px 0px 8px 5px #888888; margin:10px; padding: 10px}

    .Area-5 { grid-area: Area-5; box-shadow: 0px 0px 8px 5px #888888; margin:10px; padding: 10px}

    .Area-6 { grid-area: Area-6; box-shadow: 0px 0px 8px 5px #888888; margin:10px; padding: 10px}

    .Area-7 { grid-area: Area-7; box-shadow: 0px 0px 8px 5px #888888; margin:10px; padding: 10px}

    .numbers {
        position: relative;
        text-align: center;
        top: 35%;
        
        font-size: 7em;
    }
  </style>
<body>
    <?php
        include_once "components/new_navbar.php";
    ?>
    <div class="grid-container">
        <div class="Candidates">
            <h1> More Analytics </h1>
            
            <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js'></script>
            <canvas id="bar-chart-horizontal" width="100" height="50"></canvas>

            <script>
            new Chart(document.getElementById("bar-chart-horizontal"), {
            type: 'horizontalBar',
            data: {
            labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
            datasets: [
                {
                label: "Candidates",
                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                data: [12, 4, 12, 43, 11]
                }
            ]
            },
            options: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Candidate Diversity Breakdown'
            }
            }
        });
        </script>
        </div>

        <div class="Area-2">
            <h1> Number of Contacts </h1>
            <canvas id="Area-2-Chart" width="100" height="50"></canvas>
            <select name="job" id="job" onchange="changeJob()">
                <option value="business analyst intern">BA</option>
                <option value="technology graduate">Tech</option>
                <option value="technology intern">Tech intern</option>
                <option value="sales and trading intern">S&T</option>
            </select> 
            <script>
            var e = document.getElementById("job");
            var strUser = e.options[e.selectedIndex].value;
            var ctx = document.getElementById('Area-2-Chart').getContext('2d');

            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                labels: ["Durham", "LSE", "Imperial", "Cambridge", "Oxford"],
                datasets: [
                    {
                    label: "Candidates",
                    backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                    data: [12, 13, 14, 0, 2]
                    }
                ]
                },
                options: {
                title: {
                    display: true,
                    text: 'Candidates applied to job ' + strUser
                }
                }
            });
            function changeJob() {
                var e = document.getElementById("job");
            var strUser = e.options[e.selectedIndex].value;
                myDoughnutChart.title.text = 'Candidates applied to job ' + strUser;
            }
            </script>
             
        </div>
        <div class="Area-3">
            <h1> Course Breakdown </h1>
        </div>
        <div class="Area-4">
            <h1> Course Breakdown </h1>

            <canvas id="myChart" width="50" height="60"></canvas>
        <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mathematics', 'Computer Science', 'Economics', 'Physics', 'History', 'Chemical Engineering'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        text: "No. of Students",
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        text: "Degree Subjects"
                    }]
                }
            }
        });
        </script>
        </div>
        <div class="Area-5">
            <h1> Number of Contacts </h1>
            <h2 class='numbers'>
            <?php
                $contacts = DB::query('SELECT * FROM contacts WHERE client_id="' . $clientid . '"');
                echo count($contacts);
            ?>
            </h2>
        </div>
        <div class="Area-6">
            <h1> Grad Years </h1>
            <canvas id="radar-chart" width="100" height="100"></canvas>
            <script>
                new Chart(document.getElementById("radar-chart"), {
                type: 'radar',
                data: {
                labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
                datasets: [
                    {
                    label: "1950",
                    fill: true,
                    backgroundColor: "rgba(179,181,198,0.2)",
                    borderColor: "rgba(179,181,198,1)",
                    pointBorderColor: "#fff",
                    pointBackgroundColor: "rgba(179,181,198,1)",
                    data: [8.77,55.61,21.69,6.62,6.82]
                    }, {
                    label: "2050",
                    fill: true,
                    backgroundColor: "rgba(255,99,132,0.2)",
                    borderColor: "rgba(255,99,132,1)",
                    pointBorderColor: "#fff",
                    pointBackgroundColor: "rgba(255,99,132,1)",
                    pointBorderColor: "#fff",
                    data: [25.48,54.16,7.61,8.06,4.45]
                    }
                ]
                },
                options: {
                title: {
                    display: true,
                    text: 'Distribution in % of world population'
                }
                }
            });

            </script>
        </div>
        <div class="Area-7">
        
            <h1> Number of Shortlists </h1>
            <h2 class='numbers'>
            <?php
                $short_list = DB::query('SELECT * FROM short_list WHERE client_id="' . $clientid . '"');
                echo count($short_list);
            ?>
       </h2>
        </div>
    </div>



    <?php
        include_once "components/new_footer.php";
    ?>
</body>
</html>


<!-- Load in JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script type="text/javascript" src="scripts/analytics_graphs.js"></script>
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js'></script>
<!-- Load in Signature support -->
<link type="text/css" href="css/jquery.signature.css" rel="stylesheet">
<script type="text/javascript" src="signature_js/jquery.signature.js"></script>

<!-- Check if it's first time login / if they've signed agreement -->
<?php
    $token = $_COOKIE['SNID'];
    $client_id = DB::query('SELECT client_id FROM client_login_token WHERE token=:token', array(':token' => sha1($token)))[0]['client_id'];
    $sql = "SELECT 'privacy' FROM 'clients' WHERE 'id'=:cid";
    $client_priv = DB::query($sql, array(":cid" => $client_id))[0]["privacy"];
    if ($client_priv == 0) {
        include_once "components/modals/privacy_modal.php";
    }
?>