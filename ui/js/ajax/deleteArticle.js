$(document).ready(function () {

    $body = $('body');

    $body.on('click', '.deleteArticle', function (e) {
        e.preventDefault();
        url = "index.php?o=article&a=deleteAjax&id=" + $(this).attr("data-id");
        $parent = $(this).parent();
        $.ajax({
            type: "GET",
            url: url
        })
            .done(function (response) {
                if (typeof response.message !== 'undefined') {
                    if (response.message === "success") {
                        $parent.remove();
                        if ($("#ajaxSuccessNotification").length) {
                            $("#ajaxSuccessNotification").html("<span class='txt-b'>Ok</span> : Article supprimé !");
                        } else {
                            $("#contentNotification").prepend(
                                "<span id='ajaxSuccessNotification' class='msg-success'>" +
                                "<span class='txt-b'>Ok</span> : Article supprimé !</span>"
                            );
                        }
                    }
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if ($("#ajaxErrorNotification").length) {
                    $("#ajaxErrorNotification").html("<span class='txt-b'>Erreur</span> : une erreur s'est produite !");
                } else {
                    $("#contentNotification").prepend(
                        "<span id='ajaxErrorNotification' class='msg-error'>" +
                        "<span class='txt-b'>Erreur</span> : une erreur s'est produite !</span>"
                    );
                }
            });
    });
});