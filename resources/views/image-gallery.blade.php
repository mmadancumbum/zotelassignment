<!DOCTYPE html>
<html>
<head>
    <title>Image Gallery Example</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- References: https://github.com/fancyapps/fancyBox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
    <style type="text/css">
    .gallery
    {
        display: inline-block;
        margin-top: 20px;
    }
    .close-icon{
    	border-radius: 50%;
        position: absolute;
        right: 5px;
        top: -10px;
        padding: 5px 8px;
    }
    .form-image-upload{
        background: #e8e8e8 none repeat scroll 0 0;
        padding: 15px;
    }
    </style>
</head>
<body>


<div class="container">


    <!-- <h3>Laravel - Image Gallery CRUD Example</h3> -->
    <form action="{{ url('image-gallery') }}" class="form-image-upload" method="POST" enctype="multipart/form-data">


        {!! csrf_field() !!}


        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
        @endif


        <div class="row">
            <div class="col-md-3">
                <strong>Title:</strong>
                <input type="text" name="title" class="form-control" placeholder="Title">
            </div>
            <div class="col-md-3">
                <strong>Description:</strong>
                <input type="description" name="description" class="form-control" placeholder="Description">
            </div>
            <div class="col-md-3">
                <strong>Image:</strong>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="col-md-3">
                <br/>
                <button type="submit" class="btn btn-success">Upload</button>
            </div>
        </div>


    </form> 


    <div class="row">
    <div class='list-group gallery'>


            @if($images->count())
                @foreach($images as $image)
                <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                    <a class="thumbnail fancybox" rel="ligthbox" href="/images/{{ $image->image }}" target="_blank">
                        <img class="" style="height: 220px;width:500px;" alt="image" src="/images/{{ $image->image }}" />
                        <div class='text-center'>
                            <small class='text-muted'>{{ $image->title }}</small><br>
                            <h5>Description: </h5>
                            <small class='text-muted' style="text-align:justified">{{ $image->description }}</small>
                        </div> <!-- text-center / end -->
                    </a>

                    <!-- <a href="{{ url('image-gallery-edit',$image->id) }}">
                    <button type="submit" class="edit-icon btn btn-primary"><i class="glyphicon glyphicon-edit"></i>
                    </a> -->
                    <button type="button" onclick=function1("{{ $image->id }}") class="btn btn-info btn-sm" data-toggle="modal" style="float:left;margin-top:-15px;" data-target="#myModal">Edit</button>

                    
                    <form action="{{ url('image-gallery',$image->id) }}" method="POST">
                    <input type="hidden" name="_method" value="delete">
                    @csrf
                    <!-- <button type="submit" type="button" style="float:right;margin-top:-15px;" class="btn btn-danger btn-sm" onClick="confSubmit(this.form);">Delete</button> -->
                    <input type="button" onClick="confSubmit(this.form);" value="Delete" style="float:right;margin-top:-15px;" class="btn btn-danger btn-sm">
                    </form>
                </div> <!-- col-6 / end -->
                @endforeach
            @endif


        </div> <!-- list-group / end -->
    </div> <!-- row / end -->
</div> <!-- container / end -->


</body>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <img class="" style="height: 220px;width: 500px;" alt="" id="imageName" src=""/>
            <div class='text-center'>
                <form method='post' action = "/image-gallery-update">
                    @csrf
                <input type="hidden" name="id" id="imgId">
                <input type="text" name="title" id="imgName" style="margin-top:20px">
                <h5>Description: </h5>
                    <input type="text" name="description" id="imgDesc">
                    <br>
                    <input class="btn btn-primary" type="submit" name="Update" value="Update" style="margin-top:10px">
                </form>
            </div> <!-- text-center / end -->
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });
     });

     function confSubmit(form) {
        if (confirm("Are you sure you want to delete the Image?")) {
        form.submit();
        }

        else {
        // alert("You decided to not submit the form!");
        }
    }


     function function1(userId)
     {
        $.ajax({
                    type: 'GET',  
                    url: '/image-gallery-edit/'+userId,
                    dataType: "json",
                    data: { id: userId },
                    success: function(response) { 
                        // console.log(response.data); 
                        var data = response.data;
                        console.log(data.image);
                        document.getElementById("imageName").src = "/images/"+data.image;
                        document.getElementById("imgId").value = data.id;                                 
                        document.getElementById("imgName").value = data.title;
                        document.getElementById('imgDesc').value = data.description;

                    }
                });
     }
     
</script>
</html>