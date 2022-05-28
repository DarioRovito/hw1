function verify_Name(event) {
    const name_chosen = event.currentTarget;

    if (formStatus[name_chosen.name] = name_chosen.value.length > 0) {
        name_chosen.parentNode.parentNode.classList.remove('error');
    } else {
        name_chosen.parentNode.parentNode.classList.add('error');
    }
    
    verify();
}

function verify_jsonUsername(json) {
    // Controllo il campo exists ritornato dal JSON
    if (formStatus.username = !json.founds) {
        document.querySelector('.username').classList.remove('error');
    } else {
        document.querySelector('.username span').textContent = "Nome utente già utilizzato";
        document.querySelector('.username').classList.add('error');
    }
    verify();
}

function verify_jsonEmail(json) {
    // Controllo il campo exists ritornato dal JSON
    if (formStatus.email = !json.founds) {
        document.querySelector('.email').classList.remove('error');
    } else {
        document.querySelector('.email span').textContent = "Email già utilizzata";
        document.querySelector('.email').classList.add('error');
    }
    verify();
}

function onResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function verify_Username(event) {
    const username_chosen = document.querySelector('.username input');

    if(!/^[a-zA-Z0-9_]{1,15}$/.test(username_chosen.value)) {
        username_chosen.parentNode.parentNode.querySelector('span').textContent = "Sono ammesse lettere, numeri e underscore. Max. 15";
        username_chosen.parentNode.parentNode.classList.add('error');
        formStatus.username = false;
        checkForm();
    } else {
        fetch("username_check.php?q="+encodeURIComponent(username_chosen.value)).then(onResponse).then(verify_jsonUsername);
    }    
}

function verify_Email(event) {
    const email_chosen = document.querySelector('.email input');
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(email_chosen.value).toLowerCase())) {
        document.querySelector('.email span').textContent = "Email non valida";
        document.querySelector('.email').classList.add('error');
        formStatus.email = false;
        verify();
    } else {
        fetch("email_check.php?q="+encodeURIComponent(String(email_chosen.value).toLowerCase())).then(onResponse).then(verify_jsonEmail);
    }
}

function verify_Password(event) {
    const password_inserted = document.querySelector('.password input');
    if (formStatus.password = password_inserted.value.length >= 8) {
        document.querySelector('.password').classList.remove('error');
    } else {
        document.querySelector('.password').classList.add('error');
    }
    verify();
}

function verify_ConfirmPassword(event) {
    const password_inserted_confirm = document.querySelector('.confirm_password input');
    if (formStatus.confirmPassord = password_inserted_confirm.value === document.querySelector('.password input').value) {
        document.querySelector('.confirm_password').classList.remove('error');
    } else {
        document.querySelector('.confirm_password').classList.add('error');
    }
    verify();
}

function SelectFile(event) {
    upload_original.click();
}

function upload(event) {
    const upload_original = document.getElementById('upload_original');
    document.querySelector('#upload .file_name').textContent = upload_original.files[0].name;
    const o_size = upload_original.files[0].size;
    const mb_size = o_size / 1000000;
    document.querySelector('#upload .file_size').textContent = mb_size.toFixed(2)+" MB";
    const ext = upload_original.files[0].name.split('.').pop();

    if (o_size >= 7000000) {
        document.querySelector('.fileupload span').textContent = "Le dimensioni del file superano 7 MB";
        document.querySelector('.fileupload').classList.add('error');
        formStatus.upload = false;
    } else if (!['jpeg', 'jpg', 'png', 'gif'].includes(ext))  {
        document.querySelector('.fileupload span').textContent = "Le estensioni consentite sono .jpeg, .jpg, .png e .gif";
        document.querySelector('.fileupload').classList.add('error');
        formStatus.upload = false;
    } else {
        document.querySelector('.fileupload').classList.remove('error');
        formStatus.upload = true;
    }
    verify();
}

function verify() {
    // Controlla consenso dati personali
    document.querySelector('#submit').disabled = !document.querySelector('.allow input').checked || 
    // Controlla che tutti i campi siano pieni
    Object.keys(formStatus).length !== 7 || 
    // Controlla che i campi non siano false
    Object.values(formStatus).includes(false);
}

const formStatus = {'upload': true};
document.querySelector('.name input').addEventListener('blur',verify_Name);
document.querySelector('.surname input').addEventListener('blur', verify_Name);
document.querySelector('.username input').addEventListener('blur',verify_Username);
document.querySelector('.email input').addEventListener('blur', verify_Email);
document.querySelector('.password input').addEventListener('blur',verify_Password);
document.querySelector('.confirm_password input').addEventListener('blur', verify_ConfirmPassword);
document.querySelector('#upload').addEventListener('click', SelectFile);
document.querySelector('#upload_original').addEventListener('change', upload);
document.querySelector('.allow input').addEventListener('change', verify);

if (document.querySelector('.error') !== null) {
    verify_Username(); verify_Password; verify_ConfirmPassword(); verify_Email();
    document.querySelector('.name input').dispatchEvent(new Event('blur'));
    document.querySelector('.surname input').dispatchEvent(new Event('blur'));
}


