<?php
  session_start();
  require_once('database.php');
  $musics = get_music();
  if(isset($_POST['keyword'])) { 
    if($_POST['keyword'] == "") {
    } else {
      $musics = get_search_music($_POST['keyword']);
    }
  }
    
    $error = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="content.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="test.css">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="suggestion.css">
    <link rel="stylesheet" href="login_function.css">
    
    <title>Music Website</title>
    <style>
      .search-box {
        border: none;
        background: #fff;
        border-radius: 30px;
      }
      .search-box .search {
        border: none;
        outline: none;
        background: none;
        color: black;
        font-size: 18px;
        font-weight: 400;
        width: 0;
        padding: 0;
        transition: 0.3s ease 0.5s;
      }
      .search-box:hover .search, .search-box .search:valid {
        width: 250px;
        padding: 10px 0px 10px 15px;
        transition: 0.2s ease 0.3s;
      }
      .search-box .btn {
        border: none;
        color:black;
        border-radius: 30px;
      }
      .search-box .btn i {
        color: black;
        font-size: 20px;
        font-weight: 600;
      }
      #avt{
        max-width: 50px;
      }
</style>
</head>
<body>
  <div class="container-fluid">
    <div class="row order-first">
      <!-- header -->
      <div class="col-lg-2 col-md-2 col-sm-2 header1" >
      
        <div class="fixed-header">
          <div class="image-container">
            <img class="logoakk rounded-circle" src="AKK.png" alt="" >
            
          </div>
          <p style="font-weight: bolder;margin-top: 10px;font-size: larger; text-align: center; ">Welcome to AKK Music!</p>
          <div id="header-function">
            <a href="main.php" class="home-button btn-header" style="display: block;"><i class="bi bi-house-door-fill" style="margin-right: 10px;"></i>Home</a>
            <a href="#" class="library-button btn-header" style="display: block;"><i class="bi bi-music-note-list" style="margin-right: 10px;"></i>Your Library</a>
            <a href="#" class="library-button btn-header" style="display: block;"><i class="bi bi-journal-plus" style="margin-right: 10px;"></i>Create Library</a>
          </div>
        </div> 
      </div>
      <!-- header -->
      <!-- content -->
      <div class="col-lg-10 col-md-10 col-sm-10 content">
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-light ">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">


              <li class="nav-item">
                <a class="nav-link" href="#" id="register-button">Sign up</a>
              </li>
              <li class="nav-item">
                <a style="font-size: 1.3em;" class="nav-link" href="#">|</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" id="login-button">Sign in</a>
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
          
        </nav>
        <!-- navbar -->
        
        <!-- HTML code -->
        <!-- LYRICS -->
        

<!-- Sử dụng biểu -->

        <!-- focus -->
        <div>
              <div id="lyrics-container" style="display: none;">
                <div id="lyrics">

                </div>
              </div>
              <div id="finding-result"></div>
              <div id="search-results"></div>
              <div id="line"></div>
              <?php
              if(count($musics) > 0) {
                  foreach($musics as $m) {
              ?>
                  <div style="z-index: 0;" class="focus baihat on-screen" data-id="<?=$m['id']?>" data-title="<?=$m['name']?>" data-file="<?=$m['file']?>" 
                  data-image="<?=$m['image']?>" data-actor="<?=$m['actor']?>" data-lyric="<?=$m['lyric']?>">
                      <div class="card-wrapper">
                        <div class="card">
                          <a>
                            <img class="card-img-top" src="<?=$m['image']?>" alt="Card image">
                            <i class="play-icon bi bi-play-circle-fill"></i>
                          </a> 
                          <div class="card-body">
                            <h4 style="font-size: 1.2em; font-weight: 600;" class="card-title"><?=$m['name']?></h4>
                            <p class="card-text"><?=$m['actor']?></p>
                          </div>
                        </div>  
                      </div>
                  </div>
              <?php
                  }
                } else {
                  ?>
                    <p class="No-result">There is no result</p>
                  <?php
                }
              ?>
            </div>
      </div>

    </div>



    <div class="row">
        <div class="music">
            <div class="col-lg-3 col-md-2 d-none d-md-block tieude">
              <div class="music-thumb">
                <div class="anhbaihat">
                  <img class="img" src="bg1.jpg" alt="">
                </div>
                <div class="singer-song">
                  <h3 class="music-name">Suzune</h3>
                  <h4 class="actor">Suzune</h4>
                </div>
              </div>
            </div>
            
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
              <div class="controls">
                <!-- SHUFFLE -->
                <i name="bi-shuffle" class="bi bi-shuffle play-shuffle"></i>
                <!-- BACK -->
                <i class="bi bi-skip-backward-fill play-back"></i>
                <!-- PLAY -->
                <div class="play">
                    <div class="play-inner">
                        <i name="play" class="bi bi-play-circle-fill"></i>
                    </div>
                </div>
                <!-- NEXT -->
                <i class="bi bi-skip-forward-fill play-forward"></i>
                <!-- REPEAT -->
                <div class="repeat-icon">
                  <i class="repeat bi bi-repeat"></i>
                </div>
              </div>
              
  
                  <audio class="song" id="player" preload="metadata" delay="1"></audio>
  
                <div class="timer">
                  <div class="remaining">00:00</div>
                    <div class="progress-bar">
                      <div class="custom-progress-done"></div>
                    </div>
                  <div class="duration">00:00</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-2 col-sm-0 volume">
                  <div  class="lyric-icon" title="Lời bài hát">
                    <i class="lyric-i bi bi-music-note-list"></i>
                  </div>
                  <div class="volume-icon">
                      <i class="volume-i bi bi-volume-up"></i>
                  </div>
                  <div class="vol-bar">
                    <div class="vol-bar-done"></div>
                  </div>
            </div>
          </div>  
      </div>

  </div>
  <!-- login form -->
  <form onkeydown="if (event.keyCode === 13) {loginbtn(); return false;}">
    <div class="container py-0 h-100" style="margin-bottom: 0px;">
      <div class="row d-flex justify-content-center align-items-center" id="login-form-container" style="margin-bottom: 0px;">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5" style="margin-bottom: 0px;">
          <div class="card bg-dark text-white login-card" id="login-form" style="border-radius: 1rem;">
            <div class="card-body p-5 login-card-body  text-center" style="margin-bottom: 0px;">
  
              <!-- <div class="mb-md-5 mt-md-4 pb-5"> -->
                
                <h2 class="fw-bold mb-3 text-uppercase">Sign in</h2>
  
                <div class="form-outline form-white mb-4 text-left">
                  <label class="form-label " for="typeUser" >User:</label>
                  <input name="user" type="user" id="typeUser1" class="form-control form-control-lg" />
                </div>
  
                <div class="form-outline form-white mb-4 text-left">
                  <label class="form-label" for="typePassword">Password:</label>
                  <input name="pass" type="password" id="typePassword1" class="form-control form-control-lg" />
                </div>
  
                <p onclick="showForgetForm()" class="small pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>
                <p class="mb-4 "><a class="text-danger" id="error" href="#!"><?= $error ?></a></p>
                <button class="btn btn-outline-light btn-lg px-5" type="button" onclick="loginbtn()">Login</button>

  
              </div>  
            </div>
          </div>
        </div>
      <!-- </div> -->
    </div>
  </form>
  <!-- login form -->
  <!-- signup form -->
  <form action="register_account.php" method="post" onsubmit="showSuccessMessage()">
    <div class="container py-0 h-100" style="margin-bottom: 0px;">
      <div class="row d-flex justify-content-center align-items-center" id="login-form-container" style="margin-bottom: 0px;">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5" style="margin-bottom: 0px;">
          <div class="card bg-dark text-white register-card" id="register-form" style="border-radius: 1rem;">
            <div class="card-body p-5 register-card-body text-center" style="margin-bottom: 0px;">
              <h2 class="fw-bold mb-3 text-uppercase">Sign up</h2>
              <div class="form-outline form-white mb-4 text-left">
                <label class="form-label" for="typeName">Name:</label>
                <input type="text" id="typeName" name="name" class="form-control form-control-lg" required>
              </div>
              <div class="form-outline form-white mb-4 text-left">
                <label class="form-label" for="typeEmail">Email:</label>
                <input type="email" id="typeEmail" name="email" class="form-control form-control-lg" required>
              </div>
              <div class="form-outline form-white mb-4 text-left">
                <label class="form-label" for="typeUser">User:</label>
                <input type="text" id="typeUser" name="user" class="form-control form-control-lg" required>
              </div>
              <div class="form-outline form-white mb-4 text-left">
                <label class="form-label" for="typePassword">Password:</label>
                <input type="password" id="typePassword" name="pass" class="form-control form-control-lg" required>
              </div>
              <div class="form-outline form-white mb-4 text-left">
                <label class="form-label" for="typePassword">Confirm password:</label>
                <input type="password" id="typePassword" name="pass-confirm" class="form-control form-control-lg" required>
              </div>
              <button class="btn btn-outline-light btn-lg mt-4 px-5" type="submit">Sign up</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- signup form -->
  <!-- forget form -->
  <form >
    <div class="container py-0 h-100" style="margin-bottom: 0px;">
      <div class="row d-flex justify-content-center align-items-center" id="forget-form-container" style="margin-bottom: 0px;">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5" style="margin-bottom: 0px;">
          <div class="card bg-dark text-white forget-card" id="forget-form" style="border-radius: 1rem;">
            <div class="card-body p-5 forget-card-body  text-center" style="margin-bottom: 0px;">
  
              <!-- <div class="mb-md-5 mt-md-4 pb-5"> -->
                
                <h2 class="fw-bold mb-3 text-uppercase">Forget password</h2>
  
              <div class="form-outline form-white mb-4 text-left">
                <label class="form-label" for="typeEmail">Email:</label>
                <input type="email" id="typeEmail" name="email" class="form-control form-control-lg" required>
              </div>
  
                <p class="mb-4 "><a class="text-danger" id="error" href="#!"><?= $error ?></a></p>


  
              </div>  
            </div>
          </div>
        </div>
      <!-- </div> -->
    </div>
  </form>
  <!-- forget form -->



  <script src="SearchHint.js"></script> 
  <script src="lyric.js"></script>
  <script src="login.js"></script>
</body>
</html>