<?php
  include 'dbconn.php';
  $limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 5000;
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $start = ($page - 1) * $limit;
  $result = $dbconnection->query("SELECT * FROM entries");
  $contributions = $result->fetch_all(MYSQLI_ASSOC);

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <div class="contrainer well">
      <h1 class="text-center">Canreal - Contributions</h1>
      <div class="row">
        <div class="col-md-10">
          <nav aria-label="Page navigation">
            <ul class="listing">
              <li>
                <a href="index.php?page=<?= $Previous; ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo; Previous</span>
              </li>
              <?php for($i = 1; $i<= $pages; $i++) : ?>
                <li><a href="index.php?page=<?= $i; ?>"><?= $i; ?></a></li>
              <?php endfor; ?>
              <li>
                <a href="index.php?page=<?= $Next; ?>" aria-label="Next">
                  <span aria-hidden="true">Next &raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="text-center" style="margin-top: 20px; " class="col-md-2">
          <form method="post" action="#">
            <select name="limit-records" id="limit-records">
              <option disabled="disabled" selected="selected">---Limit Records---</option>
              <?php foreach([10,100,500,1000,5000] as $limit): ?>
                <option <?php if(isset($_POST["limit-records"]) && $_POST["limit-records"] == $limit) echo "selected" ?> value="<?= $limit; ?>"><?= $limit; ?></option>
              <?php endforeach; ?>
            </select>
          </form>
      </div>
  </div>
  <div style="height: 600px; overflow-y: auto;">
    <table id="" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
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
            <td><?= $contribution['Username']; ?></td>
            <td><?= $contribution['Platform']; ?></td>
            <td><?= $contribution['Dest_Platform']; ?></td>
            <td><?= $contribution['Description']; ?></td>
            <td><?= $contribution['Link']; ?></td>
            <td><?= $contribution['AddedBy']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div style="position: fixed; bottom: 10px; right: 10px; color: green;">
    <strong>
      Thank you for all your contributions!
    </strong>
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
