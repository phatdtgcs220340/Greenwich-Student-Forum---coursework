function toggleUpdateForm(_content, _updateForm, _editContent) {
    var content = document.getElementById(_content);
    var form = document.getElementById(_updateForm);
    document.getElementById(_editContent).value = content.innerHTML;
    if (form.classList.contains("hidden")) {
        form.classList.remove("hidden");
        content.classList.add("hidden");
    } else {
        form.classList.add("hidden");
        content.classList.remove("hidden");
    }
}