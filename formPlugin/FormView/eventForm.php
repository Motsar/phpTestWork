<?php
include('./formPlugin/form.php');
include('./formPlugin/config.php');

//Create a new instance of form class

$form = new Form($towns, $startDate, $eventDays, $eventsPerDate, $eventLengthHours);

//Echo the instance of generated form

echo $form->getForm();

//Javascript file included

echo "<script>";
include("script.js");
echo "</script>";

//Css file included

echo "<style>";
include("style.css");
echo "</style>";

