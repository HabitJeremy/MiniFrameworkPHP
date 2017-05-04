$(document).ready(function () {

    $body = $('body');

    $body.on('click', '.changePublicationArticle', function (e) {
        e.preventDefault();
        url = "index.php?o=article&a=changePublicationAjax&id=" + $(this).attr("data-id");
        $parent = $(this).parent();
        $.ajax({
            type: "GET",
            url: url
        })
            .done(function (response) {
                if (typeof response.message !== 'undefined') {
                    if (response.message === "success") {

                        /* suppression de l'article dans le dom */


                        /* message de notification */
                        if ($("#ajaxSuccessNotification").length) {
                            $("#ajaxSuccessNotification").html("<span class='txt-b'>Ok</span> : Publication modifiée !");
                        } else {
                            $("#contentNotification").prepend(
                                "<span id='ajaxSuccessNotification' class='msg-success'>" +
                                "<span class='txt-b'>Ok</span> : Publication modifiée </span>"
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