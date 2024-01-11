<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Site</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row mt-4">
            {{-- form div --}}
            <div class="col-md-5 card">
                <h3 class="m-2">Create Post</h3>
                <form id="create_post_form">
                    <div class="form-group m-2">
                      <input type="text" name="title" class="form-control clear_input" placeholder="Enter Post Title">
                      <span class="clear_form_error text-danger" id="title_error"></span>
                    </div>
                    <div class="form-group m-2">
                      <textarea name="desc" id="" class="form-control clear_input" placeholder="Enter Desc"></textarea>
                      <span class="clear_form_error text-danger" id="desc_error"></span>
                    </div>
                    <div class="form-group m-2">
                        <select name="website"  class="form-control" id="exampleFormControlSelect2">
                            <option selected value="">Please Choose any website</option> 
                            @foreach ($webList as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>    
                            @endforeach
                          </select>
                          <span class="clear_form_error text-danger" id="website_error"></span>
                    </div>
                    
                  
                    <button type="button" id="create_post_btn" class="btn btn-success m-2">Create</button>
                  </form>
            </div>
            {{-- table div --}}
            <div class="col-md-7">
    
            </div>
        </div>
    
       </div>

       <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
       <script>
        $(document).ready(function(){
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        }); //ajax setup

        $('#create_post_btn').click(function() {
        document.getElementById("create_post_btn").disabled = true; //disable button after click it
        $('.clear_form_error').html('');

        var create_post = $('#create_post_form')[0];
        var create_post_ajax = new FormData(create_post); // get form data

        // ajax post start 
        $.ajax({
            url: "{{ route('post.create') }}",
            method: "POST",
            processData: false,
            contentType: false,
            data: create_post_ajax,
            success: function(response) {
                document.getElementById("create_post_btn").disabled =
                    false; //enable button 
            
                    if (response.code == 200) {
                    Swal.fire({
                        title: 'Success!',
                        icon: 'success',
                        text: response.msg,
                        confirmButtonText: 'OK'
                    })
                    }else if(response.code == 500){
                    Swal.fire({
                        title: 'Error!',
                        text: response.msg,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }) //display error msg
                    } 

                $('.clear_input').val(''); //clear input values
                $('.clear_form_error').html(''); // clear validations
            

            },

            error: function(error) {
                
                $('#title_error').html(error.responseJSON.errors.title);
                $('#desc_error').html(error.responseJSON.errors.desc);
                $('#website_error').html(error.responseJSON.errors.website);

                document.getElementById("create_post_btn").disabled =
                    false; //enable button 
            }
        });
    });

        });
       </script>

</body>
</html>

