<!DOCTYPE html>
<html>
<head>
	<title>Laravel 5.7 Ajax CRUD Example</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css">
</head>
<body>
	<div class="container">
		<div class="row " style="margin-top:3%">
		    <div class="col-lg-12 ">
		        <div class="pull-left">
		            <h2>Laravel 5.7 Ajax CRUD Example</h2>
		        </div>
		        <div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">Create New Post</button>
		        </div>
		    </div>
		</div>
		<table class="table table-bordered">
			<thead>
			    <tr>
				<th>Id</th>
				<th>Title</th>
				<th>Details</th>
				<th width="200px">Action</th>
			    </tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		<ul id="pagination" class="pagination-sm"></ul>





<!-- >>>>>>>>><<<<<<<<< -->
<!-- The Edit  Modal -->
<!-- >>>>>>>>><<<<<<<<< -->
<div class="modal" id="edit-item">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form class="">

			<div class="form-group">
			  <label for="title">Title:</label>
			  <input type="text" class="form-control" name="title" id="title">
			</div>


			<div class="form-group">
			  <label for="details">Comment:</label>
			  <textarea class="form-control" name="details" rows="5" id="details"></textarea>
			</div>
			<!-- crud-submit-edit -->
        </form>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success crud-submit-edit">Submit</button>        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>






<!-- >>>>>>>>><<<<<<<<< -->
<!-- The Insert  Modal -->
<!-- >>>>>>>>><<<<<<<<< -->
<div class="modal" id="create-item">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create New Post</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form action="/posts">

			<div class="form-group">
			  <label for="title">Title:</label>
			  <input type="text" class="form-control" name="title" id="title">
			</div>


			<div class="form-group">
			  <label for="details">Comment:</label>
			  <textarea class="form-control" name="details" rows="5" id="details"></textarea>
			</div>
			<!-- crud-submit-edit -->
        </form>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success crud-submit">Submit</button>        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!-- >>>>>>>>><<<<<<<<< -->
<!-- The View Post  Modal -->
<!-- >>>>>>>>><<<<<<<<< -->
<div class="modal" id="view-item">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create New Post</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form action="/posts">

			<div class="form-group">
			  <label for="title">Title:</label>
			  <input type="text" disabled="" class="form-control" name="title" id="title">
			</div>


			<div class="form-group">
			  <label for="details">Comment:</label>
			  <textarea class="form-control" name="details" disabled="" rows="5" id="details"></textarea>
			</div>
			<!-- crud-submit-edit -->
        </form>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">    
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>







	</div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

	<script type="text/javascript">
		var url = "<?php echo route('posts.index')?>";
	</script>
	<script >
		
var page = 1;
var current_page = 1;
var total_page = 0;
var is_ajax_fire = 0;



manageData();

/* manage data list */
function manageData() {
    $.ajax({
        dataType: 'json',
        url: url,
        data: {page:page}
    }).done(function(data) {
    	total_page = data.last_page;
    	current_page = data.current_page;
    	sl = current_page + 1 ;

    	

    	$('#pagination').twbsPagination({
	        totalPages: total_page,
	        visiblePages: current_page,
	        onPageClick: function (event, pageL) {
	        	page = pageL;


                if(is_ajax_fire != 0){
		
	        	  getPageData();


                }
	        }
	    });
    	manageRow(data.data);
        is_ajax_fire = 1;
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/* Get Page Data*/
function getPageData() {
	$.ajax({
    	dataType: 'json',
    	url: url,
    	data: {page:page}
	}).done(function(data) {

		
		manageRow(data.data);
	});
}

/* Add new Post table row */
	var serial = 1;//mr
function manageRow(data) {
	var	rows = '';

this.serial = 5 * page;//mr


	$.each( data, function( key, value ) {
	  	rows = rows + '<tr>';
	  	rows = rows + '<td >'+(serial-4)+'</td>';
	  	rows = rows + '<td>'+value.title+'</td>';
	  	rows = rows + '<td>'+value.details+'</td>';
	  	rows = rows + '<td data-id="'+value.id+'"   width="250">';
        rows = rows + '<button data-toggle="modal" data-target="#view-item" class="btn btn-info view-item">View</button> ';
        rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item">Edit</button> ';
        rows = rows + '<button class="btn btn-danger remove-item">Delete</button>';
        rows = rows + '</td>';
	  	rows = rows + '</tr>';

	  

	  	serial++;//mr

	  	
	});
	$("tbody").html(rows);
}

/* Create new Post */
$(".crud-submit").click(function(e) {
    e.preventDefault();
    var form_action = $("#create-item").find("form").attr("action");
    var title = $("#create-item").find("input[name='title']").val();
    var details = $("#create-item").find("textarea[name='details']").val();
    $.ajax({
        dataType: 'json',
        type:'POST',
        url: form_action,
        data:{title:title, details:details}
    }).done(function(data){
        getPageData();
        $(".modal").modal('hide');
        toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
    });
});

/* Remove Post */
$("body").on("click",".remove-item",function() {
    var id = $(this).parent("td").data('id');
    var c_obj = $(this).parents("tr");
    $.ajax({
        dataType: 'json',
        type:'delete',
        url: url + '/' + id,
    }).done(function(data) {
        c_obj.remove();
        toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        getPageData();
    });
});

/* Edit Post */
$("body").on("click",".edit-item",function() {
    var id = $(this).parent("td").data('id');
    var title = $(this).parent("td").prev("td").prev("td").text();
    var details = $(this).parent("td").prev("td").text();
    $("#edit-item").find("input[name='title']").val(title);
    $("#edit-item").find("textarea[name='details']").val(details);
    $("#edit-item").find("form").attr("action",url + '/' + id);
});





/* View Post */ //mr
$("body").on("click",".view-item",function() {
    var id = $(this).parent("td").data('id');
    var title = $(this).parent("td").prev("td").prev("td").text();
    var details = $(this).parent("td").prev("td").text();
    $("#view-item").find("input[name='title']").val(title);
    $("#view-item").find("textarea[name='details']").val(details);
});





/* Updated new Post */
$(".crud-submit-edit").click(function(e) {
    e.preventDefault();
    var form_action = $("#edit-item").find("form").attr("action");
    var title = $("#edit-item").find("input[name='title']").val();
    var details = $("#edit-item").find("textarea[name='details']").val();
    $.ajax({
        dataType: 'json',
        type:'PUT',
        url: form_action,
        data:{title:title, details:details}
    }).done(function(data){
        getPageData();
        $(".modal").modal('hide');
        toastr.success('Post Updated Successfully.', 'Success Alert', {timeOut: 5000});
    });
});	







	</script> 
</body>
</html>