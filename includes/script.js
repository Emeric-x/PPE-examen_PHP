let medicament_desc;

function affiche_desc(medicament_desc) {
    alert(medicament_desc);
}

$(document).ready(function() {
    function affichage_Presenters() {
        setTimeout(function() {
            $.ajax({
                type: 'POST',
                url: 'affiche_presenters.php',
                success: (data) => {
                    $('#affichagePresenters').html(data);
                },
                error: function(textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });
        }, 1000);
    }
    affichage_Presenters();
});