// show hide Add New Candidat form
let addbutton = document.getElementById('addnewbtn');
let candidateform = document.getElementById('candidate-form');

addbutton.addEventListener('click', () => {
    candidateform.classList.add('candidate-active');
});

// close button
function closecandidateform() {
    candidateform.classList.remove('candidate-active');
}

// hide error message (message with add new button)

let error_btn = document.getElementById('close-error');
let error_div = document.getElementById('error-sms-container');

error_btn.addEventListener('click', ()=> {
    error_div.classList.add('hide-error-div');
})

