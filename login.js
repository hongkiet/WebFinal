$(document).ready(function() {

  $("#login-button").click(function(event){
    event.stopPropagation();
    if ($("#login-form").is(":visible")){
        $("#login-form").hide();
    }else{
        $("#login-form").show();
        // $("#register-form").hide();
    }
  });

  $(document).click(function(event) {
      if (!$(event.target).closest('#login-form').length) {
          $("#login-form").hide();
      }
  });

  $("#register-button").click(function(event){
      event.stopPropagation();
      if ($("#register-form").is(":visible")){
          $("#register-form").hide();
      }else{
          $("#register-form").show();
          // $("#login-form").hide();
      }
  });

  $(document).click(function(event) {
      if (!$(event.target).closest('#register-form').length) {
          $("#register-form").hide();
      }
  });

});

function loginbtn() {
  var username = $("#typeUser1").val();
  var password = $("#typePassword1").val();
  
    $.ajax({
        url: "check_login.php",
        type: "POST",
        data: { user: username, pass: password },
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status === "success") {
              var navbar = document.querySelector('.navbar');
              
              navbar.innerHTML = '';

              navbar.innerHTML = `
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
              </button>
            
              <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">


                  <li class="nav-item">
                    <a class="nav-link" href="#" style="display: flex; align-items: center;">
                      <img id="avt" src="unknownperson.png" alt="" class="rounded-circle ml-3">
                      <span class="text-white ml-3">${username}</span>
                      <span style="font-size: 1.3em; margin-left: 10px;">|</span>
                      <span class="text-white ml-3" onclick="logoutbtn()">Log out</span>
                    </a>
                  </li>

                </ul>
                <div class="search-box form-inline my-2 my-lg-0">
                    <!-- SEARCH -->
                    <input id="search-input" value="" class="search" name="keyword" type="text" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                    <!-- <input type="text" id="search-input" name="search" placeholder="Tìm kiếm..."> -->
                    <button type="btn" class="btn" id="button-addon2">
                      <i class="bi bi-search"></i>
                    </button>
                </div>

              </div>
              `;
              $("#login-form").hide();
            } else {
              $("#error").text(result.message);
            }
        },
        error: function() {
            $("#error").text("Server has a problem. Please try again!");
        }
    });
    
}

document.getElementById("login-form").addEventListener("keydown", function(event) {
  if (event.keyCode === 13) {
    console.log("success")
    loginbtn();
  }
});

function showSuccessMessage() {
  alert("Register successfully! Email for activatation will be send!");
  window.location.href = "main.php";
}

function showForgetForm(){
    // Ẩn form đăng nhập
    console.log('success')
    document.getElementById("login-form").style.display = "none";
    // Hiển thị form quên mật khẩu
    document.getElementById("forget-form").style.display = "block";
}
