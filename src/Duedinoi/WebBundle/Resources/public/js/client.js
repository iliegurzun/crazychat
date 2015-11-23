function getContent(timestamp)
{
    var queryString = {'timestamp': timestamp};
    $.get(loadurl, queryString, function (data)
    {
        $('#response').html(data.content);
        // reconecta ao receber uma resposta do servidor
        getContent(data.timestamp);
    }).fail(function (data) {
        console.log(data);
//        getContent(timestamp);
    });
}

$(document).ready(function ()
{
    getContent();
});

