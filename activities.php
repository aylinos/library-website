<?php
  include 'config/session_init.php';
  require "Controllers/ActivityController.php";
  $activities = getActivities();
  $num_activities = count($activities);

  $pageName = "Activities";
  require "includes/head.php";
?>

<body class="activity">
  <div class="activities">
    <div class="grid-nav-activities">

    <?php require "includes/Navigation.php"; ?>

    </div>
    <div class="activity-header">
      <h1 class="activity">Upcoming activities</h1>
    </div>

    <div class="activity-image"></div>
    <div class="activity-item">
      <?php if($num_activities > 0)
{ foreach ($activities as $key => $activity) {?>
  <?php $color = ($key % 2 === 0) ? '#f6fcf0' : '#fcf3f0';
    echo '<div class="activity-item1" style="background: '.$color.';">'; ?>
      <div class="eventHandler">
        <div class="date">
          <h2 class="activity"><?php echo $activity->name; ?></h2>
          <h5 class="activity">If you have further questions about the gathering please contact us on email: <?php echo $activity->email; ?></h5>
        </div>

        <div class="holder-activity" id="colorScheme">
          <div class="it1"></div>
          <div class="it2">Date: <?php echo $activity->date; ?> </div>
          <div class="it3">Location: <?php echo $activity->place; ?> </div>
          <div class="it4"><?php echo $activity->description; ?></div>
        </div>
      </div>
    </div>
  <?php  } } ?>

    </div>
  </div>
<?php require 'includes/footer.php'; ?>
</body>
</html>
