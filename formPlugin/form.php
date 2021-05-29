<?php

class Form
{
    private $form;

    //Form constructor

    public function __construct(array $towns, $startDate, $eventDays, $eventsPerDate, $eventLengthHours)
    {
        date_default_timezone_set('Europe/Tallinn');

        //Generate location options for form

        $townOptions = "";
        foreach ($towns as $town) {
            $townOptions .= "<option value='" . $town . "'>" . $town . "</option>";
        }

        //Set first event date

        $dateTimeOptions = "";
        $currentDate = date($startDate);
        $currentDateTime = date('Y-m-d H:i:s', strtotime($currentDate . "20:00"));

        //Generate event time options for form

        for ($i = 0; $i < $eventDays; $i++) {
            $addLength = 0;
            $date = date('Y-m-d H:i:s', strtotime($currentDateTime . ' +' . $i . 'days'));
            for ($e = 0; $e < $eventsPerDate; $e++) {
                $eventDateTime = date('Y-m-d H:i:s', strtotime($date . " + " . $addLength . " hours"));
                $dateTimeOptions .= "<option value='" . date('Y-m-d H:i:s', strtotime($eventDateTime)) . "'>" . date('d.m.Y H:i', strtotime($eventDateTime)) . "</option>";
                $addLength += $eventLengthHours;
            }
        }

        //Create form

        $this->form = "
    
    <form id='registerToEvent' method='post' name='registerToEvent'>
        <div class='row'>
            <span class='serverFeedback d-none'></span>
        </div>
        <div class='row'>
            <div>
                <label for='regName'>Name: </label>
                <input type='text' id='regName' class='regName' name='regName' maxlength='50'><br>
                <span class='error regNameError d-none'></span>
            </div>
            <div>
                <label for='regEmail'>Email: </label>
                <input type='text' id='regEmail' class='regEmail' name='regEmail' maxlength='200'><br>
                <span class='error emailError d-none'></span>
            </div>
        </div>
        <div class='row'>
            <div>
                <label for='selectTown'>Select town: </label>
                <select name='selectTown' id='selectTown'>
                    " . $townOptions . "
                </select><br>
                <span class='error selectTownError d-none'></span>
            </div>
            <div>
                <label for='selectDateTime'>Select event: </label>
                <select name='selectDateTime' id='selectDateTime' disabled>
                    " . $dateTimeOptions . "
                </select><br>
                <span class='error selectDateTimeError d-none'></span>
            </div>
        </div>
        <div class='row'>
            <div>
            <label for='comment'>Add a comment: </label><br>
            <textarea id='comment' name='comment' maxlength='200'></textarea><br>
            </div>
        </div>
        <div class='row'>
            <div>
                <button type='submit' name='register'>REGISTER</button>   
            </div>
        </div>
        
    <form>
 
    ";
    }

    //Build form

    public function getForm()
    {
        return $this->form;
    }
}
