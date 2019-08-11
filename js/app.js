const form = document.querySelector('.form');
var changeFromInput = document.querySelector('#changeFrom');
var changeToInput = document.querySelector('#changeTo');
var changeCurrencyBox = document.querySelector('.allChangeTo');
var changeToArray = [];
var validChange = false;
var table = document.querySelector('.table');
var list = document.getElementById("list");
var messageBox = document.querySelector('.message-box');

//check if local storage exists
if (localStorage.getItem('local')) {
    let local = JSON.parse(localStorage.getItem('local'));
    local.forEach(element => {
        //add currency to list
        addCurrensyList(element);
    });
}

//changeFrom Input validation
$('#changeFrom').change(function () {
    var selector = document.getElementById('changeFrom');
    var change = selector[selector.selectedIndex].value;
    if (change !== '0') {
        selector.classList.add('valid');
        selector.classList.remove('invalid');
    } else {
        selector.classList.remove('valid');
        selector.classList.add('invalid');
    }
});
//add currency selection to array 
changeToInput.addEventListener('change', e => {
    let changeTo = e.target.value;
    //add currency to list
    addCurrensyList(changeTo);
})

//delete from currency list
list.addEventListener('click', e => {
    if (e.target.classList.contains('delete')) {
        changeToArray = changeToArray.filter(value => {
            return value !== e.target.parentElement.innerText;
        });
        e.target.parentElement.remove();
    }
});

//form submition
form.addEventListener('submit', e => {
    e.preventDefault();

    //field validation before sending AJAX
    if (checkFields()) {
        messageBox.style.display = 'none';
        var changeFromSelection = changeFromInput.options[changeFromInput.selectedIndex].value;

        //set local storage
        setLocalStorage();

        //ajax get currency data
        $.ajax({
            url: "convert.php",
            type: "post",
            data: {
                submit: 'submit',
                changeFromSelection: changeFromSelection,
                changeTo: JSON.stringify(changeToArray),
                amount: form.amount.value,
                web: "web"
            },
            success: function (result) {
                if (result) {
                    result = JSON.parse(result);
                    var table = document.getElementById("myTable");
                    while (table.rows.length > 1) {
                        table.deleteRow(1);
                    }
                    for (var i = 0; i < changeToArray.length; i++) {
                        var row = document.createElement("tr");
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        cell1.innerHTML = changeFromSelection;
                        cell2.innerHTML = changeToArray[i];
                        cell3.innerHTML = parseFloat(result[i] / form.amount.value).toFixed(3);
                        cell4.innerHTML = parseFloat(result[i]).toFixed(3);
                        var table = document.getElementById("myTable");
                        table.appendChild(row);
                    }
                }
            }
        });
    } else {
        messageBox.style.display = 'block';
        messageBox.classList.add('msg');
        var msg = document.querySelector('.msg');
        msg.innerHTML = `<p>Plese check and fill all the fields bellow:</p>
                             <p>You must choose atleast one currency changing from</p>
                             <p>You must choose atleast one currency changing to</p>
                             <p>Amount that you want to exchange must be a valid number</p>
        `;
    }
})

//Fields validation
function checkFields() {
    if (changeFromInput.classList.contains('valid') && changeToArray.length > 0) {
        let amount = Number(form.amount.value);
        if (amount !== 0 && !isNaN(amount)) {
            return true;
        }
    } else {
        return false;
    }
}

//add currency to list
function addCurrensyList(element) {
    var li = document.createElement("li");
    li.innerHTML = `<i class="fas fa-times pointer delete"></i><span>${element}</span>`;
    if (changeToArray.includes(element)) {
        return true;
    } else {
        changeToArray.push(element);
        list.appendChild(li);
    }
}

//set local storage for user prefernces
function setLocalStorage() {
    let local = JSON.stringify(changeToArray);
    localStorage.setItem('local', local);
}