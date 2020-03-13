<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

	<div class="container">
		<div class="col-sm-3">
			<div class="panel">
				<dir class="panel-heading">
					<a href="#" class="btn btn-primary" id="createnewnote">New Note</a>
				</dir>
				<div class="panel-body">
					<ul id="notelist">
						@foreach($notes as $note)
						<li class="eachnote" data-id="{{encrypt($note->id)}}">{{$note->title}}</li>
						@endforeach
					</ul>	
				</div>
			</div>
		</div>	
		<div class="col-sm-9">
			<div class="panel" id="allcontentshowhere">
				<div id="actionoption" class="hide">
					<a href="#" data-id="" id="delete" disabled>Delete</a>
					<a href="#" data-id="" id="share" disabled>Share</a>
				</div>
				<div class="panel-body" contenteditable="true" id="notecontent">
				</div>
			</div>
		</div>	
	</div>

	<style type="text/css">
		/*textarea{
			width: 100%;
			height: 100vh;
			border: none;
			overflow: auto;
			outline: none;
			-webkit-box-shadow: none;
			-moz-box-shadow: none;
			box-shadow: none;
			resize: none;
		}

		textarea:active,textarea:focus,textarea:hover{
			
		    border: 0px;
		}*/
		div.editable {
		    border: 1px solid #ccc;
		    padding: 5px;
		    width: 100%;
			height: 100vh;
		}
		#notecontent{
			width: 100%;
			height: 100vh;
			outline: none;
			-webkit-box-shadow: none;
			-moz-box-shadow: none;
			box-shadow: none;
		}

		strong {
		  font-weight: bold;
		}
	</style>

	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<script type="text/javascript">

		let url = "{{url('notes')}}";

		$(document).on("click","#createnewnote",function(event){
			event.preventDefault();
			$("#notelist .eachnote").removeClass("active");
			$("#notelist").prepend('<li class="eachnote active" data-id="_new">New Note</li>');
			$("#notecontent").attr("data-id","_new");
			$("#delete").prop("disabled",true);
			$("#share").prop("disabled",true);
		});


		$(document).on("click",".eachnote",function(event){
			event.preventDefault();
			$("#notelist .eachnote").removeClass("active");
			var li = $(this);

			if(li.attr("data-id")!='New' || li.attr("data-id")!='new')
			{
				li.addClass("active");
				$.get(url+'/'+li.attr("data-id"),function(){

				}).done(function(res){
					li.text(res.title);
					li.attr("data-id",res.dataid);
					$("#notecontent").attr("data-id",res.dataid);
					$("#notecontent").html(res.content);

					$("#actionoption").show();
					$("#delete").prop("disabled",false);
		            $("#delete").attr("data-id",res.dataid);
		            $("#share").prop("disabled",false);
		            $("#share").attr("data-id",res.dataid);
				});
			}
		});

		// $(document).on("click","#delete",function(event){
		// 	event.preventDefault();
			
		// 	$("#notelist .eachnote").removeClass("active");
		// 	var li = $(this);

		// 	if(li.attr("data-id")!='New' || li.attr("data-id")!='new')
		// 	{
		// 		li.addClass("active");
		// 		$.get(url+'/'+li.attr("data-id"),function(){

		// 		}).done(function(res){
		// 			li.text(res.title);
		// 			li.attr("data-id",res.dataid);
		// 			$("#notecontent").attr("data-id",res.dataid);
		// 			$("#notecontent").html(res.content);

		// 			$("#actionoption").show();
		// 			$("#delete").prop("disabled",false);
		//             $("#delete").attr("data-id",res.dataid);
		//             $("#share").prop("disabled",false);
		//             $("#share").attr("data-id",res.dataid);
		// 		});
		// 	}
		// });





		
		// Get the input box
		//let input = document.getElementById('notecontent');
		let input = document.getElementById('notecontent');

		// Init a timeout variable to be used below
		let timeout = null;

		function saveNote(content,title,dataid)
		{
			$("#notelist li.active").text(title);
			var data = {
		        'content': encodeURI(content),
		        'title': encodeURI(title),
		        'dataid': dataid
			};
			$.ajax({
		        url: url,
		        type: 'POST',
		        data : data,
		        async: false,
		        cache: false,
		        error: function(){
		            console.log("Failed to save");
		        },
		        success: function(res){ 
		            $("#notecontent").attr("data-id",res.dataid);
		            $("#notelist li.active").attr("data-id",res.dataid);
		            $("#delete").prop("disabled",false);
		            $("#actionoption").show();

		            $("#delete").attr("data-id",res.dataid);
		            $("#share").prop("disabled",false);
		            $("#share").attr("data-id",res.dataid);
		        }
		    });
		}

		// Listen for keystroke events
		input.addEventListener('keyup', function (e) {
		    // Clear the timeout if it has already been set.
		    // This will prevent the previous task from executing
		    // if it has been less than <MILLISECONDS>
		    clearTimeout(timeout);

		    // Make a new timeout set to go off in 1000ms (1 second)
		    timeout = setTimeout(function () {
		    	var content = input.innerHTML;
		    	var dataid = $("#notecontent").attr("data-id");
		    	var first_line = $("#notecontent").contents().filter(function() { 
                     return !!$.trim(this.innerHTML||this.data);
                }).first();

		    	saveNote(content,first_line.text(),dataid);

		    	//var title = 
		        //console.log('Input Value:', content);
		    }, 1000);
		});
	</script>
</body>
</html>