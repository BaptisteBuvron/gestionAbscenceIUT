var addAbsenceBtn = document.getElementById('add-abscence');
addAbsenceBtn.addEventListener('click', function () {
    // Je récupère le numéro des futurs champs
    var widgetCounter = document.getElementById("widgets-counter");
    const index = widgetCounter.value;
    console.log(index);

    //Je récupère le prototype des entrées.
    var absencePrototype = document.getElementById('absences_report_absences');
    const tmpl = absencePrototype.getAttribute('data-prototype').replace(/__name__/g, index);

    //J'injecte ce code au sein de la div
    var absencesReportAbsences = document.getElementById('absences_report_absences');
    absencesReportAbsences.insertAdjacentHTML('beforeend',tmpl);
    widgetCounter.value = parseInt(index) + 1;
    handleDeleteButtons();
});


function handleDeleteButtons() {
    document.querySelectorAll('button[data-action="delete"]').forEach(function (button) {
        button.addEventListener('click', function () {
            console.log('delete');
            const target = button.dataset.target;
            document.getElementById(target.substring(1)).remove();
        });
    });
}

function updateCounter(){
    const count = document.querySelectorAll('#absences_report_absences div.form-group').length;
    document.getElementById("widgets-counter").value = count;
}

updateCounter();

handleDeleteButtons();
