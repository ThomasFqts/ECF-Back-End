document.getElementById('add-photo-field').addEventListener('click', function () {
    var photoFields = document.getElementById('photo-fields');
    var newField = document.createElement('input');
    newField.type = 'text';
    newField.name = 'photos[]';
    newField.placeholder = 'Nom de la photo';
    photoFields.appendChild(newField);
});