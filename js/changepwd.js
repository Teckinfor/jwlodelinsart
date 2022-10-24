function displaychangepwd(){
    document.getElementById("navbarNavDropdown").classList.remove("show");
    document.getElementById("changepwdpannel").style.display = "flex";
    setTimeout(() => {
        document.getElementsByClassName("glass")[0].style.transform = "translateY(0%)"
    }, 50);
}

function hidechangepwd(){
    document.getElementsByClassName("glass")[0].style.transform = "translateY(-100%)";
    setTimeout(() => {
        document.getElementById("changepwdpannel").style.display = "none";
    }, 1010);
}