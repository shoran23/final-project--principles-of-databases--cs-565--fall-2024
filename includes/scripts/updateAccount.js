const selector = document.getElementById("update-account-current-attribute");
selector.addEventListener("change", (e) => {
    const usernameSelector = document.getElementById("update-account-attribute-username");
    const attributeInput = document.getElementById("update-account-attribute-input");
    if(e.target.value === "username") {
        usernameSelector.disabled = false;
        attributeInput.disabled = true;
    } else {
        usernameSelector.disabled = true;
        attributeInput.disabled = false;
    }
});