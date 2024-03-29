<!--
    Login page to the admin dashboard
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- External CSS stylesheets -->
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <!-- External JavaScript libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <!-- Page title -->
    <title>Вход за редактори</title>
    
<!-- JavaScript code for login validation -->
<script>
      $(document).ready(function () {
        
        $("#login-form").submit(function(event) {
          event.preventDefault();
          var user = $('#check-user').val();
          var pass = $('#check-pass').val();
          var submit = $('#check-submit').val();
          
          var resp = new Array();

          // Use AJAX to send a POST request to 'check.php' with login data
          $.ajax ({
              type: "POST",
              url: 'check.php',
              data: {
                  login: 1,
                  user: user,
                  pass: pass
              },
              success: function(response) {
              resp = response;	
              document.getElementById("errorUser").innerHTML = "";
              document.getElementById("errorPass").innerHTML = "";
              $(" #check-user , #check-pass").removeClass("input-error");
              
              if( resp['user'] || resp['pass'] )
              { 
                // Check if there are errors in the user or password input
                if( resp['user'] == '1' ) 
                {
                  // Display an error message for username input
                  document.getElementById("errorUser").innerHTML = "Въведете потребителско име";
                  $(" #check-user ").addClass("input-error");
                }
                
                if( resp['pass'] == '1' ) 
                {
                  // Display an error message for password input
                  document.getElementById("errorPass").innerHTML = "Въведете парола";
                  $(" #check-pass ").addClass("input-error");
                }

              } else if ( resp['err'] ) 
              {
                // Display a general error message for incorrect login details
                console.log(11); 
                document.getElementById("form-message").innerHTML = "Грешно потребителско име или парола"
              }
              else 
              {
                // Redirect to 'event-edit.php' upon successful login
                window.location.href="event-edit.php";
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            // Log error to console
            console.log(textStatus); 
            console.log(errorThrown);

            // Check if request completed 
            if (jqXHR.status == 0) {
              alert('Connection refused or request aborted');
            } else {
              alert('AJAX request failed with status ' + jqXHR.status + ': ' + errorThrown); 
            }
            },
            dataType:"json"
        });
       });
      });
</script>

</head>

<!--  HTML to display login form -->
<body>
<section class="vh-100" style="background-color: #D0C0FF;background-image: linear-gradient(240deg, #D0C0FF 0%, #ebfffe 100%);">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-4">Вход за редактори</h3>

            <form id="login-form" method="post" >

                <div class="form-outline mb-4">
                  <input id="check-user" type="text" placeholder="Потребителско име" name="username" class="form-control form-control-lg"><span id="errorUser">  </span>
                </div>

                <div class="form-outline mb-4">
                  <input id="check-pass" type="password" placeholder="Парола"  name="password" class="form-control form-control-lg"> <span id="errorPass">  </span>  
                </div>

                <p id="form-message"></p>
                <input id="check-submit" class="btn btn-primary btn-lg btn-block" style="background-color:rgb(42, 31, 121); border:none;"type="submit" name="submit" value="Вход">
      
            </form>           
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>




