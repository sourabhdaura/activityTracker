<?php
require_once('db/conn.php');
require_once('views/header.php');
global $conn;
require_once('db/fetch-data.php');
$Catresult = fetch_category_data();

?>

<style>
a.navbar-brand.active {
    float: left;
    height: 60px !important;
    padding: 0px 15px!important;
    font-size: 18px;
    line-height: 20px;
}
img.myimage {
	height:70px;
	width:70px;
	border-radius:50%;
}

</style>

<td>
   <!-- dropdown catagories -->
          <label for="sel1" class="col-sm-8 col-form-label">Select Category</label>

            <div class="col-sm-4">

              <select class="form-control" name="cateselect">
                <?php
                $allcatnames = fetch_all_categories();
                if (!empty($allcatnames)) { ?>
                  <?php for ($i = 0; $i < count($allcatnames); $i++) : ?>
                    <option value="<?= $allcatnames[$i]['id'] ?>"><?= $allcatnames[$i]['name'] ?></li>
                    <?php endfor; ?>
                  <?php } ?>

              </select>
            </div>
</td>
<div class="add-category">
  <h4>Add category</h4>
  <form action="db/addcategory.php" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-6">
        <label for="name" class="col-sm-4 col-form-label">Name</label>
        <div class="col-sm-6">
          <input type="text" name="name" class="form-control" id="name" required>
        </div>
		</div>
		<br/></div>
		<br/>
			<div class="col-md-6">
			<div class="col-sm-4 col-sm-offset-4">
			 <input type="file" name="upload" >
                    <!--<span class="error"><?//php echo $ERROR['upload']; ?></span>-->
			</div></div>
        <div class="col-md-3">
          <button type="submit" name="submit" value="submit" class="btn btn-primary">Add</button>
        </div>
      </div>

    </div>
  </form>
</div>


<div class="category-listing">
  <h4>Categories</h4>
  <table id="categories" class="display" style="width:100%">
    <thead>
      <tr>
        <th>Name</th>

        <th>Actions</th>
				 <th>Images</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($Catresult)) { ?>
        <?php for ($i = 0; $i < count($Catresult); $i++) : ?>
          <tr id="<?php echo $Catresult[$i]['id']; ?> ">
            <?php $catid = $Catresult[$i]['id']; ?>

 
 <td>   <figure class='Images'>
                        <?php echo "<img class = 'myimage' alt='Image was not uploaded'  src = 'db/image/".$Catresult[$i]['photo']."'>";?>
						
                    </figure></td>
<td><button class="btn  btn-lg" data-toggle="modal" data-target="#myModal<?= $catid ?>" onclick="fetch_category(<?php echo $Catresult[$i]['id'] ?>)"><?= $Catresult[$i]['name'] ?></button>


</td>

			
			
			<!-- Modal -->
            <div class="modal fade" id="myModal<?= $catid ?>" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Category include these Activities</h4>
                  </div>

                  <div class="modal-body">
                    <?php $relatedActivities = fetch_category($catid); ?>
                    <?php for ($j = 0; $j < count($relatedActivities); $j++) : ?>

                      <?php if ($relatedActivities[$j]['id']  != $catid) { ?>
                        <h3> <?= $j + 1, ". ", $relatedActivities[$j]['name']; ?></h3>
                      <?php  } else {
                        break;
                      } ?>
                    <?php endfor;
                    if (sizeof($relatedActivities) <= 0) { ?>
                      <h3>No Activities in this Category.</h3>
                    <?php
                    } ?>

                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>

              </div>
            </div>






            <td><button type="button" class="btn btn-xs btn-primary editBtn" name="editBtn" data-toggle="modal" id="editBtn" data-target="#editModel">Edit</button>
              <button type="button" data-toggle="modal" id="deleteBtn" data-target="#exampleModal" class="btn btn-xs btn-danger deleteBtn">Delete</button>
              <!-- Button trigger modal -->
            <?php endfor; 
 //for ($i = 0; $i < count($Catresult); $i++) :
 ?>

            </td>
			   
          </tr>

        <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <th>Name</th>
        <th>Actions</th>
      </tr>
    </tfoot>
  </table>
</div>


<!-------------Delete Modal ----------------->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete category?
        <form method="post" action="db/deletecategory.php">
          <input type="hidden" name="deleteId" id="deleteId" />

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" name="delete" class="btn btn-primary">Confirm Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('.deleteBtn').on('click', function() {
      $tr = $(this).closest('tr').attr('id');
      //  var data =$("td:nth-child(2)").attri();
      //  }).get();
      console.log($tr);

      $('#deleteId').val($tr);

    });
  });
</script>

<!---------End Delete Model------------>



<!--------Edit Model-------------------->
<div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Are you sure you want to delete activity? -->
        <form method="post" action="db/editcategory.php">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="editName" id="editName" placeholder="Enter Name">
          </div>

          <input name="edit-id" id="edit-id" type="hidden" />

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" name="edit" class="btn btn-primary">Confirm Edit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('.editBtn').on('click', function() {
      console.log("hello");
      $tr = $(this).closest('tr').attr('id');
      var data = $(this).closest('tr').children("td").map(function() {
        return $(this).text();
      }).get();
      //  console.log(data[3].split('h'));
      $('#edit-id').val($tr);
      $('#editName').val(data[0]);
    });
  });
</script>
<!---------End Delete Modal----------->
<?php require_once('views/footer.php')  ?>