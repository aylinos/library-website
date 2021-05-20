$(document).ready(function(){
$("#openModal").click(function() {
  $("#LogInModal").css("display", "block");
});
$(".closemodal").click(function() {
  $("#LogInModal").css("display", "none");
});
});


function openBookForm() {
  //$("bookForm").show();
  document.getElementById("bookForm").style.display = "block";
  document.getElementById("addAct").style.display = "none";
  document.getElementById("editBook").style.display = "none";
  document.getElementById("statistics").style.display = "none";
}

function closeBookForm() {
  //$("bookForm").hide();
  document.getElementById("bookForm").style.display = "none";
  document.getElementById("addAct").style.display = "block";
  document.getElementById("editBook").style.display = "block";
  document.getElementById("statistics").style.display = "block";
}

function openEditForm() {
  document.getElementById("editBookForm").style.display = "block";
  document.getElementById("addAct").style.display = "none";
  document.getElementById("addBook").style.display = "none";
  document.getElementById("statistics").style.display = "none";
}

function closeEditForm() {
  document.getElementById("editBookForm").style.display = "none";
  document.getElementById("addAct").style.display = "block";
  document.getElementById("addBook").style.display = "block";
  document.getElementById("statistics").style.display = "block";
  $("#resultBook").css("display", "none");
  $("#editBookFrm").css("display", "none");
}

function openActivityForm() {
  document.getElementById("activityForm").style.display = "block";
  document.getElementById("addBook").style.display = "none";
  document.getElementById("editBook").style.display = "none";
  document.getElementById("statistics").style.display = "none";
}

function closeActivityForm() {
  document.getElementById("activityForm").style.display = "none";
  document.getElementById("addBook").style.display = "block";
  document.getElementById("editBook").style.display = "block";
  document.getElementById("statistics").style.display = "block";
}

function openStatistics() {
  document.getElementById("stats").style.display = "block";
  document.getElementById("addBook").style.display = "none";
  document.getElementById("addAct").style.display = "none";
  document.getElementById("editBook").style.display = "none";
}

function closeStatistics() {
  document.getElementById("stats").style.display = "none";
  document.getElementById("addBook").style.display = "block";
  document.getElementById("addAct").style.display = "block";
  document.getElementById("editBook").style.display = "block";
}

function validateActivityForm() {
  var name = document.forms["activityForm"]["actName"].value;
  var descr = document.forms["activityForm"]["actDescr"].value;
  var place = document.forms["activityForm"]["actPlace"].value;
  var date = document.forms["activityForm"]["actDate"].value;
  var email = document.forms["activityForm"]["actEmail"].value;
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (name == "") {
    alert("Name must be filled out");
    return false;
  } else if (descr == "") {
    alert("Description must be added");
    return false;
  } else if (place == "") {
    alert("PLace must be added");
    return false;
  } else if (date == "") {
    alert("Date must be added");
    return false;
  } else if (email == "") {
    alert("Email must be added");
    return false;
  } else if (!email.match(mailformat)) {
    alert("Email must be in correct format.");
    return false;
  } else {
    alert("Activity was added.");
    return true;
  }
}

function validateBookForm() {
  var name = $("[name='bookName']");
  var author = $("[name='bookAuthor']");
  var publish_date = $("[name='bookPublishDate']");
  var genre = $("[name='genresInput']");
  var pages = $("[name='bookNumberOfPages']");
  var image = $("[name='image']");
  var resume = $("[name='bookResume']");

  if (name == "") {
    alert("Name must be filled out");
    return false;
  } else if (author == "") {
    alert("Author must be added");
    return false;
  } else if (publish_date == "") {
    alert("Date must be added");
    return false;
  } else if (genre == "") {
    alert("Genre must be added");
    return false;
  } else if (pages == "") {
    alert("Number of pages must be added");
    return false;
  } else if (resume == "") {
    alert("Short resume must be added");
    return false;
  } else {
    alert("Book added successfully.")
    return true;
  }
}

function DeleteBook(id) {
  $.ajax({
    type: "POST",
    url: "/Controllers/BookController.php",
    data: {
      deleteId: id
    },
    success: function(returnedData) {
      alert("Book was deleted");
      closeEditForm();
    }
  });
}
function EditBook(id){
// alert($("#ebookName").val());
  let book = {
    id: id,
    name: $("#ebookName").val(),
    author: $("#ebookAuthor").val(),
    date: $("#ebookPublishDate").val(),
    genre:$("#egenresInput").val(),
    pages: $("#ebookNumberOfPages").val(),
    resume: $("#ebookResume").val()
  }
  var myJSON = JSON.stringify(book);
$.ajax({
  url: "/Controllers/BookController.php",
  type: "POST",
  data: {
    editedBook: myJSON
  },
  dataType: 'json',
  success: function(result) {
    closeEditForm();
    alert("Book updated successfully");
  }
});
}

$(document).ready(function(){
  let data;
  $("#deleteSelectedBook").click(function() {
    let id = $("#foundBookId").attr('value');
    if (confirm('Are you sure you want to delete this book?')) {
      DeleteBook(id);
    } else {

    }
  })

  $("#editSelectedBook").click(function(){
    $("#resultBook").css("display", "none");
    $("#editBookFrm").css("display", "block");
  })

  $("#btnFindBook").click(function() {
    let name = $("#bookName").val();
    if (name === "") {
      alert("Please start typing a book name.")
    } else {
      $.ajax({
        type: "POST",
        url: "/Controllers/BookController.php",
        data: {
          bookName: name
        },
        dataType: 'JSON',
        success: function(returnedData) {
          $("#resultBook").css("display", "block");
          $("#foundBookId").attr("value", returnedData[0].id);
          let imagestr = "images/";
          $("#findBookImg").attr("src", imagestr.concat(returnedData[0].image));
          $("#h3Cards").text(returnedData[0].name);
          $("#findBookCaption").text(returnedData[0].author);
          //Fill edit form
          $("#ebookName").attr("value", returnedData[0].name);
          $("#ebookAuthor").attr("value", returnedData[0].author);
          $("#ebookPublishDate").attr("value",returnedData[0].date);
          $("#egenresInput").attr("value",returnedData[0].genre);
          $("#ebookNumberOfPages").attr("value",returnedData[0].pages);
          $("#ebookResume").attr("value",returnedData[0].resume);
        }
      })
    }
  });
  // View more books search
  $("#searchbookbtn").click(function() {
    let name = $("#searchbook").val();
    if (name === "") {
      alert("Please start typing a book name.")
    } else {
      // // TODO:
      $.ajax({
        type: "POST",
        url: "/Controllers/BookController.php",
        data: {
          bookNameSearch: name
        },
        dataType: 'JSON',
        success: function(returnedData) {
          $("#searchedBook").css("display", "block");
          $("#searchBookId").attr("value", returnedData[0].id);
          $("#booklink").attr("href","BookPage.php?id=" + returnedData[0].id);
          let imagestr = "images/";
          $("#searchBookImg").attr("src", imagestr.concat(returnedData[0].image));
          $("#h3Card").text(returnedData[0].name);
          $("#searchBookCaption").text(returnedData[0].author);
        }
      })
    }
  });

  $("#confirmBookChanges").click(function(){
    let id = $("#foundBookId").attr('value');
    EditBook(id);
    closeEditForm();
    alert("Book updated successfully");
  })
});


//Get selected genres from the list in the 'Add new book' form
// var sel = document.getElementsByName('genres')[0];
// var choosen = [];
// sel.onclick = function() {
//   var is_there = !!~choosen.indexOf(this.value); //if current value is found -> index > 0 => true
//   if (is_there) {
//     return false;
//   };
//   choosen.push(this.value);
//   document.getElementsByName('genresInput')[0].value += this.value + ' ';
// }


function loadBooks(category) {
    if (category == "") {
      xmlhttp.open("GET","/Controllers/BookController.php?q=allBooks",true);

    } else {
        $("#searchedBook").css("display", "none");
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("bookList").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","/Controllers/BookController.php?q="+category,true);
        xmlhttp.send();
    }
}

let id;
let fname;
let lname;
let email;
let age;
let phone;
let address;

$(document).ready(function(){
$("#edit").click(function() {
  validateUpdateProfile();
});
});

function validateUpdateProfile() {
  id = $("#editTable").attr("name");
  fname = $("#pr-first-name").val();
  lname = $("#pr-last-name").val();
  email = $("#pr-email").val();
  age = $("#pr-age").val();
  phone = $("#pr-phone").val();
  address = $("#pr-address").val();

  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  var numberformat = /^[0-9]+$/;
  if (fname == "" || lname == "") {
    alert("Name must be filled out");
    return false;
  } else if (email == "") {
    alert("Email must be added");
    return false;
  } else if (!email.match(mailformat)) {
    alert("Email must be in correct format.");
    return false;
  } else if (!age.match(numberformat) && age != "") {
    alert("Age must contain only digits.");
    return false;
  } else if (!phone.match(numberformat) && phone != "") {
    alert("Phone number must contain only digits.");
    return false;
  } else {
    if (confirm('Are you sure you want to update your profile?')) {
      updateUser();
    } else {
      // Do nothing!
    }
  }
}

function updateUser() {
  let user = {
    id: id,
    first_name: fname,
    last_name: lname,
    email: email,
    age: age,
    phone: phone,
    address: address
  };

  var myJSON = JSON.stringify(user);
  $.ajax({
    url: "/Controllers/UserController.php",
    type: "POST",
    data: {
      user: myJSON
    },
    success: function(data) {
      $("#userName").text(fname + " " + lname);
    }
  });
}
$(document).ready(function(){
$("#filebuttonid").click(function() {
  $("#fileid")[0].click();
});
});

//function updatePhoto() {
//   let id = $("#editTable").attr("name");
//   let pic = $("#fileid").prop('files')[0];
//   // let pic = $("#fileid").val();
//
//   var data = new FormData();
//     data.append('id', id);
//     data.append('pic', pic);
//
//     $.ajax({
//         url: 'Controllers/UserController.php',
//         data: data,
//         type: "POST",
//         contentType: false,
//         cache: false,
//         processData:false,
//         success: function(data) {
//                location.reload();
//         },
//         error: function(e) {
//             alert("error while trying to add or update user!");
//         }
//     });
// }

$(document).ready(function(){
$(function() {
     $("input:file").change(function (){
       $("#savepic").css("display", "initial");
     });
});
});

function parseDate(dateStr){
  if(isNaN(dateStr)){ //Checked for numeric
    var dt=new Date(dateStr);
    if(isNaN(dt.getTime())){ //Checked for date
      return dateStr; //Return string if not date.
    }else{
      return dt; //Return date **Can do further operations here.
    }
  } else{
    return dateStr; //Return string as it is number
  }
}

function Reserve(bid) {
  var pd = document.getElementById('pd').value;
  var rd = document.getElementById('rd').value;

  var date_regex =  /^(0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).[0-9]{4}$/;
  if(!(date_regex.test(pd))  || !(date_regex.test(rd)))
  {
    alert("Date is in incorrect format!");
    return false;
  }

  // else if(pd < today || rd < today)
  // {
  //   alert("Cannot reserve for past days!");
  //   return false;
  // }

  else
  {
    var xhttp = new XMLHttpRequest();
    var data = "pd="+pd + "&rd="+rd + "&bid=" + bid;

    xhttp.open("POST", "/Controllers/BookController.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);

    xhttp.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status == 200) {
        alert(this.responseText);
        if(this.responseText === "Log in or sign up to reserve a book!")
        {
          location.replace("/logInPage.php");
        }
        else if(this.responseText === "Successful reservation!")
        {
          ChangeAvailabilityImage(bid);
        }
      }
    };

    return true;
  }
}

function ChangeAvailabilityImage(bid)
{
  var xhr = new XMLHttpRequest();
  var data = "btnReserve=true&bid="+bid;

  xhr.open("POST", "/Controllers/BookController.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(data);

  xhr.onreadystatechange = function () {
    if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
      document.getElementById('valueAvailable').innerHTML = this.responseText;
      ChangeAvailabilityText(bid);
    }
  };
}

function ChangeAvailabilityText(bid)
{
  var xhr = new XMLHttpRequest();
  var data = "availabilityText=true&bid="+bid;

  xhr.open("POST", "/Controllers/BookController.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(data);

  xhr.onreadystatechange = function () {
    if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
      document.getElementById('availabilityText').innerHTML = this.responseText;
    }
  };
}


//Statistics:

$(document).ready(function () {
  RolePieGraph();
  MostReservedBooksHorizontalBarGraph();
  UsersAgePolarAreaGraph();
});


function RolePieGraph()
{
  var compareRole = JSON.stringify('true');
  $.ajax({
    url: "/Controllers/StatisticsController.php",
    type: "POST",
    data: {compareRole: compareRole},
    success: function(statistics) {
      var result = JSON.parse(statistics);
        var adminsReaders = [];
        for (var index in result)
        {
          adminsReaders.push(result[index]);
        }

        var chartdata = {
            labels: ['Administrators', 'Readers'],
            datasets:
                [{
                    backgroundColor: ['#49e2ff', '#cbf0f7'],
                    borderColor: ['#46d5f1', '#c2e6ed'],
                    hoverBackgroundColor: ['#2bdcff', '#b6effa'],
                    hoverBorderColor: ['#3299ad', '#3299ad'],
                    data: adminsReaders
                }]
        };

        var graphTarget = $("#rolePie");
        Chart.defaults.global.defaultFontSize = 16;
        var rolePieChart = new Chart(graphTarget, {
            type: 'pie',
            data: chartdata,
            options: {
              title: {
                display: true,
                text: 'Administrators vs Readers',
                fontSize: 25,
                fontColor: '#65baa9',
                position: 'left'
              }
            }
        });
    }
  });
}

function MostReservedBooksHorizontalBarGraph()
{
  var mostReserved = JSON.stringify('true');
  $.ajax({
    url: "/Controllers/StatisticsController.php",
    type: "POST",
    data: {mostReserved: mostReserved},
    success: function(statistics) {
      var result = JSON.parse(statistics);
        var name = [];
        var timesReserved = [];
        for (var index in result)
        {
          name.push(result[index].name);
          timesReserved.push(result[index].timesReserved);
        }

        var chartdata = {
            labels: name,
            datasets:
                [{
                    backgroundColor: ['#3dffb8', '#62f576', '#2dc241', '#5dcf6c', '#c0fac8'],
                    hoverBackgroundColor: ['#21fcac', '#58fc6f', '#29cf3f', '#5ee06f', '#a8edb2'],
                    data: timesReserved
                }]
        };

        var graphTarget = $("#mostReservedHorizontalBar");
        Chart.defaults.global.defaultFontSize = 16;
        var rolePieChart = new Chart(graphTarget, {
            type: 'horizontalBar',
            data: chartdata,
            options: {
              title: {
                display: true,
                text: 'Top 5 Most Reserved Books',
                fontSize: 25,
                fontColor: '#65baa9',
                position: 'right'
              },
              scales: {
                xAxes: [{
                  ticks: {
                    min: 1,
                    callback: function(value) {if (value % 1 === 0) {return value;}}
                  }
                }]
              },
              legend: {
                display: false
              }
            }
        });
    }
  });
}

function UsersAgePolarAreaGraph()
{
  var maxNr = 0;
  var usersAge = JSON.stringify('true');
  $.ajax({
    url: "/Controllers/StatisticsController.php",
    type: "POST",
    data: {usersAge: usersAge},
    success: function(statistics) {
      var result = JSON.parse(statistics);
        var ages = [];
        var nrUsers = [];
        for (var index in result)
        {
          ages.push(result[index].age);
          nrUsers.push(result[index].nrUsers);
        }
        maxNr = Math.max.apply(Math, nrUsers);
        var chartdata = {
            labels: ages,
            datasets:
                [{
                    backgroundColor: ["#e4f567", "#67f578", "#67f5e4", "#f567d4", "#f56767", "#67a5f5", "#7506bf"],
                    data: nrUsers
                }]
        };

        var graphTarget = $("#usersAgePolarArea");
        Chart.defaults.global.defaultFontSize = 16;
        Chart.defaults.polarArea.animation.animateScale = false;
        var agesPolarAreaChart = new Chart(graphTarget, {
            type: 'polarArea',
            data: chartdata,
            options: {
              title: {
                display: true,
                text: 'Users age',
                fontSize: 25,
                fontColor: '#65baa9',
                position: 'top',
              },
              legend: {
                position:'top',
              },
              labels: {
                padding: 20
              },
              scale: {
                  ticks: {
                    min: 0,
                    max: maxNr + 1
                  }
              }
            }
        });
    }
  });
}
