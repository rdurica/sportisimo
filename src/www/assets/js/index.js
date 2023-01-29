function showEditForm(id, text) {
    let instance = M.Modal.getInstance(document.getElementById('modalBrandForm'));
    naja.makeRequest('GET', "/homepage/default/" + id + "?do=EditId")
        .then(payload => {
            document.getElementById("brand-form-header").innerText = "Upravit značku";
            document.getElementById("frm-brandForm-brandForm-title").value = text;
            M.updateTextFields();
            instance.open();
        });

    instance.options.onCloseEnd = () => {
        naja.makeRequest('GET', "/homepage/default/0?do=EditId");
    }

}

function showAddForm() {
    let instance = M.Modal.getInstance(document.getElementById('modalBrandForm'))
    document.getElementById("brand-form-header").innerText = "Přidat značku";
    document.getElementById("frm-brandForm-brandForm-title").value = "";
    document.getElementById("frm-brandForm-brandForm-title").focus();
    instance.open();
}