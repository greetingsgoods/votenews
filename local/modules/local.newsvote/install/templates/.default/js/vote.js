$(document).ready(function () {
    $(".vote-form a").click(function () {
        var src = $("#selffolder").val() + "/ajax.php";
        var elementID = $("#elementID").val();
        var userID = $("#user").val();
        var iblockID = $("#iblockID").val();
        var type = $(this).attr('class');


        $.ajax({
            type: "POST",
            url: src,
            cashe: false,
            data: {elementID: elementID, userID: userID, type: type, iblockID: iblockID}
        })
            .done(function (msg) {
                var parts = msg.split("/");
                $(".like").text(parts[0]);
                $(".dislike").text(parts[1]);
            });

        return false;
    });
});
