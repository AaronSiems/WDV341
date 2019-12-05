//This will check for the proper convention for an ISBN and return the
//suggested last number so checkISBN() will return a proper number to the
//error message.
function lastNumFunc(v) {
    var sum = 0;
    for(var i = 0; i < 12; i++) {
        if(i % 2 == 1) {
            sum += (3 * parseInt(v.substr(i, 1)));
        } else {
            sum += parseInt(v.substr(i, 1));
        }
    }
    var r = (sum + parseInt(v.substr(12, 1))) % 10;
    if(r == 0) {
        return -1; //A 0 remainder for sum is possible so a valid answer had to return a -1 since that is not possible from the %
    } else {
        return ((sum % 10));
    }
}

//Checks for a proper ISBN every keystroke in the isbn text box
function checkISBN() {
    var isbn = document.getElementById("isbnText").value;
    var msg = "";
    if (isbn.length == 13) {
        var lastNum = lastNumFunc(isbn);
    }
    
    if(!isbn) {
        msg = "Please enter an isbn.";
    } else if (isbn.length != 13) {
        msg = "ISBN must be 13 digits long."
    } else if (isNaN(isbn)) {
        msg = "ISBN must be a number and contain no special characters.";
    } else if (lastNum != -1) { //explained in lastNumFunc() why -1 and not 0 is the OK number
        msg = "ISBN is not valid, did you mean " + isbn.substr(0, 12) + (10-lastNum) + "?";
    }
    
    document.getElementById("isbnError").innerHTML = msg;
    if(msg.length == 0) {
        document.getElementById("submit").disabled = false;
    } else {
        document.getElementById("submit").disabled = true;
    }
}

//Only checks for name and author are not larger than the table length values AND not empty.
function checkName() {
    var name = document.getElementById("bookNameText").value;
    var msg = "";
    
    if (name.length > 50) {
        msg = "Book title is too long";
    } else if (name.length == 0) {
        msg = "You must enter a book title.";
    }
        
    document.getElementById("nameError").innerHTML = msg;
    if(msg.length == 0) {
        document.getElementById("submit").disabled = false;
    } else {
        document.getElementById("submit").disabled = true;
    }
}

function checkAuthor() {
    var author = document.getElementById("authorText").value;
    var msg = "";
    
    if (author.length > 25) {
        msg = "Author title is too long";
    } else if (author.length == 0) {
        msg = "You must enter an author.";
    }
    
    document.getElementById("authorError").innerHTML = msg;
    if(msg.length == 0) {
        document.getElementById("submit").disabled = false;
    } else {
        document.getElementById("submit").disabled = true;
    }
}
