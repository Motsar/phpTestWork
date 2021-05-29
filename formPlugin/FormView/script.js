//Variables

const selectTown = document.getElementById("selectTown");
const selectDateTime = document.getElementById("selectDateTime");
const registerToEvent = document.getElementById("registerToEvent");
const feedbackSpan = document.querySelector('.serverFeedback');
let regName = document.getElementById("regName");
let regEmail = document.getElementById("regEmail");
let comment = document.getElementById("comment");
const emailRegEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
const nameRegEx = /^[a-zA-Z\s]*$/;
const onlySpacesRegEx = /^\s+$/;

//Event listener for selecting city, and changing data

selectTown.addEventListener("click",async () => {
    restValidationFeedback(selectTown);
    resetOptions(selectDateTime);
    let url = "https://api.openweathermap.org/data/2.5/forecast?q="+selectTown.value+"&appid=c801d60da1db2ca09085697341cab7d7";
    let getClearSkyDates = await getDates(url);

    //Set event time

    selectDateTime.disabled = false;
    eventTimesDisable(selectDateTime,getClearSkyDates)

    //Set first visible event time option value as default value

    setSelectDateTime(selectDateTime)
})

//Event handler for submitting form data

registerToEvent.addEventListener("submit",async (e) => {
    e.preventDefault();

    //Reset invalid feedback

    restValidationFeedback(regName);
    restValidationFeedback(regEmail);
    restValidationFeedback(selectTown);

    //Name field validation

    if(regName.value.length===0) return changeToInvalid(regName,"Please insert a name!*");
    if(checkText(regName.value,onlySpacesRegEx)===true) return changeToInvalid(regName,"Please insert a name!*");
    if(checkText(regName.value,nameRegEx)===false) return changeToInvalid(regName,"Only letters and spaces are allowed!*");

    //Email field validation


    if(regEmail.value.length===0) return changeToInvalid(regEmail,"Please insert a email address!*");
    if(checkText(regEmail.value,emailRegEx)===false) return changeToInvalid(regEmail,"Please insert a valid email address!*");

    //Validate event time

    if(selectDateTime.disabled===true) return changeToInvalid(selectTown, "Please select a town!")
    if(selectDateTime.value===true) return changeToInvalid(selectTown, "Please select a town!")
    if(selectDateTime.value==="") return changeToInvalid(selectTown, "No events in location due weather conditions!")

    //Collect form data

    let data = new FormData(registerToEvent);

    //POST form data and receive feedback from backend

    let result = await postData(data);

    //display server feedback

    displayFeedback(JSON.parse(result))

    //show server feedback  fro 4 seconds and

    setTimeout(()=>{
        resetForm();
    }, 4000);

})

//Reset form

let resetForm=()=>{
    restValidationFeedback(regName);
    restValidationFeedback(regEmail);
    restValidationFeedback(selectTown);
    resetOptions(selectDateTime);
    resetFeedback();
    regName.value="";
    regEmail.value="";
    let firstTown = selectTown.querySelector("option").value;
    selectTown.value=firstTown;
    setSelectDateTime(selectDateTime);
    selectDateTime.disabled=true;
    comment.value="";
}

//Show server feedback

let displayFeedback=(x)=>{
    if(x.message!==undefined){
        feedbackSpan.classList.add("success");
        feedbackSpan.textContent = x.message;
        feedbackSpan.classList.remove("d-none");
    }else{
        feedbackSpan.classList.add("alert");
        feedbackSpan.textContent = x.error;
        feedbackSpan.classList.remove("d-none");
    }
}

//Reset server feedback

let resetFeedback=()=>{
    feedbackSpan.classList.remove("success");
    feedbackSpan.classList.remove("alert");
    feedbackSpan.textContent = "";
    feedbackSpan.classList.add("d-none");
}

//Set select DateTime first visible value

let setSelectDateTime=(x)=>{
    let visibleOptions = x.querySelector("option:not(.d-none)");
    if(visibleOptions===null){
        x.value = "";
    }else{
        let firstVisOptionVal = visibleOptions.value;
        x.value = firstVisOptionVal;
    }

}

//Invalid validation

let changeToInvalid = (x, text) => {
    let input = x;
    let parent = input.parentNode;
    let span = parent.querySelector('.error');
    input.classList.add("errorInput");
    span.textContent = text;
    span.classList.remove("d-none");
}

//Reset invalid validation

let restValidationFeedback =(x)=>{
    let input = x;
    let parent = input.parentNode;
    let span = parent.querySelector('.error');
    input.classList.remove("errorInput");
    span.textContent = "";
    span.classList.add("d-none");
}

//RegEx check

let checkText = (text, regEx) => {
    if(text.match(regEx)){
        return true;
    }else{
        return false;
    }
}

//Disable event time option where weather description is not clear sky and when event date has passed

let eventTimesDisable = (arrayX,arrayY) => {
    for(let i=0; i<arrayX.length; i++) {
        if(arrayY.includes(arrayX.options[i].value)===false || Date(arrayX.options[i].value)<=Date.now() ){
            //arrayX.options[i].disabled = true;
            arrayX.options[i].classList.add("d-none");
        }
    }
}

//Reset options

let resetOptions = (arrayX) => {
    for(let i=0; i<arrayX.length; i++) {
        //arrayX.options[i].disabled = false;
        arrayX.options[i].classList.remove("d-none");
    }
}

//Get dates and times from openweather where dateTime is on the time of observing events and weather descripion is clear sky

let getDates =async function(x){
    let response = await fetch(x);
    let json = await response.json();
    let dataArr = [];
    json.list.forEach((item, index)=>{
        let date = item.dt_txt;
        let splitDate = date.split(" ");
        let weatherDescription = item.weather[0].description;

        /*
        * Since dateTimes with weather forecast dont overlap with planned event times
        * created a switch to see if majority of event time weather is clear sky
        * atleast 2 hours of the event
        */

        switch(splitDate[1]+" "+weatherDescription) {
            case "21:00:00 clear sky":
                dataArr.push(splitDate[0]+" 20:00:00")
                break;
            case "00:00:00 clear sky":
                let date = new Date(splitDate[0])
                date.setDate(date.getDate()-1);
                let year = date.getFullYear();
                let correctedMonth = ""+ (date.getMonth()+1);
                let month = correctedMonth.length===1?"0"+correctedMonth:correctedMonth;
                let newDate = (""+date.getDate()).length===1?"0"+date.getDate():date.getDate();
                dataArr.push(year+"-"+month+"-"+newDate+" 23:00:00")
                break;
            case "03:00:00 clear sky":
                dataArr.push(splitDate[0]+" 02:00:00")
                break;
            case "06:00:00 clear sky":
                dataArr.push(splitDate[0]+" 05:00:00")
                break;
        }
    })
    return dataArr;
}

//Send and receive data

let postData = async (x)=>{
    let response = await fetch("./formPlugin/submit.php",{
        method: "POST",
        body: x
    });
    let data = await response.text();
    console.log(data)
    return data;
}