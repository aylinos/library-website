<?php
require "models/Activity.php";

if (isset($_POST['btnAddActivity'])) {
  addNewActivity();
}

function addNewActivity()
{
  $activity = new Activity();
    $activityData['aName'] = trim($_POST['actName']);
    $activityData['aDescr'] = trim($_POST['actDescr']);
    $activityData['aPlace'] = trim($_POST['actPlace']);
    $activityData['aDate'] = trim($_POST['actDate']);
    $activityData['aEmail'] = trim($_POST['actEmail']);
  $activity->addActivity($activityData);
}

function getActivities()
{
  $activity = new Activity();
  $activities = $activity->getUpcommingActivities();
  return $activities;
}

 ?>
