<?php
include('../../classes/DB.php');
include('../../classes/login.php');

if (!Login::isAdminLoggedIn()) {
  header("Location: login.php");
} else {
  $cStrong = true;
  $admin_ajax_token = bin2hex(openssl_random_pseudo_bytes(64, $cStrong));
  setcookie("admin_ajax_ver", $admin_ajax_token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
}

if (isset($_COOKIE['SNID'])) {
  $token = $_COOKIE['SNID'];
  $admin_id = DB::query('SELECT admin_id FROM admin_login_tokens WHERE token=:token', array(':token' => sha1($token)))[0]['admin_id'];
}

if (array_key_exists('logout', $_POST)) {
  DB::query('DELETE FROM admin_login_tokens WHERE admin_id=:admin_id', array(':admin_id' => Login::isAdminLoggedIn()));
  header("Location: login.php");
}

if (isset($_POST["title"])) {
  $bid = $_POST["id"];
  $title = $_POST['title'];
  $b_descr = $_POST['b_descr'];
  $body = $_POST['body'];
  $l_date = $_POST['live_date'];
  $author = $_POST['author'];
  $tags = $_POST["tags"];
  $processed_tags = "[";
  $split_tags = explode(",", $tags);
  foreach($split_tags as $tag) {
    $processed_tags .= "\"" . ltrim(rtrim($tag)) . "\", ";
  }
  $processed_tags = substr($processed_tags, 0, -2) . "]";
  
  $sql = "UPDATE `blogs` "
       . "SET `title`=:title, "
       . "`brief_descr`=:b_descr, "
       . "`body`=:body, "
       . "`scheduled_date`=:sdate, "
       . "`author`=:author, "
       . "`tags`=:tags "
       . "WHERE `id`=:id";
  DB::query($sql, array(":title" => $title, ":b_descr" => $b_descr, ":body" => $body, ":sdate" => $l_date, ":author" => $author, ":tags" => $processed_tags, ":id" => $bid));
}
?>

<?php include('header.php'); ?>

<section class="account-pages bg-light">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <?php include 'left_sidebar.php'; ?>
      </div>
      <div class="col-md-9 account-form">
        <div class="personal-detaile-sec ">
          <div class="row">
            <div class="col">
              <h3>Blogs</h3>
            </div>
            <div class="col text-right"><a href="add_blog.php"><button class="btn btn-primary">Add Blog</button></a></div>
          </div>
          <?php
            $all_blogs = DB::query('SELECT `title`, `brief_descr`, `scheduled_date`, `author`, `tags`, `id` FROM `blogs`', null);
          ?>
          <table id="table_id" class="display">
            <thead>
              <tr>
                <th>Title</th>
                <th>Brief Description</th>
                <th>Scheduled Date</th>
                <th>Author</th>
                <th>Tags</th>
                <th>View Blog</th>
                <th>Edit Blog</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($all_blogs as $keyBlog => $valueBlog) {
              ?>
              <tr>
                <td><?php echo $valueBlog["title"]; ?></td>
                <td><?php echo $valueBlog["brief_descr"]; ?></td>
                <td><?php echo $valueBlog["scheduled_date"]; ?></td>
                <td><?php echo $valueBlog["author"]; ?></td>
                <td><?php 
                  $tags = json_decode($valueBlog["tags"]);
                  foreach($tags as $tag) {
                    echo "<p class='badge badge-secondary'>" . $tag . "</p>";
                  }
                ?></td>
                <td><a href="***">Go to Blog</a></td>
                <td><button class="btn btn-info" onclick="edit_blog(<?php echo $valueBlog['id']; ?>)">Edit Blog</button></td>
              </tr>
              <?php 
                } 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('footer.php'); ?>

<!-- The Modal -->
<div class="modal" id="blog_details">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Client details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="form_blog_id">
            <label>Title</label>
            <input type="text" name="title" class="form-control" id="form_blog_title" required>
            <br />
            <label>Brief Description</label>
            <input type="text" name="b_descr" class="form-control" id="form_blog_descr" required>
            <br/>
            <label>Body</label>
            <textarea class="form-control" name="body" id="form_blog_body"></textarea>
            <br />
            <label>Scheduled Date</label>
            <input type="date" name="live_date" class="form-control" id="form_blog_date" required>
            <br />
            <label>Author</label>
            <input type="text" name="author" class="form-control" id="form_blog_author" required>
            <br />
            <label>Tags (Please enter as comma seperated list)</label>
            <input type="text" name="tags" class="form-control" id="form_blog_tags">
            <br />
            <button type="submit" class="btn btn-primary">Submit changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var xhr;

  function edit_blog(id) {
    var url = "requests/blog_details.php";
    var vari = {"id":id, "key":"<?php echo $admin_ajax_token; ?>"};
    var finUrl = createUrl(url, vari);
    try {
      xhr = new XMLHttpRequest();
    } catch (e) {
      return;
    }
    xhr.onreadystatechange = reveal_blog_modal;
    xhr.open("GET", finUrl, true);
    xhr.send();
  }

  function reveal_blog_modal() {
    if (xhr.readyState == 4) {
      alert(xhr.responseText);
      var response = JSON.parse(xhr.responseText);
      const ids = "form_blog_";
      document.getElementById(ids + "id").value = response.id;
      document.getElementById(ids + "title").value = response.title;
      document.getElementById(ids + "descr").value = response.b_descr;
      document.getElementById(ids + "body").value = response.body;
      document.getElementById(ids + "date").value = response.s_date;
      document.getElementById(ids + "author").value = response.author;
      var tagsString = "";
      response.tags.forEach(function(x) {
         tagsString += x + ", ";
      });
      document.getElementById(ids + "tags").value = tagsString.substring(0, tagsString.length-2);
      $('#blog_details').modal('show'); 
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
</script>