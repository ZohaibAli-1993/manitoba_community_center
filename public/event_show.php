<?php
//title and page variables
$title = 'Manitoba Community Center';
$page = 'Events Profile';
//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';

// envent id  recieve through from previous form
$event_id = $_GET['id'];
// get dbh connect (include connect)
// create query
$query = 'SELECT  
          *  
          FROM  
          event
          WHERE
          event_id= :event_id';
// create your param array
$params = [
    ':event_id' => $event_id
];
// prepare query
$stmt = $dbh->prepare($query);
// execute query with params
$stmt->execute($params);
// fetch your result
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$rating=explode(" ", e_attr($result['rating']));
// Session id
$_SESSION['event_id']=$event_id;

//include directory
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php';

?>  
<main>    
    <?php require '../inc/flash.inc.php';?> 

  <!--show customize image on report -->
  <div class="container emp-profile">
    <form method="post" action="login.php">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    <img src="/images/<?=e_attr($result['image'])?>" alt="" />
                </div>
            </div>

            <!--details on  report -->
            <div class="col-md-6">
                <div class="profile-head">
                    <h2>
          Events Details
      </h2>
                    <h3>
            <?=$result['type_of_event']?>
      </h3>
                    <p class="proile-rating">RANKINGS :
                        <span>
            <?=$rating[0]?>
        </span>
                    </p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Info
            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-2">
                <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
                <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Registration" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="profile-work">
                    <h3>Description
            </h3>
                    <p>
                        <?=e_attr($result['description'])?>
                    </p>
                </div>
            </div>

            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Event Id</label>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <?=e_attr($result['event_id'])?>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label> Event Name
                                </label>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <?=e_attr($result['event_name'])?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Event time</label>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <?=e_attr($result['event_time'])?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Created at
                                </label>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <?=e_attr($result['created_at'])?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Updated at
                                </label>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <?=e_attr($result['updated_at'])?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>

</div> 

</main> 
<!--php include footer -->
<?php include __DIR__ . '/../inc/footer.inc.php'; ?>  
