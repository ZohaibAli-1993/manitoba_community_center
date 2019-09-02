<?php

//title and page variables
$title = 'Manitoba Community Center';
$page = 'Registering Information';
//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php';
include __DIR__ . '/../inc/functions.php';
require __DIR__ . '/../classes/Validator.php';
  
//This condition run only when user logout from profile
if (filter_input(INPUT_GET, 'logout')) {
    //session
    session_destroy();
   //session start
    session_start();
    //flash message to dispaly its logged out succesfullly
    setFlash('success', "You've successfully logged out");
    //redirect the page
    header('Location:login.php');
    die;
}
 
$v = new Validator();

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    // validate both fields for required
    $v->required('email');
    $v->email('email');
    $v->required('password');
    
    // if no $v->errors()
    if (!$v->errors()) {
        // Extract all POST vars to new array
        $post = filter_input_array(INPUT_POST);

        // query data base for user with email
        $query = 'SELECT  
                  *  
                  FROM  
                  participant  
                  WHERE  
                  email = :email';
        //prepare the query
        $stmt = $dbh->prepare($query);
        //params for the query
        $params = array(
                  ':email' => $post['email']
        );
        //execue the query
        $stmt->execute($params);
        //fetch the record
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // prepare passwords for verification
        // form password store in respective varibales
        $form_password = $post['password'];
        $stored_password = $user['password'];
        $form_email=$post['email'];
        $stored_email=$user['email'];
       
        // verify the form password matches the stored password
        if (password_verify($form_password, $stored_password)) {
            // regenerate id
            session_regenerate_id();
            
            // set SESSION flag (perhaps user_id)
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['admin']=$user['admin'];
           
                setFlash('login', 'You have logged in!');
            if ($_SESSION['admin']==1) {
                //redirect to the page
                 header('Location: admin_home_page.php');
                 die;
            } else {
              // redirect
                header('Location: donation.php');
            }
            // die
                die;
        } else {
           // set flash about crediential problems
            setFlash('errorS', 'There was a problem with your credentials');
        }
        // end verify
    
    // end if no errors
    }
} // end POST

$errors = $v->errors();

?> 
    
       
        <?php  require '../inc/flash.inc.php';?>
      
      <main>    
      
      
    <!-- Display Information in Table-->  
            <div>
    <!--Form  -->    
          <form method="post"
                action="<?php $_SERVER['PHP_SELF'] ?>"
                autocomplete="on">
            <div id='profile'>
              
              <img src="images/profile.jpg" id="avt" alt="Avatar" class="avatar">
            </div>

            <div class="container"> 
              <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" /> 
              <p>
              <label ><b>Email</b></label>
              <input type="text" placeholder="Enter Username" name="email" required> 
                <?=(isset($errors['email'])) ? "<span class='error'>{$errors['email']}</span>" : '' ?> 
            </p> 
            <p>
              <label ><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="password" required> 
              <button type="submit">Login</button>
              <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
              </label> 
            </p>
            </div>

            <div class="container" style="background-color:#f1f1f1">
              
              <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
          </form>
        </div>
        
      </main> 
     <!--php include footer -->
<?php include __DIR__ . '/../inc/footer.inc.php'; ?>  
