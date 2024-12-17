const selector = document.getElementById("update-account-current-attribute");
selector.addEventListener("change", (e) => {
    const usernameSelector = document.getElementById("update-account-attribute-username");
    const attributeInput = document.getElementById("update-account-attribute-input");
    switch(e.target.value) {
        case "username": {
            usernameSelector.disabled = false;
            attributeInput.disabled = true;
            attributeInput.type = "text";
            attributeInput.value = "";
            break;
        }
        case "password": {
            usernameSelector.disabled = true;
            attributeInput.disabled = false;
            attributeInput.type = "password";
            break;
        }
        default: {
            usernameSelector.disabled = true;
            attributeInput.disabled = false;
            attributeInput.type = "text";
        }
    }
});