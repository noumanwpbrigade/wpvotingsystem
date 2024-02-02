// show / hide logout button
function showbtn() {
    let logoutbtn = document.getElementById('logoutbtn');
    if(logoutbtn.style.display === 'none') {
        logoutbtn.style.display = 'block';
    }
    else {
        logoutbtn.style.display = 'none';
    }
}
