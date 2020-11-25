<?php
  include 'dbconn.php';
  $limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 5000;
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $start = ($page - 1) * $limit;
  $result = $dbconnection->query("SELECT * FROM entries");
  $contributions = $result->fetch_all(MYSQLI_ASSOC);

  $getUsername = $dbconnection->query("SELECT `Username` FROM `users` WHERE `UserID` = '" + $contribution['UserID'] + "'");

  $result1 = $dbconnection->query("SELECT count(ID) AS ID FROM entries");
  $contCount = $result1->fetch_all(MYSQLI_ASSOC);
  $total = $contCount[0]['ID'];
  $pages = ceil( $total / $limit );

  $Previous = $page - 1;
  $Next = $page + 1;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Canreal - Contributions</title>

    <!-- Importing contributions_index.css -->
    <link rel="stylesheet" href="/css/contributions_index.css">

    <!-- Importing Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- Importing bootstrap_colors.css -->
    <link rel="stylesheet" href="/css/bootstrap_colors.css">

    <!-- Importing Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300&family=Open+Sans:wght@300&display=swap" rel="stylesheet">

    <!-- Importing jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-dark shadow sticky-top">
      <a class="navbar-brand" href="/index.html">Canreal</a>
    </nav>
    <div class="contrainer well">
  <div id="cont-menu" style="float: left;">
    <nav aria-label="Page navigation">
        <a class="btn btn-primary shadow" href="index.php?page=<?= $Previous; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo; Previous</span>
        <?php for($i = 1; $i<= $pages; $i++) : ?>
          <a href="index.php?page=<?= $i; ?>"><?= $i; ?></a>
        <?php endfor; ?>
        <a class="btn btn-primary shadow" href="index.php?page=<?= $Next; ?>" aria-label="Next">
        <span aria-hidden="true">Next &raquo;</span>
        </a>
    </nav>
  </div>

  <div style="padding-top: 17.5px;width: 50%; padding-right: 10%; float: right;" class="col-md-2">
    <form method="post" action="#">
      <select name="limit-records" id="limit-records">
        <option disabled="disabled" selected="selected">---Limit Records---</option>
        <?php foreach([10,25,50,100,200] as $limit): ?>
          <option <?php if(isset($_POST["limit-records"]) && $_POST["limit-records"] == $limit) echo "selected" ?> value="<?= $limit; ?>"><?= $limit; ?></option>
        <?php endforeach; ?>
      </select>
    </form>
</div>
  <section id="cont-table" style="height: auto; overflow-y: auto; width: 95%; margin-left: auto;margin-right: auto;">
    <table id="" class="table table-sm table-hover w-auto shadow-sm">
      <thead>
        <tr>
          <th>ID</th>
          <th>Date</br>[YYYY-MM-DD]</th>
          <th>Username</th>
          <th>Platform</th>
          <th>Contribution made for platform</th>
          <th>Description</th>
          <th>Link</th>
          <th>Added to database by</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($contributions as $contribution) : ?>
          <tr>
            <td><?= $contribution['ID']; ?></td>
            <td><?= $contribution['Date']; ?></td>
            <td><?= $getUsername; ?></td>
            <td><?= $contribution['Platform']; ?></td>
            <td><?= $contribution['Dest_Platform']; ?></td>
            <td><?= $contribution['Description']; ?></td>
            <td>
              <?php
                if(is_null($contribution['Link']) || $contribution['Link'] == "") {
                  echo "No link";
                } else {
                  echo '<a class="btn btn-primary shadow" href="'. $contribution['Link'].'">See more</a>';
                }
              ?>
            </td>
            <td><?= $contribution['AddedBy']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>


  <div class="alert alert-secondary" role="alert" style="margin-left: auto; margin-right: auto; width: 25%; text-align: center;">
      Thank you for all your contributions!
    <script type="text/javascript">
      $(document).ready(function() {
        $("#limit-records").change(function() {
          $('form').submit();
        })
      })
    </script>
  </div>
  </body>
</html>
